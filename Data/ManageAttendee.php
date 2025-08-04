<?php
header('Content-Type: application/json');
include 'DbConnect.php';
$conn = getDbConnection();

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? null;

    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $lastName = $_POST['last_name'];
    $nameExt = $_POST['name_ext'];
    $courseId = $_POST['course_id'];
    $year = $_POST['year'];
    $dateEnrolled = $_POST['date_enrolled'];
    $schoolId = $_POST['school_id'];
    $timestamp = strtotime($dateEnrolled);
    $formattedDate = date('Y-m-d H:i:s', $timestamp);

    // Handle image
    $imagePath = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = time() . '_' . basename($_FILES['photo']['name']);
        $targetPath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
            $imagePath = 'uploads/' . $filename;
        }
    }

    if ($action === 'insert') {
        $stmt = $conn->prepare("INSERT INTO Attendee (FirstName, MiddleName, LastName, NameExt, Course, Year, DateEnrolled, SchoolId, ImagePath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiisss", $firstName, $middleName, $lastName, $nameExt, $courseId, $year, $formattedDate, $schoolId, $imagePath);
        $stmt->execute();

        echo json_encode(['id' => $stmt->insert_id]);
        exit;
    }

    if ($action === 'update') {
        $stmt = $conn->prepare("UPDATE Attendee SET FirstName=?, MiddleName=?, LastName=?, NameExt=?, Course=?, Year=?, DateEnrolled=?, SchoolId=?, ImagePath=IFNULL(?, ImagePath) WHERE Id=?");
        $stmt->bind_param("ssssiisssi", $firstName, $middleName, $lastName, $nameExt, $courseId, $year, $formattedDate, $schoolId, $imagePath, $id);
        $stmt->execute();

        echo json_encode(['id' => $id]);
        exit;
    }
}

if ($method === 'DELETE') {
    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);
    $id = $data['key'] ?? null;

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM Attendee WHERE Id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo json_encode(['id' => $id]);
        exit;
    }
}

http_response_code(400);
echo json_encode(['error' => 'Invalid request']);
