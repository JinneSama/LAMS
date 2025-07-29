<?php
    header('Content-Type: application/json');
    include 'DbConnect.php';
    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT Id AS id, RoleName AS name FROM Roles");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        'result' => $data,
        'count' => count($data)
    ]);

?>