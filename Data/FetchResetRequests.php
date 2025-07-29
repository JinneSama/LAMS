<?php
header('Content-Type: application/json');
include 'DbConnect.php';

$conn = getDbConnection();

$sql = "
    SELECT 
        pr.Id AS id,
        u.username AS name
    FROM 
        users u
    INNER JOIN 
        passwordreset pr ON u.Id = pr.UserId
    WHERE 
        pr.IsReset = 0
";

$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode([
        'result' => $data,
        'count' => count($data)
    ]);
