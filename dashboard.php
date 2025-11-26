<?php
session_start();

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$name = htmlspecialchars($_SESSION['name'] ?? 'User', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeHub Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3B82F6;
            --bg: #f4f5f7;
            --card: #fff;
            --border: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 28px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .brand {
            font-weight: 800;
            color: var(--primary);
            font-size: 20px;
        }
        .user {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--muted);
        }
        .logout {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            border: 1px solid var(--primary);
            padding: 8px 12px;
            border-radius: 8px;
        }
        main {
            padding: 32px;
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: var(--text);
        }
    </style>
</head>
<body>
<header>
    <div class="brand">LifeHub</div>
    <div class="user">
        <span>Welcome, <?php echo $name; ?></span>
        <a class="logout" href="?action=logout">Logout</a>
    </div>
</header>
<main>
    <div class="card">Tasks</div>
    <div class="card">Habits</div>
    <div class="card">Wallet</div>
    <div class="card">Health</div>
    <div class="card">Weather</div>
</main>
</body>
</html>
