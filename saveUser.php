<?php

$servername = "localhost";
$dbname = "LAMS";
$dbusername = "root";
$dbpassword = "root";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['UserType'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password , UserType) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password,$userType);

    if ($stmt->execute()) {
        echo "<script>alert('User added successfully');</script>";
    } else {
        echo "<script>alert('Error adding user');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
