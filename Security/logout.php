<?php
session_start();

$_SESSION = array();

session_destroy();

header("location: ../security/login.php");
exit;
?>