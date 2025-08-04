<?php
session_start();
header('Content-Type: application/json');
date_default_timezone_set('Asia/Manila');
include 'DbConnect.php';
$conn = getDbConnection();

$response = ["success" => false, "message" => "Invalid credentials"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  $stmt = $conn->prepare("
    SELECT u.password, u.FailedAttempts, u.LastFailedAttempt, u.IsLocked, r.RoleName 
    FROM Users u
    JOIN Roles r ON u.RoleId = r.Id
    WHERE u.username = ?
  ");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password, $failedAttempts, $lastFailed, $isLocked, $roleName);
    $stmt->fetch();

    $currentTime = new DateTime();
    $lastFailedTime = $lastFailed ? new DateTime($lastFailed) : null;

    if ($isLocked) {
      $response['message'] = 'Your account is locked. Please contact the administrator.';
    } elseif ($failedAttempts >= 3 && $lastFailedTime && $currentTime->getTimestamp() - $lastFailedTime->getTimestamp() < 900) {
        $lockDuration = 900; // 15 minutes in seconds
        $secondsPassed = $currentTime->getTimestamp() - $lastFailedTime->getTimestamp();
        $secondsLeft = $lockDuration - $secondsPassed;

        $minutes = floor($secondsLeft / 60);
        $seconds = $secondsLeft % 60;
        if ($secondsLeft > 0) {
            $minutes = floor($secondsLeft / 60);
            $seconds = $secondsLeft % 60;
            $response['message'] = "Too many attempts. Try again in {$minutes}m {$seconds}s.";
        } else {
            $response['message'] = "Too many attempts. Please try again shortly.";
        }
    } elseif (password_verify($password, $hashed_password)) {
      // Success: Reset failed attempts
      $update = $conn->prepare("UPDATE Users SET FailedAttempts = 0, LastFailedAttempt = NULL WHERE username = ?");
      $update->bind_param("s", $username);
      $update->execute();
      $update->close();

      $_SESSION['username'] = $username;
      $_SESSION['usertype'] = $roleName;

      $response = ["success" => true, "redirect" => "../index.php"];
    } else {
      $failedAttempts++;
      $isNowLocked = ($failedAttempts >= 9) ? 1 : 0;
      $message = ($isNowLocked)
        ? 'Account locked due to too many failed attempts. Contact admin.'
        : (($failedAttempts >= 3)
            ? 'Invalid credentials. Try again after 15 minutes.'
            : 'Invalid username or password.');

      $update = $conn->prepare("UPDATE Users SET FailedAttempts = ?, LastFailedAttempt = NOW(), IsLocked = ? WHERE username = ?");
      $update->bind_param("iis", $failedAttempts, $isNowLocked, $username);
      $update->execute();
      $update->close();

      $response['message'] = $message;
    }
  }

  $stmt->close();
}

$conn->close();
echo json_encode($response);
?>
