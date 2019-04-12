<?php
$title = 'Delete Admin Account';

session_start();

//Connection to database
require '../databaseconnection.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
$content = '
<h2>Delete Admin Account</h2>
<form class="form" action="deleteadminaccount.php" method="post">
<label>Admin Username:</label>
  <select name="username">
  <option value="" disabled selected>Please Select</option>';


    $results = $pdo->prepare('SELECT * FROM admins');
    $results->execute();

    foreach ($results as $row)
    {
      $content = $content. '

      <option value="'. $row['username'].'">'. $row['username'].'</option>';
    }

$content =$content.'
  </select>

    <input type="submit" value="Delete" name="submit" />
</form>
';

//If delete button is pressed delete Admin Username
if (isset($_POST['username']))
{
  $username=$_POST['username'];

  $stmt = $pdo->prepare('DELETE FROM admins WHERE username= :username');
  $stmt->bindParam(":username", $_POST['username']);
  $stmt->execute();



  echo " $username account has successfully been deleted";
}


//End of admin logged in IF
}
else {
	$content = 'Sorry, please log in as an admin to view this page';
}


require '../layout.php';
?>
