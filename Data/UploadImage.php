<?php
header('Content-Type: application/json');

$uploadDir = '../uploads/image/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $filename = uniqid() . '_' . basename($_FILES['file']['name']);
    $target = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        echo json_encode(['success' => true, 'filename' => $filename]);
        exit;
    }
}

http_response_code(400);
echo json_encode(['success' => false, 'error' => 'Upload failed']);
