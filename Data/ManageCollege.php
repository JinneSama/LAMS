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

// READ
if ($method === 'GET') {
    $stmt = $conn->prepare("SELECT Id AS id, CollegeName AS name FROM College");
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode([
        'result' => $rows,
        'count' => count($rows)
    ]);
    exit;
}

// ADD
if ($action === 'insert') {
    $collegeName = $data['value']['name'] ?? '';

    if (empty($collegeName)) {
        http_response_code(400);
        echo json_encode(['error' => 'Name is required']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO College (CollegeName) VALUES (?)");
    $stmt->bind_param("s", $collegeName);
    $stmt->execute();
    $insertedId = $stmt->insert_id;

    echo json_encode([
        'id' => $insertedId,
        'name' => $collegeName
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

    $stmt = $conn->prepare("UPDATE College SET CollegeName = ? WHERE Id = ?");
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

    $stmt = $conn->prepare("DELETE FROM College WHERE Id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(['id' => $id]);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Invalid request']);
