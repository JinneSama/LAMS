<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "LAMS";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: implement server-side filtering, sorting, paging here using $_GET parameters
$sql = "SELECT C.Id , 
               CONCAT(C.FirstName, ' ', C.MiddleName, ' ', C.LastName, ' ', C.NameExt) AS fullName,
               B.TypeName, 
               A.DateAttended
        FROM Attendance A 
        INNER JOIN AttendanceType B ON A.AttendanceType = B.Id 
        INNER JOIN Attendee C ON A.AttendeeId = C.Id";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>