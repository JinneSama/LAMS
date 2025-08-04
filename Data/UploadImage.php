<?php
$uploadDir = '../uploads/';
$filename = basename($_FILES['file']['name']);
$targetFile = $uploadDir . $filename;

if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
    echo json_encode([
        'success' => true,
        'path' => 'uploads/' . $filename
    ]);
} else {
    echo json_encode([
        'success' => false
    ]);
}
