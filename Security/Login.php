<?php
ob_start(); // Start capturing content
?>
<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}

$servername = "localhost";
$dbname = "LAMS";
$dbusername = "root";
$dbpassword = "";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("
        SELECT u.password, r.RoleName 
        FROM Users u
        JOIN Roles r ON u.RoleId = r.Id
        WHERE u.username = ?
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $roleName);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $roleName;

            header("Location: ../index.php");
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

<div class="login-box">
  <div class="login-logo">
        <a href="../images/ama2.png"><b>LAMS</b></a></div>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Log in to start your session</p>

      <form action="login.php" method="post">
        <div class="input-group mb-3">
          <?php if (isset($error)) { echo "<p class='error-message'>$error</p>"; } ?>
          <input type="text" name="username" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="../Security/ForgotPassword.php">Forgot Password</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<?php
$content = ob_get_clean(); // Store captured content in $content

include '../Layout/LoginLayout.php';
?>