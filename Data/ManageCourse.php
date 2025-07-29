<?php
header('Content-Type: application/json');
include 'DbConnect.php';
$conn = getDbConnection();

$collegeId = $_GET['college_id'] ?? null;

// Get the raw JSON input (Syncfusion sends it as JSON)
$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

// Detect action
$action = $_SERVER['REQUEST_METHOD'] === 'GET' ? 'read' : ($data['action'] ?? '');

// READ
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!$collegeId) {
        echo json_encode([]);
        exit;
    }
    $stmt = $conn->prepare("SELECT Id AS id, CourseName AS name FROM Course WHERE CollegeId = ?");
    $stmt->bind_param("i", $collegeId);
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
    $courseName = $data['value']['name'] ?? '';
    $collegeId = $collegeId ?? $data['value']['college_id'] ?? null;

    if (empty($courseName) || !$collegeId) {
        http_response_code(400);
        echo json_encode(['error' => 'Name and College ID are required']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO Course (CourseName, CollegeId) VALUES (?, ?)");
    $stmt->bind_param("si", $courseName, $collegeId);
    $stmt->execute();
    $insertedId = $stmt->insert_id;

    echo json_encode([
        'id' => $insertedId,
        'name' => $courseName,
        'college_id' => $collegeId
    ]);
    exit;
}

// UPDATE
if ($action === 'update') {
    $id = $data['value']['id'] ?? null;
    $name = $data['value']['name'] ?? '';

    if (!$id || !$name) {
        http_response_code(400);
        echo json_encode(['error' => 'ID and name are required']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE Course SET CourseName = ? WHERE Id = ?");
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

    $stmt = $conn->prepare("DELETE FROM Course WHERE Id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(['id' => $id]);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Invalid request']);
?>
