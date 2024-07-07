<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Attendee Records</title>
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
    .button-cell {
        display: flex;
        flex-direction: auto;
        align-items: center;
        gap: 0.5rem;
    }

    .button-cell button {
        display: block;
    }
    .button {
        padding: 5px 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        cursor: pointer;
        text-align: center;
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
<h2 style="text-align: center;">Attendee Records</h2>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "LAMS";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT A.*, B.CourseName FROM Attendee A inner join Course B on A.Course = B.Id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>ID</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Name Extension</th><th>Course</th><th>Date Enrolled</th><th>School ID</th><th>Actions</th></tr>';

    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row["Id"] . '</td>';
        echo '<td>' . $row["FirstName"] . '</td>';
        echo '<td>' . $row["MiddleName"] . '</td>';
        echo '<td>' . $row["LastName"] . '</td>';
        echo '<td>' . $row["NameExt"] . '</td>';
        echo '<td>' . $row["CourseName"] . '</td>';
        echo '<td>' . $row["DateEnrolled"] . '</td>';
        echo '<td>' . $row["SchoolId"] . '</td>';
        echo '<td class="button-cell"><a href="generateQR.php?code=' . $row["Id"] . '" class="button" target="_blank" rel="noopener noreferrer">Generate QR</a> ';
        echo '<a href="EditAttendee.php?id=' . $row["Id"] . '" class="button">Edit</a> ';
        echo '<a href="delete_record.php?id=' . $row["Id"] . '" class="button delete" onclick="return confirm(\'Are you sure you want to delete this record?\')">Delete</a></td>';
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
