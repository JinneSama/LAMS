<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/navbar_style.css">
</head>

<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "LAMS";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['code'];
$sql = "SELECT A.*, B.CourseName FROM Attendee A INNER JOIN Course B ON A.Course = B.Id WHERE A.Id = $id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstname = $row['FirstName'];
    $middlename = $row['MiddleName'];
    $lastname = $row['LastName'];
    $nameextension = $row['NameExt'];
    $course = $row['CourseName'];
    $dateenrolled = date('Y-m-d', strtotime($row['DateEnrolled']));
    $schoolId = $row['SchoolId'];
    $imagePath = $row['ImagePath'];
    $fullName = $firstname . ' ' . $middlename . ' ' . $lastname . ' ' . $nameextension;
} else {
    echo "<p style='text-align: center;'>No record found</p>";
    exit();
}
?>

<body>
<div class="navbar">
        <a href="index.php">Scanner</a>
        <a href="AddAttendee.php">Add Student</a>
        <a href="view_records.php">View Records</a>
        <a href="view_attendance.php">View Attendance</a>
        <a href="logout.php" style="float: right;">Logout</a>
        <?php
            session_start();

            if (!isset($_SESSION['username'])) {
                header("Location: login.html");
                exit;
            }else{
                
                echo '<a href="" style="float: right; pointer-events: none;">' . $_SESSION['username'] . '</a>';
                if(isset($_SESSION['usertype'])){
                    if($_SESSION['usertype'] == "Administrator")
                        echo '<a href="NewUser.php">Add User</a>';
                }
            }
        ?>
    </div>
    <div class="card-body">
        <div class="id-card">
            <div class="header">
                <h2>AMA College</h2>
            </div>
            <div class="photo">
                <img src="<?php echo $imagePath; ?>" alt="Profile Photo">
            </div>
            <div class="details">
                <h2><?php echo $fullName; ?></h2>
                <p>Course: <?php echo $course; ?></p>
                <p>ID: <?php echo $schoolId; ?></p>
            </div>
            <div class="attendance-buttons">
                <form action="process_Attendance.php" method="post">
                    <input type="hidden" name="studentId" value="<?php echo $id; ?>">
                    <input type="submit" name="timeIn" value="Time In">
                    <input type="submit" name="timeOut" value="Time Out">
                </form>
            </div>
        </div>
    </div>
</body>

<?php
$conn->close();
?>

</html>
