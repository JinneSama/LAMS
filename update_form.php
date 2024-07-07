<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "LAMS";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$Id = $_POST['id'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$nameextension = $_POST['nameextension'];
$course = $_POST['course'];
$dateenrolled = $_POST['dateenrolled'];
$schoolId = $_POST['schoolId'];

$sql = "update Attendee set FirstName='$firstname' , MiddleName='$middlename' , LastName='$lastname', NameExt='$nameextension' , Course='$course',DateEnrolled='$dateenrolled',SchoolId='$schoolId' where Id='$Id'";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("Location: view_records.php");
exit();
?>
