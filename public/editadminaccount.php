<?php
$title = 'Edit Admin Account';

session_start();

//Connection to database
require '../databaseconnection.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

//html form
$content = '
<h2>Edit Admin Account</h2>
<form class="form" action="editadminaccount.php" method="post">
<label>Admin Username:</label>
  <select name="username">
  <option value="" disabled selected>Please Select</option>';

    //prepared to select all admins from admin table
    $results = $pdo->query('SELECT * FROM admins');

    foreach ($results as $row)
    {
      $content = $content. '
      <option value="'. $row['username'].'">'. $row['username'].'</option>';
    }

//content variable continues
$content =$content.'
  </select>

  <label>New Username:</label>
    <input type="text" placeholder="if changed" name="new_username" />
  <label>New Firstname:</label>
    <input type="text" placeholder="if changed" name="new_firstname" />
  <label>New Surname:</label>
    <input type="text" placeholder="if changed" name="new_surname" />
  <label>New Email Address:</label>
    <input type="text" placeholder="if changed" name="new_email" />
  <label>New Password:</label>
    <input type="password" placeholder="if changed" name="new_password" />
  <label>Confirm New Password:</label>
    <input type="password" placeholder="if changed" name="new_passwordconfirm" />

  <input type="submit" value="Submit" name="submit" />
</form>
';


//if submit button has been pressed
if (isset($_POST['username'], $_POST['new_username'], $_POST['new_firstname'], $_POST ['new_surname'], $_POST['new_email'], $_POST['new_password'])) {

  $username = $_POST['username'];
  $new_username = $_POST['new_username'];
  $new_firstname = $_POST['new_firstname'];
  $new_surname = $_POST['new_surname'];
  $new_email = $_POST['new_email'];
  $new_password = $_POST['new_password'];

  if ($_POST['new_password'] == $_POST['new_passwordconfirm']) {

  //If firstname isn't blank
  if($new_firstname != ""){

    $pdo->query('UPDATE admins SET firstname = "' . $new_firstname . '"
                WHERE username = "' . $username . '"');

    echo "$username - Firstname changed to $new_firstname  -";
  }
  else {
    echo  "No firstname change  -";
  }

//If surname isn't blank
  if($new_surname != ""){

    $pdo->query('UPDATE admins SET surname = "' . $new_surname . '"
                WHERE username = "' . $username . '"');

    echo "$username - Surname changed to $new_surname  -";
  }
  else {
    echo  "No Surname change  -";
  }

  //If email address isn't blank
    if($new_email != ""){

      $pdo->query('UPDATE admins SET email_address = "' . $new_email . '"
                  WHERE username = "' . $username . '"');

      echo "$username - Email Address changed to $new_email  -";
    }
    else {
      echo  "No Email Address change  -";
    }

    //If password isn't blank
      if($new_password != ""){

        $pdo->query('UPDATE admins SET password = "' . $new_password . '"
                    WHERE username = "' . $username . '"');

        echo "$username - Password has been changed  -";
      }
      else {
        echo  "No password change  -";
      }

      //If username isn't Blank
      if($new_username != "") {

        $pdo->query('UPDATE admins SET username = "' . $new_username . '"
                    WHERE username = "' . $username . '"');

        echo "$username has been successfully changed to $new_username  -";
      }
      else {
        echo  "No username change  -";
      }

    }//Closing Password Matching IF statment
    else {
    echo "New passwords do not mactch";
  }   //Closing Password Matching

} //Closing Submit button

//End of admin logged in IF
}
else {
	$content = 'Sorry, please log in as an admin to view this page';
}

require '../layout.php';
?>
