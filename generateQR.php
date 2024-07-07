<?php
include('phpqrcode/qrlib.php');

$result = $_GET['code'];
QRcode::png($result);
?>