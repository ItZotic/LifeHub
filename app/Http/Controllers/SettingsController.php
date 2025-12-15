<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }
    
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);
        
        auth()->user()->update($validated);
        
        return back()->with('success', 'Profile updated successfully!');
    }
    
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        
        if (!Hash::check($validated['current_password'], auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        
        auth()->user()->update([
            'password' => Hash::make($validated['new_password'])
        ]);
        
        return back()->with('success', 'Password updated successfully!');
    }
    
    public function deleteAccount(Request $request)
    {
        $user = auth()->user();
        Auth::logout();
        $user->delete();
        
        return redirect()->route('login')->with('success', 'Account deleted successfully!');
    }
}