<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "LAMS";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$nameextension = $_POST['nameextension'];
$course = $_POST['course'];
$dateenrolled = $_POST['dateenrolled'];
$schoolId = $_POST['schoolId'];

$targetDir = "uploads/";
$PreviousFileName = basename($_FILES["image"]["name"]);
$imageFileType = strtolower(pathinfo($PreviousFileName, PATHINFO_EXTENSION));
$targetFile = $targetDir . $schoolId . '.' . $imageFileType;

if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "Sorry, your file is too large.";
        exit();
    }
}
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    exit();
}

if ($_FILES["image"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    exit();
}

$uniqueFilename = uniqid('image_') . '.' . $imageFileType;
$targetFilePath = $targetDir . $uniqueFilename;

if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
    echo "Sorry, there was an error uploading your file , Photo must not exceed 500KB.";
    echo '<html><head><meta http-equiv="refresh" content="5;url=view_records.php"></head><body>';
    echo '<br>Redirecting in 5 seconds...';
    echo '</body></html>';
    exit();
}

$sql = "INSERT INTO Attendee (firstname, middlename, lastname, NameExt, course, dateenrolled, schoolId,ImagePath)
VALUES ('$firstname', '$middlename', '$lastname', '$nameextension', '$course', '$dateenrolled', '$schoolId' , '$targetFilePath')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("Location: view_records.php");
exit();
?>
