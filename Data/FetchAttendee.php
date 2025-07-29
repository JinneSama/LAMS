<?php
header('Content-Type: application/json');
include 'DbConnect.php';
$conn = getDbConnection();

$result = $conn->query("SELECT Id AS id, FirstName AS first_name, MiddleName AS middle_name, LastName AS last_name, NameExt AS name_ext, Course AS course_id, Year AS year, DateEnrolled AS date_enrolled, SchoolId AS school_id, ImagePath AS image_path FROM Attendee");
$rows = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    'result' => $rows,
    'count' => count($rows)
]);
