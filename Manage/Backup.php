<?php
ob_start();
$title = "Backup & Restore";
?>
<style>
    .container { max-width: 400px; margin: auto; }
    form { border: 1px solid #ccc; padding: 20px; margin-bottom: 20px; border-radius: 8px; }
    input[type="submit"] { padding: 10px 15px; cursor: pointer; }
</style>


<div class="card">
    <div class="card-header">
        <h3 class="card-title">Backup & Restore</h3>
    </div>
    <div class="card-body">
<div class="container">
    <h2>📦 Database Backup</h2>
    <form action="../Data/BackupRestore.php" method="post">
        <input type="submit" name="backup" value="Create & Download Backup">
    </form>

    <h2>♻️ Database Restore</h2>
    <form action="../Data/BackupRestore.php" method="post" enctype="multipart/form-data">
        <label>Select .sql File:</label><br><br>
        <input type="file" name="sql_file" accept=".sql" required><br><br>
        <input type="submit" name="restore" value="Restore Database">
    </form>
</div>
    </div>
</div>


<?php

$content = ob_get_clean();
include '../Layout/MainLayout.php';
?>
