<?php
require_once __DIR__ . '/../auth.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$result = loginUser($_POST);

if ($result['success']) {
    echo json_encode([
        'success' => true,
        'redirect' => 'index.php?page=home',
        'user' => $result['user']
    ]);
} else {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'error' => $result['error']
    ]);
}
?>