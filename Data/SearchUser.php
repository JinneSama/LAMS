<?php
header('Content-Type: application/json');
include 'DbConnect.php';

$conn = getDbConnection();
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);
$username = $data['username'] ?? '';

if ($username === '') {
    echo json_encode(['success' => false, 'message' => 'No username provided']);
    exit;
}

// 1. Check if user exists
$stmt = $conn->prepare("SELECT * FROM Users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    $userId = $user['Id'];

    // 2. Check if there's already a PasswordReset record not marked as reset
    $checkStmt = $conn->prepare("SELECT * FROM PasswordReset WHERE UserId = ? AND IsReset = 0");
    $checkStmt->bind_param("i", $userId);
    $checkStmt->execute();
    $existingReset = $checkStmt->get_result();

    if ($existingReset->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Reset request already exists for this user and is not yet completed.'
        ]);
        exit;
    }

    // 3. No pending reset, insert new record
    $insertStmt = $conn->prepare("INSERT INTO PasswordReset (UserId, IsReset) VALUES (?, 0)");
    $insertStmt->bind_param("i", $userId);

    if ($insertStmt->execute()) {
        echo json_encode([
            'success' => true,
            'id' => $userId,
            'username' => $user['username'],
            'reset_id' => $insertStmt->insert_id
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'User found, but failed to create password reset entry.'
        ]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}
?>
