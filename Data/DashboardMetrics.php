<?php
include 'DbConnect.php';
$conn = getDbConnection();

// Query counts
$counts = [
    'users' => $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'],
    'courses' => $conn->query("SELECT COUNT(*) AS total FROM course")->fetch_assoc()['total'],
    'attendance' => $conn->query("SELECT COUNT(*) AS total FROM attendance")->fetch_assoc()['total'],
    'students' => $conn->query("SELECT COUNT(*) AS total FROM Attendee")->fetch_assoc()['total']
];

header('Content-Type: application/json');
echo json_encode($counts);
?>
