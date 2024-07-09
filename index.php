<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <link rel="stylesheet" href="styles/navbar_style.css">
    <script src="libs/html5-qrcode.min.js"></script>
    <style>
        #reader {
            width: 100%;
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background-color: rgb(255, 255, 255);
        }
        body{
            background-color: rgb(240, 240, 240);
        }

        .image-container img{
            width: 20rem;
        }

    </style>
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
    <div class="container">
        <div class="image-container">
            <img src="images/ama2.png">
        </div>
        <h1>QR Code Scanner</h1>
        <div id="reader"></div>
    </div>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);
            alert(`QR Code detected: ${decodedText}`);

            // Send the scanned data to process.php
            fetch('process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ code: decodedText })
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.text().then(data => {
                        console.log(data);
                        alert(data); // Display server response
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error);
            });

            html5QrcodeScanner.clear();
        }

        function onScanFailure(error) {
            // Handle scan failure, currently we do nothing
        }

        const html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 }, /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
</body>
</html>
