<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Attendance Records</title>
<link rel="stylesheet" href="styles/navbar_style.css">
<style>
    body{
        background-color: #800000;
    }
    table {
        background-color: white;
        width: 100%;
        border-collapse: collapse;
        margin: 20px auto;
    }
    table, th, td {
        border: 1px solid #ccc;
    }
    th, td {
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .button {
        padding: 5px 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        cursor: pointer;
    }
    .button.delete {
        background-color: #f44336;
    }
    h2{
        color: white;
    }
</style>
</head>
<body>
<div class="navbar">
        <a href="index.html">Scanner</a>
        <a href="AddAttendee.php">Add Student</a>
        <a href="view_records.php">View Records</a>
        <a href="view_attendance.php">View Attendance</a>
    </div>
<h2 style="text-align: center;">Library Attendance Records</h2>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "LAMS";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "select C.Id , concat(C.FirstName , ' ' , C.MiddleName , ' ' , C.LastName , ' ' , C.NameExt) as fullName,
B.TypeName , A.DateAttended
from Attendance A inner join AttendanceType B on A.AttendanceType = B.Id inner join Attendee C on A.AttendeeId = C.Id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>ID</th><th>StudentName</th><th>Attendance Type</th><th>Date/Time Attended</th></tr>';

    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row["Id"] . '</td>';
        echo '<td>' . $row["fullName"] . '</td>';
        echo '<td>' . $row["TypeName"] . '</td>';
        echo '<td>' . $row["DateAttended"] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p style="text-align: center;">No records found</p>';
}

$conn->close();
?>

</body>
</html>
