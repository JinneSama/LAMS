<?php
header('Content-Type: application/json');
include 'DbConnect.php';
$conn = getDbConnection();

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);
$action = $method === 'GET' ? 'read' : ($data['action'] ?? '');

if ($action === 'insert') {
    $username = $data['value']['username'] ?? '';
    $password = $data['value']['password'] ?? '';
    $confirm = $data['value']['confirm_password'] ?? '';
    $roleId = $data['value']['RoleId'] ?? null;

    if (!$username || !$password || !$confirm || $password !== $confirm || !$roleId) {
        http_response_code(400);
        echo json_encode(['error' => 'All fields required and passwords must match']);
        exit;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO Users (username, password, RoleId) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $hashed, $roleId);
    $stmt->execute();
    echo json_encode(['Id' => $stmt->insert_id, 'username' => $username, 'RoleId' => $roleId]);
    exit;
}

if ($action === 'update') {
    $id = $data['value']['Id'] ?? null;
    $username = $data['value']['username'] ?? '';
    $roleId = $data['value']['RoleId'] ?? null;

    if (!$id || !$username || !$roleId) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing fields']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE Users SET username = ?, RoleId = ? WHERE Id = ?");
    $stmt->bind_param("sii", $username, $roleId, $id);
    $stmt->execute();
    echo json_encode(['Id' => $id, 'username' => $username, 'RoleId' => $roleId]);
    exit;
}

if ($action === 'remove') {
    $id = $data['key'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'ID required']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM Users WHERE Id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(['Id' => $id]);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Invalid action']);
