<?php
header('Content-Type: application/json');
include 'DbConnect.php';
$conn = getDbConnection();

// Get raw input
$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

// Detect request method and action
$method = $_SERVER['REQUEST_METHOD'];
$action = $method === 'GET' ? 'read' : ($data['action'] ?? '');

// ADD
if ($action === 'insert') {
    $roleName = $data['value']['name'] ?? '';

    if (empty($roleName)) {
        http_response_code(400);
        echo json_encode(['error' => 'Name is required']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO Roles (RoleName) VALUES (?)");
    $stmt->bind_param("s", $roleName);
    $stmt->execute();
    $insertedId = $stmt->insert_id;

    echo json_encode([
        'id' => $insertedId,
        'name' => $roleName
    ]);
    exit;
}

// UPDATE
if ($action === 'update') {
    $id = $data['value']['id'] ?? null;
    $name = $data['value']['name'] ?? '';

    if (!$id || empty($name)) {
        http_response_code(400);
        echo json_encode(['error' => 'ID and name are required']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE Roles SET RoleName = ? WHERE Id = ?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();

    echo json_encode(['id' => $id, 'name' => $name]);
    exit;
}

// DELETE
if ($action === 'remove') {
    $id = $data['key'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'ID is required']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM Roles WHERE Id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(['id' => $id]);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Invalid request']);
