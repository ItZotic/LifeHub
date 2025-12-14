<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeHub | Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3B82F6;
            --bg: #f6f7fb;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
        }
        .container {
            max-width: 1100px;
            width: 100%;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.08);
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            overflow: hidden;
        }
        .left {
            padding: 48px;
            background: linear-gradient(120deg, rgba(59, 130, 246, 0.06), rgba(59, 130, 246, 0));
        }
        .brand {
            font-weight: 700;
            font-size: 18px;
            letter-spacing: 0.5px;
            color: var(--primary);
            margin-bottom: 32px;
        }
        .hero-title {
            font-size: 32px;
            margin: 0 0 12px;
        }
        .hero-subtitle {
            color: var(--muted);
            margin: 0 0 32px;
            line-height: 1.5;
        }
        .preview-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }
        .preview {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 10px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 12px;
        }
        .right {
            padding: 48px 40px;
            background: #fff;
        }
        .tabs {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            margin-bottom: 24px;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }
        .tab {
            padding: 12px 0;
            text-align: center;
            font-weight: 600;
            cursor: pointer;
            color: var(--muted);
            background: #f9fafb;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
            display: block;
        }
        .tab.active {
            color: #fff;
            background: var(--primary);
        }
        .field {
            margin-bottom: 16px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 14px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid var(--border);
            font-size: 15px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: var(--primary);
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }
        .btn:hover { background: #316bce; }
        .btn:active { transform: translateY(1px); }
        .switch-text {
            text-align: center;
            margin-top: 14px;
            color: var(--muted);
            font-size: 14px;
        }
        .switch-text a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 16px;
        }
        .alert.error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert.success { background: #ecfdf3; color: #166534; border: 1px solid #bbf7d0; }
        @media (max-width: 960px) {
            .container { grid-template-columns: 1fr; }
            .left { display: none; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="left">
        <div class="brand">LifeHub</div>
        <h1 class="hero-title">LifeHub — Your Personal Productivity HQ</h1>
        <p class="hero-subtitle">Track your tasks, habits, expenses, health, and weather in one smart dashboard.</p>
        <div class="preview-grid">
            <div class="preview">📊 Dashboard</div>
            <div class="preview">✓ Tasks</div>
            <div class="preview">💰 Wallet</div>
        </div>
    </div>
    <div class="right">
        <div class="tabs">
            <a href="{{ route('login') }}" class="tab {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            <a href="{{ route('register') }}" class="tab {{ request()->routeIs('register') ? 'active' : '' }}">Create Account</a>
        </div>

        @if ($errors->any())
            <div class="alert error">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if (request()->routeIs('login'))
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="field">
                <label for="login-email">Email</label>
                <input id="login-email" type="email" name="email" required placeholder="you@example.com" value="{{ old('email') }}">
            </div>
            <div class="field">
                <label for="login-password">Password</label>
                <input id="login-password" type="password" name="password" required placeholder="••••••••">
            </div>
            <button class="btn" type="submit">Sign In</button>
            <div class="switch-text">Don't have an account? <a href="{{ route('register') }}">Create one</a></div>
        </form>
        @else
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="field">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" required placeholder="Your name" value="{{ old('name') }}">
            </div>
            <div class="field">
                <label for="register-email">Email</label>
                <input id="register-email" type="email" name="email" required placeholder="you@example.com" value="{{ old('email') }}">
            </div>
            <div class="field">
                <label for="register-password">Password</label>
                <input id="register-password" type="password" name="password" required minlength="8" placeholder="At least 8 characters">
            </div>
            <div class="field">
                <label for="confirm-password">Confirm Password</label>
                <input id="confirm-password" type="password" name="password_confirmation" required minlength="8" placeholder="Repeat password">
            </div>
            <button class="btn" type="submit">Create Account</button>
            <div class="switch-text">Already have an account? <a href="{{ route('login') }}">Sign in</a></div>
        </form>
        @endif
    </div>
</div>
</body>
</html>