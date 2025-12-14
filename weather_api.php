<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get user's location from request or use default
$city = $_GET['city'] ?? 'Quezon City';
$country = $_GET['country'] ?? 'PH';

// OpenWeatherMap API (you need to sign up for a free API key at https://openweathermap.org/api)
$apiKey = 'YOUR_API_KEY_HERE'; // Replace with your actual API key
$url = "https://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&units=metric&appid={$apiKey}";

// Fetch weather data
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    echo json_encode([
        'error' => 'Unable to fetch weather',
        'temp' => '--',
        'description' => 'N/A',
        'icon' => '🌍'
    ]);
    exit;
}

$data = json_decode($response, true);

// Map weather condition to emoji
$weatherIcons = [
    'Clear' => '☀️',
    'Clouds' => '☁️',
    'Rain' => '🌧️',
    'Drizzle' => '🌦️',
    'Thunderstorm' => '⛈️',
    'Snow' => '❄️',
    'Mist' => '🌫️',
    'Smoke' => '🌫️',
    'Haze' => '🌫️',
    'Dust' => '🌫️',
    'Fog' => '🌫️',
];

$condition = $data['weather'][0]['main'] ?? 'Clear';
$icon = $weatherIcons[$condition] ?? '🌍';

echo json_encode([
    'temp' => round($data['main']['temp']),
    'description' => $data['weather'][0]['description'] ?? 'N/A',
    'icon' => $icon,
    'city' => $data['name'] ?? $city,
    'humidity' => $data['main']['humidity'] ?? 0,
    'feels_like' => round($data['main']['feels_like'] ?? 0)
]);