<?php
header('Content-Type: text/plain');
include 'DbConnect.php';
$conn = getDbConnection();

$studentId = $_POST['studentId'] ?? null;
$attendanceType = $_POST['attendanceType'] ?? null;

if (!$studentId || !$attendanceType || !in_array($attendanceType, ['1', '2'])) {
    http_response_code(400);
    echo "Missing or invalid data.";
    exit;
}

$stmt = $conn->prepare("INSERT INTO Attendance (AttendeeId, DateAttended, AttendanceType) VALUES (?, NOW(), ?)");
$stmt->bind_param("ii", $studentId, $attendanceType);

if ($stmt->execute()) {
    echo "Attendance recorded.";
} else {
    echo "Error recording attendance.";
}
?>
