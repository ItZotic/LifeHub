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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366F1;
            --primary-dark: #4F46E5;
            --bg: #F8F9FD;
            --card: #fff;
            --border: #E5E7EB;
            --text: #1F2937;
            --text-light: #6B7280;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        
        * { 
            box-sizing: border-box; 
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }
        
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 32px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .brand {
            font-weight: 700;
            font-size: 22px;
            color: var(--primary);
            letter-spacing: -0.5px;
        }
        
        .user-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .welcome-text {
            color: var(--text-light);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .user-name {
            color: var(--text);
            font-weight: 600;
        }
        
        .logout-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .logout-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 32px;
        }
        
        .dashboard-header {
            margin-bottom: 32px;
        }
        
        .dashboard-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }
        
        .dashboard-subtitle {
            color: var(--text-light);
            font-size: 15px;
        }
        
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }
        
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 32px 24px;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #8B5CF6);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .card:hover::before {
            opacity: 1;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border-color: var(--primary);
        }
        
        .card-icon {
            font-size: 48px;
            margin-bottom: 16px;
            filter: grayscale(0.3);
            transition: all 0.3s;
        }
        
        .card:hover .card-icon {
            filter: grayscale(0);
            transform: scale(1.1);
        }
        
        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }
        
        .card-description {
            font-size: 14px;
            color: var(--text-light);
            line-height: 1.5;
        }
        
        .weather-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        
        .weather-card::before {
            display: none;
        }
        
        .weather-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4);
        }
        
        .weather-icon {
            font-size: 64px;
            margin-bottom: 12px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .weather-temp {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .weather-desc {
            font-size: 16px;
            font-weight: 500;
            opacity: 0.95;
            text-transform: capitalize;
            margin-bottom: 4px;
        }
        
        .weather-location {
            font-size: 13px;
            opacity: 0.85;
        }
        
        .loading {
            font-size: 15px;
            opacity: 0.9;
        }
        
        .card-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--primary);
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        @media (max-width: 768px) {
            header {
                padding: 16px 20px;
            }
            
            .welcome-text {
                display: none;
            }
            
            main {
                padding: 24px 20px;
            }
            
            .dashboard-title {
                font-size: 24px;
            }
            
            .cards-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="brand">LifeHub</div>
        <div class="user-section">
            <div class="welcome-text">
                <span>👋</span>
                <span>Welcome, <span class="user-name"><?php echo $name; ?></span></span>
            </div>
            <a class="logout-btn" href="?action=logout">Logout</a>
        </div>
    </header>
    
    <main>
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">Manage your daily activities and track your progress</p>
        </div>
        
        <div class="cards-grid">
            <div class="card">
                <span class="card-badge">Coming Soon</span>
                <div class="card-icon">✅</div>
                <h3 class="card-title">Tasks</h3>
                <p class="card-description">Organize and track your daily tasks</p>
            </div>
            
            <div class="card">
                <span class="card-badge">Coming Soon</span>
                <div class="card-icon">🎯</div>
                <h3 class="card-title">Habits</h3>
                <p class="card-description">Build and maintain healthy habits</p>
            </div>
            
            <div class="card">
                <span class="card-badge">Coming Soon</span>
                <div class="card-icon">💰</div>
                <h3 class="card-title">Wallet</h3>
                <p class="card-description">Track your expenses and income</p>
            </div>
            
            <div class="card">
                <span class="card-badge">Coming Soon</span>
                <div class="card-icon">❤️</div>
                <h3 class="card-title">Health</h3>
                <p class="card-description">Monitor your health and fitness</p>
            </div>
            
            <div class="card weather-card" id="weatherCard">
                <div class="loading">Loading weather...</div>
            </div>
        </div>
    </main>

    <script>
        async function loadWeather() {
            const card = document.getElementById('weatherCard');
            
            try {
                const response = await fetch('weather_api.php?city=Quezon City&country=PH');
                const data = await response.json();
                
                if (data.error) {
                    card.innerHTML = `
                        <div class="weather-icon">🌍</div>
                        <div class="weather-desc">Weather unavailable</div>
                    `;
                    return;
                }
                
                card.innerHTML = `
                    <div class="weather-icon">${data.icon}</div>
                    <div class="weather-temp">${data.temp}°C</div>
                    <div class="weather-desc">${data.description}</div>
                    <div class="weather-location">${data.city}</div>
                `;
            } catch (error) {
                card.innerHTML = `
                    <div class="weather-icon">🌍</div>
                    <div class="weather-desc">Weather unavailable</div>
                `;
            }
        }

        loadWeather();
        setInterval(loadWeather, 600000); // Refresh every 10 minutes
    </script>
</body>
</html>