<?php
ob_start(); // Start output buffering
?>

<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>LAMS</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">You forgot your password? Enter your Username to reset it.</p>

            <form id="recoverForm" action="recover-password.php" method="post">

                <div class="input-group mb-3">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Request for password reset</button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="../Security/Login.php">Back to Login</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->


<div id="resultMsg" class="mt-3 text-center text-info"></div>

<script>
    document.getElementById('recoverForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const username = document.getElementById('username').value;

        fetch('../data/searchuser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    username
                })
            })
            .then(res => res.json())
            .then(data => {
                const resultDiv = document.getElementById('resultMsg');
                if (data.success) {
                    resultDiv.innerHTML = `✅ User Exists, Your request has been sent.`;
                    resultDiv.className = 'mt-3 text-center text-success';
                } else {
                    resultDiv.innerHTML = `❌ ${data.message}`;
                    resultDiv.className = 'mt-3 text-center text-danger';
                }
            });
    });
</script>

<?php
$content = ob_get_clean(); // Store output into $content

// Include layout
include '../Layout/LoginLayout.php';
?>