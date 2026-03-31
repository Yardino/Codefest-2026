<?php
// server/auth.php

require_once __DIR__ . '/db.php';

function jsonResponse(array $payload, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function getUserByEmail(string $email): ?array {
    $stmt = db()->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    return $user ?: null;
}

function getUserById(int $id): ?array {
    $stmt = db()->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    return $user ?: null;
}

function loginSetSession(array $user): void {
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role'],
    ];
}

function logout(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}

function registerUser(array $data): array {
    $name = trim($data['fullName'] ?? $data['name'] ?? '');
    $email = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $data['password'] ?? '';
    $confirm = $data['confirm_password'] ?? '';

    if (!$name || !$email || !$password || !$confirm) {
        return ['success' => false, 'error' => 'Please fill in all fields'];
    }

    if ($password !== $confirm) {
        return ['success' => false, 'error' => 'Passwords do not match'];
    }

    if (strlen($password) < 6) {
        return ['success' => false, 'error' => 'Password must be at least 6 characters'];
    }

    if (getUserByEmail($email)) {
        return ['success' => false, 'error' => 'Email already registered'];
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = db()->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
    $stmt->execute([$name, $email, $passwordHash]);

    $userId = (int)db()->lastInsertId();
    $user = getUserById($userId);

    if ($user) {
        loginSetSession($user);
        return ['success' => true, 'user' => $user];
    }

    return ['success' => false, 'error' => 'Could not create user'];
}

function loginUser(array $data): array {
    $email = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $data['password'] ?? '';

    if (!$email || !$password) {
        return ['success' => false, 'error' => 'Please enter email and password'];
    }

    $user = getUserByEmail($email);
    if (!$user || !password_verify($password, $user['password_hash'])) {
        return ['success' => false, 'error' => 'Invalid email or password'];
    }

    loginSetSession($user);
    return ['success' => true, 'user' => $user];
}
