<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }
    
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(auth()->id())
            ],
        ]);
        
        // Update the full name as well for backward compatibility
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];
        
        auth()->user()->update($validated);
        
        return back()->with('success', __('Profile Updated'));
    }
    
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // 2MB max
        ]);
        
        $user = auth()->user();
        
        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        
        $user->update(['avatar' => $path]);
        
        return back()->with('success', __('Avatar Updated'));
    }
    
    public function updateAppearance(Request $request)
    {
        $data = [
            'dark_mode' => $request->has('dark_mode'),
            'currency' => $request->input('currency', 'USD ($)'),
        ];
        
        // Validate the inputs
        $request->validate([
            'currency' => 'nullable|string|in:USD ($),EUR (€),GBP (£),PHP (₱)',
        ]);
        
        auth()->user()->update($data);
        
        return back()->with('success', __('Currency Updated'));
    }
    

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        
        if (!Hash::check($validated['current_password'], auth()->user()->password)) {
            return back()->withErrors(['current_password' => __('Current Password Incorrect')]);
        }
        
        auth()->user()->update([
            'password' => Hash::make($validated['new_password'])
        ]);
        
        return back()->with('success', __('Password_ Updated'));
    }
    
    public function deleteAccount(Request $request)
    {
        $user = auth()->user();
        
        // Delete avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        Auth::logout();
        
        // Delete user (cascade will handle related records)
        $user->delete();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', __('Account Deleted'));
    }
}