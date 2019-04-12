<?php
session_start();

$title = 'Northampton News';

//Displays a welcome back message to a logged in user
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {

  $content = '
  <h2>Welcome back '.$_SESSION['user'].' to Northampton News</h2>
  ';
}
//Displays general message to a non logged in user
else {
  $content = '
  <h2>Welcome to Northampton News</h2>
  ';

}

require '../layout.php';
?>
