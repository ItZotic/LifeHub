<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LifeHub - Your Personal Productivity HQ')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3B82F6;
            --bg: #f4f5f7;
            --card: #fff;
            --border: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
            --sidebar: #ffffff;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 270px;
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 100;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 24px;
            font-weight: 700;
            font-size: 20px;
            color: var(--text);
            border-bottom: 1px solid var(--border);
        }
        .logo {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }
        .nav {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: var(--muted);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            margin-bottom: 4px;
        }
        .nav-item:hover {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
        }
        .nav-item.active {
            background: var(--primary);
            color: white;
        }
        .user-section {
            padding: 16px;
            border-top: 1px solid var(--border);
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 10px;
            background: rgba(59, 130, 246, 0.05);
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }
        .user-details {
            flex: 1;
            min-width: 0;
        }
        .user-name {
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-email {
            font-size: 12px;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .logout-btn {
            padding: 8px 12px;
            border: none;
            background: none;
            color: var(--muted);
            cursor: pointer;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 600;
            width: 100%;
            margin-top: 8px;
            transition: all 0.2s;
        }
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        .main-content {
            margin-left: 270px;
            flex: 1;
            padding: 32px;
            overflow-y: auto;
            min-height: 100vh;
        }
        .page-header {
            margin-bottom: 32px;
        }
        .page-title {
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 8px;
        }
        .page-subtitle {
            color: var(--muted);
            margin: 0;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <aside class="sidebar">
        <div class="brand">
            <div class="logo">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </div>
            LifeHub
        </div>
        
        <nav class="nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('tasks.index') }}" class="nav-item {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                </svg>
                Tasks
            </a>
            <a href="{{ route('habits.index') }}" class="nav-item {{ request()->routeIs('habits.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                Habits
            </a>
            <a href="{{ route('wallet.index') }}" class="nav-item {{ request()->routeIs('wallet.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                    <path d="M7 15h0M2 9.5h20"/>
                </svg>
                Wallet
            </a>
            <a href="#" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                </svg>
                Health
            </a>
            <a href="#" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 10h-1.26A8 8 0 109 20h9a5 5 0 000-10z"/>
                </svg>
                Weather
            </a>
            <a href="{{ route('settings.index') }}" class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M12 1v6m0 6v6m8.66-10l-5.2 3m-3.46 2l-5.2 3M3.34 7l5.2 3m3.46 2l5.2 3"/>
                </svg>
                Settings
            </a>
        </nav>
        
        <div class="user-section">
            <div class="user-info">
                <div class="user-avatar">
                    {{ auth()->user()->initials }}
                </div>
                <div class="user-details">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        @if(session('success'))
        <div style="padding: 12px 16px; background: #ecfdf3; color: #166534; border: 1px solid #bbf7d0; border-radius: 10px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div style="padding: 12px 16px; background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; border-radius: 10px; margin-bottom: 20px;">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>