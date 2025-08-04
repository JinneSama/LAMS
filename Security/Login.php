<?php
session_start();

if (isset($_SESSION['username'])) {
  header("Location: ../index.php");
  exit;
}
ob_start(); // Start capturing content
?>
<style>
  .spinner-border {
  vertical-align: middle;
  width: 1rem;
  height: 1rem;
}
</style>
<div class="login-box">
  <div class="login-logo">
    <a href="../images/ama2.png"><b>LAMS</b></a>
  </div>
</div>
<!-- /.login-logo -->
<div class="card">
  <div class="card-body login-card-body">
    <div class="text-center mb-3">
      <img src="../images/ama2.png" alt="Logo" style="width: 120px;">
    </div>

    <p class="login-box-msg">Log in to start your session</p>
    <form action="login.php" method="post">
      <div class="input-group mb-3">
        <?php if (isset($error)) {
          echo "<p class='error-message'>$error</p>";
        } ?>
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
          <button type="submit" id="login-btn" class="btn btn-primary btn-block">
            <span id="login-text">Log In</span>
            <span id="login-loader" class="spinner-border spinner-border-sm d-none"></span>
          </button>
        </div>
        <!-- /.col -->
      </div>
      <div id="login-message" class="text-danger mt-2"></div>
    </form>

    <p class="mb-1">
      <a href="../Security/ForgotPassword.php">Forgot Password</a>
    </p>
  </div>
  <!-- /.login-card-body -->
</div>
</div>
<!-- /.login-box -->
<script>
document.querySelector('form').addEventListener('submit', function (e) {
  e.preventDefault();

  const loginBtn = document.getElementById('login-btn');
  const loginText = document.getElementById('login-text');
  const loginLoader = document.getElementById('login-loader');
  const msgBox = document.getElementById('login-message');

  loginText.classList.add('d-none');
  loginLoader.classList.remove('d-none');
  msgBox.textContent = '';

  const formData = new FormData(this);

  fetch('../data/ProcessLogin.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    loginText.classList.remove('d-none');
    loginLoader.classList.add('d-none');

    if (data.success) {
      window.location.href = data.redirect;
    } else {
      msgBox.textContent = data.message;
    }
  })
  .catch(err => {
    loginText.classList.remove('d-none');
    loginLoader.classList.add('d-none');
    msgBox.textContent = "An error occurred. Please try again.";
  });
});
</script>


<?php
$content = ob_get_clean(); // Store captured content in $content

include '../Layout/LoginLayout.php';
?>