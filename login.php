<?php
session_start();

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

    $stmt = $conn->prepare("SELECT password , UserType FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $UserType);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $UserType;

            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="styles/navbar_style.css">
    <style>
    body{
        background-color: #800000;
    }
    h1{
        margin-top: 5rem;
        text-align: center;
        color: white;
    }
    form {
        background-color: white;
        max-width: 500px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
    }
    label, select, input {
        display: block;
        margin-bottom: 10px;
    }
    input[type="submit"], input[type="button"] {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: left;
        margin-right: 10px;
    }
    form input[type="submit"]{
        width: 100%;
    }
    input[type="submit"]:hover, input[type="submit"]:hover {
        background-color: #45a049;
    }
    input[type="text"], input[type="date"] ,input[type="password"] {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .image-preview {
        margin-top: 10px;
        text-align: center;
    }
    .image-preview img {
        max-width: 200px;
        max-height: 200px;
        margin-top: 10px;
    }
    </style>
</head>
        <h1>Login</h1>
        <form action="login.php" method="post">
            <div class="image-preview" id="image-preview">
                <img src="images/ama2.png" alt="">
            </div>
            <?php if (isset($error)) { echo "<p class='error-message'>$error</p>"; } ?>
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" required>
            
            <input type="submit" value="Login">
        </form>   
</body>
</html>
