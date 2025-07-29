<?php
header('Content-Type: application/json');
include 'DbConnect.php';
$conn = getDbConnection();

$method = $_SERVER['REQUEST_METHOD'];
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);
$action = $data['action'] ?? '';

if ($method === 'GET') {
    echo json_encode([]);
    exit;
}

// Insert
if ($action === 'insert') {
    $d = $data['value'];

    $timestamp = strtotime($d['date_enrolled']);
    if (!$timestamp) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid date format: ' . $d['date_enrolled']]);
        exit;
    }

    $newDate = date('Y-m-d H:i:s', $timestamp);

    $stmt = $conn->prepare("INSERT INTO Attendee (FirstName, MiddleName, LastName, NameExt, Course, Year, DateEnrolled, SchoolId, ImagePath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiisss", $d['first_name'], $d['middle_name'], $d['last_name'], $d['name_ext'], $d['course_id'], $d['year'], $newDate, $d['school_id'], $d['image_path']);
    $stmt->execute();

    echo json_encode(array_merge($d, ['id' => $stmt->insert_id]));
    exit;
}


// Update
if ($action === 'update') {
    $d = $data['value'];
    $timestamp = strtotime($d['date_enrolled']);
    if (!$timestamp) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid date format: ' . $d['date_enrolled']]);
        exit;
    }

    $newDate = date('Y-m-d H:i:s', $timestamp);

    $stmt = $conn->prepare("UPDATE Attendee SET FirstName=?, MiddleName=?, LastName=?, NameExt=?, Course=?, Year=?, DateEnrolled=?, SchoolId=?, ImagePath=? WHERE Id=?");
    $stmt->bind_param("ssssiisssi", $d['first_name'], $d['middle_name'], $d['last_name'], $d['name_ext'], $d['course_id'], $d['year'], $newDate, $d['school_id'], $d['image_path'], $d['id']);
    $stmt->execute();
    if ($stmt->error) {
        error_log("MySQL Error: " . $stmt->error);
    }
    echo json_encode($d);
    exit;
}

// Delete
if ($action === 'remove') {
    $id = $data['key'];
    $stmt = $conn->prepare("DELETE FROM Attendee WHERE Id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(['id' => $id]);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Invalid request']);
