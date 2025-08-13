<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "LAMS";

function getDbConnection() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        http_response_code(500);
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Example usage
$conn = getDbConnection();
?>
