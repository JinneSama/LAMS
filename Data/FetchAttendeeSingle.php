<?php
// FetchAttendeeSingle.php
require_once 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo json_encode(['error' => 'Missing ID']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($student);
