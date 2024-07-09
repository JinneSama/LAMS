<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add New User</title>
<link rel="stylesheet" href="styles/navbar_style.css">
<style>
    body{
        background-color: #800000;
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
        width: 100%;
    }
    input[type="button"]:hover, input[type="submit"]:hover {
        background-color: #45a049;
    }
    input[type="text"], input[type="date"] {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
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
<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('image-preview');
        output.innerHTML = '<img src="' + reader.result + '" alt="Image preview">';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
</head>
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
<form action="saveUser.php" method="post">
    <label for="username">First Name:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Middle Name:</label>
    <input type="text" id="password" name="password">

    <label for="UserType">User Type:</label>
    <select id="UserType" name="UserType" required>
        <option value="Administrator">Administrator</option>
        <option value="User">User</option>
    </select>

    <input type="submit" value="Submit">
</form>