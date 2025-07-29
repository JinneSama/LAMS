<?php
ob_start(); // Start capturing content

?>

<?php
include '../data/DbConnect.php';
$conn = getDbConnection();

$id = $_GET['id'] ?? null;
$successMsg = $errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm) {
        $errorMsg = "❌ Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $errorMsg = "❌ Password must be at least 6 characters.";
    } elseif (!preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/', $password)) {
        $errorMsg = "❌ Password must be alphanumeric (letters and numbers only, no symbols).";
    } else {
        // Proceed with lookup and update logic
        $stmt = $conn->prepare("SELECT UserId FROM PasswordReset WHERE Id = ? AND IsReset = 0");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            $userId = $row['UserId'];
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $updateStmt = $conn->prepare("UPDATE Users SET password = ? WHERE Id = ?");
            $updateStmt->bind_param("si", $hashed, $userId);
            $updateStmt->execute();

            $resetStmt = $conn->prepare("UPDATE PasswordReset SET IsReset = 1 WHERE Id = ?");
            $resetStmt->bind_param("i", $id);
            $resetStmt->execute();

            $successMsg = "✅ Password has been updated.";
        } else {
            $errorMsg = "❌ Invalid or already used reset link.";
        }
    }
}

?>

<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>LAMS</b> Password Reset</a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Enter your new password below.</p>

      <?php if ($successMsg): ?>
        <div class="alert alert-success"><?= $successMsg ?></div>
      <?php elseif ($errorMsg): ?>
        <div class="alert alert-danger"><?= $errorMsg ?></div>
      <?php endif; ?>

      <?php if (!$successMsg): ?>
      <form method="post">
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="New Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change Password</button>
          </div>
        </div>
      </form>
      <?php endif; ?>

      <p class="mt-3 mb-1">
        <a href="../Security/Login.php">Back to Login</a>
      </p>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean(); // Store captured content in $content

include '../Layout/LoginLayout.php';
?>