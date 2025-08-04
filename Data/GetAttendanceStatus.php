<?php
// getattendancestatus.php
header('Content-Type: application/json');
include 'DbConnect.php';
$conn = getDbConnection();

$studentId = $_GET['studentId'] ?? null;
if (!$studentId) {
  echo json_encode(['error' => 'Missing ID']);
  exit;
}

$stmt = $conn->prepare("SELECT AttendanceType FROM Attendance WHERE AttendeeId = ? ORDER BY DateAttended DESC LIMIT 1");
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
  echo json_encode(['lastType' => (int)$row['AttendanceType']]); // 1 = In, 2 = Out
} else {
  echo json_encode(['lastType' => null]); // No attendance yet
}
