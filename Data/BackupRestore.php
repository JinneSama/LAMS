<?php
include 'DbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['backup'])) {
    $backupDir  = __DIR__ . "/backups"; // folder on server
    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0777, true);
    }

    $backupFile = $backupDir . "/backup_" . date("Y-m-d_H-i-s") . ".sql";
    $command = "mysqldump --user={$username} --password={$password} --host={$servername} {$dbname} > \"{$backupFile}\"";
    exec($command, $output, $return_var);

    if ($return_var === 0) {
        echo "✅ Backup saved to: <b>{$backupFile}</b><br>";
        echo "<a href='backups/" . basename($backupFile) . "' download>Download File</a><br>";
        echo "<a href='../Manage/Backup.php'>Go Back</a>";
    } else {
        echo "❌ Backup failed! <a href='../Manage/Backup.php'>Go back</a>";
    }
}

// RESTORE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore'])) {
    if (isset($_FILES['sql_file']) && $_FILES['sql_file']['error'] == 0) {
        $backupFile = $_FILES['sql_file']['tmp_name'];
        $command = "mysqldump --user={$username} --password={$password} --host={$servername} {$dbname} > {$backupFile}";
        exec($command, $output, $return_var);

        if ($return_var === 0) {
            echo "✅ Database restored successfully! <a href='index.php'>Go back</a>";
        } else {
            echo "❌ Restore failed! <a href='index.php'>Go back</a>";
        }
    } else {
        echo "❌ No file selected or upload error! <a href='index.php'>Go back</a>";
    }
}
?>
