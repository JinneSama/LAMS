<?php
header('Content-Type: application/json');
include 'DbConnect.php';
$conn = getDbConnection();

$sql = "SELECT Id, RoleName FROM Roles";
$result = $conn->query($sql);
$roles = [];

while ($row = $result->fetch_assoc()) {
    $roles[] = [
        'Id' => $row['Id'],
        'RoleName' => $row['RoleName']
    ];
}

echo json_encode($roles);
?>
