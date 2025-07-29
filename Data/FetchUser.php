<?php
header('Content-Type: application/json');
include 'DbConnect.php';
$conn = getDbConnection();

$sql = "SELECT Users.Id, Users.username, Users.RoleId, Roles.RoleName AS role_name
        FROM Users
        JOIN Roles ON Users.RoleId = Roles.Id";

$result = $conn->query($sql);
$rows = [];

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode([
    'result' => $rows,
    'count' => count($rows)
]);
?>
