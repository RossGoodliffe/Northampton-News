<?php
$title = 'You are logged out';
session_start();

//logs out of either admin or user
unset($_SESSION['user_logged_in']);
unset($_SESSION['admin_logged_in']);
echo 'You are now logged out';

$content = 'You are now logged out';

require '../layout.php';
?>
