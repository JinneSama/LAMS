<?php
header('Content-Type: application/json');
include 'DbConnect.php';
$conn = getDbConnection();

$result = $conn->query("SELECT Id AS id, CourseName AS name FROM Course");
$rows = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($rows);
