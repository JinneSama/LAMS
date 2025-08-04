<?php
header('Content-Type: application/json');
include 'DbConnect.php';

$conn = getDbConnection();

$sql = "SELECT Id, Username FROM Users WHERE IsLocked = 1";
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

$conn->close();

echo json_encode([
        'result' => $users,
        'count' => count($users)
    ]);
?>
