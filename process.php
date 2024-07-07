<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['code'])) {
    $code = $_POST['code'];
    echo "N121212";
    header('Location: view_id_card.php?code=' . urlencode($code));
    exit();
} else {
    echo "No code received.";
}
?>