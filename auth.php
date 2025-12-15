<?php
session_start();
require_once __DIR__ . '/db.php';

$action = $_POST['action'] ?? '';

if ($action === 'register') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($name === '' || $email === '' || $password === '' || $confirmPassword === '') {
        redirectWithError('All fields are required.', 'register');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirectWithError('Please enter a valid email address.', 'register');
    }

    if (strlen($password) < 8) {
        redirectWithError('Password must be at least 8 characters long.', 'register');
    }

    if ($password !== $confirmPassword) {
        redirectWithError('Passwords do not match.', 'register');
    }

    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        redirectWithError('An account with that email already exists.', 'register');
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $insert = $pdo->prepare('INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :password_hash)');
    $insert->execute([
        ':name' => $name,
        ':email' => $email,
        ':password_hash' => $passwordHash,
    ]);

    $userId = $pdo->lastInsertId();
    $_SESSION['user_id'] = $userId;
    $_SESSION['name'] = $name;

    header('Location: dashboard.php');
    exit;
}

if ($action === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        redirectWithError('Email and password are required.', 'login');
    }

    $stmt = $pdo->prepare('SELECT id, name, password_hash FROM users WHERE email = :email');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        redirectWithError('Invalid email or password.', 'login');
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];

    header('Location: dashboard.php');
    exit;
}

redirectWithError('Invalid request.', 'login');

function redirectWithError(string $message, string $tab = 'login'): void
{
    $query = http_build_query([
        'error' => $message,
        'tab' => $tab,
    ]);
    header("Location: index.php?{$query}");
    exit;
}
