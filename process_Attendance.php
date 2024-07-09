<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "LAMS";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST['studentId'];
    
    if (isset($_POST['timeIn'])) {
        $attendanceType = 1; // Time In
    } elseif (isset($_POST['timeOut'])) {
        $attendanceType = 2; // Time Out
    } else {
        die("Invalid request");
    }

    $sql = "INSERT INTO Attendance (AttendeeId, DateAttended, AttendanceType) VALUES ('$studentId', NOW(), '$attendanceType')";

    if ($conn->query($sql) === TRUE) {
        $message = "Attendance recorded successfully.";
        echo "<script>
                alert('$message');
                </script>";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
        echo "<script>
                alert('$message');
               </script>";
    }
}

$conn->close();
header("Location: index.php");
exit();
?>
