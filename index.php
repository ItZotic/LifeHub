<?php
session_start();
$activeTab = $_GET['tab'] ?? 'login';
$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';
?>
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
        }
        .preview img {
            width: 100%;
            display: block;
            border-radius: 8px;
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
        }
        .tab.active {
            color: #fff;
            background: var(--primary);
        }
        form {
            display: none;
        }
        form.active {
            display: block;
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
        <h1 class="hero-title">LifeHub – Your Personal Productivity HQ</h1>
        <p class="hero-subtitle">Track your tasks, habits, expenses, health, and weather in one smart dashboard.</p>
        <div class="preview-grid">
            <div class="preview"><img src="assets/dashboard.png" alt="Dashboard preview"></div>
            <div class="preview"><img src="assets/tasks.png" alt="Tasks preview"></div>
            <div class="preview"><img src="assets/wallet.png" alt="Wallet preview"></div>
        </div>
    </div>
    <div class="right">
        <div class="tabs">
            <div class="tab" data-tab="login">Login</div>
            <div class="tab" data-tab="register">Create Account</div>
        </div>

        <?php if ($error): ?>
            <div class="alert error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <?php if ($message): ?>
            <div class="alert success"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <form id="login" class="auth-form" method="POST" action="auth.php">
            <input type="hidden" name="action" value="login">
            <div class="field">
                <label for="login-email">Email</label>
                <input id="login-email" type="email" name="email" required placeholder="you@example.com">
            </div>
            <div class="field">
                <label for="login-password">Password</label>
                <input id="login-password" type="password" name="password" required placeholder="••••••••">
            </div>
            <button class="btn" type="submit">Sign In</button>
            <div class="switch-text">Don't have an account? <a href="#" data-switch="register">Create one</a></div>
        </form>

        <form id="register" class="auth-form" method="POST" action="auth.php">
            <input type="hidden" name="action" value="register">
            <div class="field">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" required placeholder="Your name">
            </div>
            <div class="field">
                <label for="register-email">Email</label>
                <input id="register-email" type="email" name="email" required placeholder="you@example.com">
            </div>
            <div class="field">
                <label for="register-password">Password</label>
                <input id="register-password" type="password" name="password" required minlength="8" placeholder="At least 8 characters">
            </div>
            <div class="field">
                <label for="confirm-password">Confirm Password</label>
                <input id="confirm-password" type="password" name="confirm_password" required minlength="8" placeholder="Repeat password">
            </div>
            <button class="btn" type="submit">Create Account</button>
            <div class="switch-text">Already have an account? <a href="#" data-switch="login">Sign in</a></div>
        </form>
    </div>
</div>
<script>
    const tabs = document.querySelectorAll('.tab');
    const forms = {
        login: document.getElementById('login'),
        register: document.getElementById('register'),
    };

    function activate(tab) {
        tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === tab));
        Object.keys(forms).forEach(key => {
            forms[key].classList.toggle('active', key === tab);
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => activate(tab.dataset.tab));
    });

    document.querySelectorAll('[data-switch]').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            activate(link.dataset.switch);
        });
    });

    activate('<?php echo $activeTab === 'register' ? 'register' : 'login'; ?>');
</script>
</body>
</html>
