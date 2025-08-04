<?php
header('Content-Type: application/json');
include 'DbConnect.php';
$conn = getDbConnection();

$studentId = $_GET['id'] ?? null;
if (!$studentId) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT 
    C.Id AS id, 
    TRIM(CONCAT(
        C.FirstName, ' ',
        IFNULL(C.MiddleName, ''), 
        IF(C.MiddleName IS NULL OR C.MiddleName = '', '', ' '),
        C.LastName,
        IF(C.NameExt IS NULL OR C.NameExt = '', '', CONCAT(' ', C.NameExt))
    )) AS full_name,
    CO.CourseName AS course,
    C.Year AS year,
    C.DateEnrolled AS date_enrolled,
    C.SchoolId AS school_id,
    C.ImagePath AS image_path
FROM Attendee C
INNER JOIN Course CO ON C.Course = CO.Id
WHERE C.Id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to prepare statement']);
    exit;
}

$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($rows ? $rows[0] : []);

$stmt->close();
$conn->close();
