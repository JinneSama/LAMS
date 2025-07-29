<?php
    header('Content-Type: application/json');
    include 'DbConnect.php';
    $conn = getDbConnection();
    $collegeId = $_GET['college_id'] ?? null;
    if (!$collegeId) {
        echo json_encode([]);
        exit;
    }
    $stmt = $conn->prepare("SELECT Id AS id, CourseName AS name FROM course WHERE CollegeId = ?");
    $stmt->bind_param("i", $collegeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode([
        'result' => $rows,
        'count' => count($rows)
    ]);
?>