<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Registration Form</title>
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
        <a href="index.html">Scanner</a>
        <a href="AddAttendee.php">Add Student</a>
        <a href="view_records.php">View Records</a>
        <a href="view_attendance.html">View Attendance</a>
    </div>
<form action="submit_form.php" method="post" enctype="multipart/form-data">
    <div class="image-preview" id="image-preview"></div>

    <label for="image">Choose Student Photo:</label>
    <input type="file" id="image" name="image" onchange="previewImage(event)" accept="image/*">

    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname" required>

    <label for="middlename">Middle Name:</label>
    <input type="text" id="middlename" name="middlename">

    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname" required>

    <label for="nameextension">Name Extension:</label>
    <input type="text" id="nameextension" name="nameextension">

    <label for="course">Course:</label>
    <select id="course" name="course" required>
        <?php
        
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "LAMS";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM Course";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["Id"] . '">' . $row["CourseName"] . '</option>';
            }
        } else {
            echo '<option value="">No courses available</option>';
        }

        $conn->close();
        ?>
    </select>

    <label for="dateenrolled">Date Enrolled:</label>
    <input type="date" id="dateenrolled" name="dateenrolled" required>

    <label for="schoolId">School ID:</label>
    <input type="text" id="schoolId" name="schoolId" required>

    <div style="overflow: auto;">
        <input type="submit" value="Submit">
        <input type="button" value="Clear Form" onclick="clearForm()">
    </div>
</form>

<script>
    function clearForm() {
        document.getElementById("firstname").value = "";
        document.getElementById("middlename").value = "";
        document.getElementById("lastname").value = "";
        document.getElementById("nameextension").value = "";
        document.getElementById("course").value = "";
        document.getElementById("dateenrolled").value = "";
        document.getElementById("schoolId").value = "";
    }
</script>

</body>
</html>
