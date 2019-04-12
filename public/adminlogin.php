<?php
//title of webpage
$title = 'Admin Home';

session_start();

//Connection to database
require '../databaseconnection.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

  header("Location: adminhome.php");
  die();
}
else {

//login form
$content = '
  <h2>Admin Page</h2>
    <article>
      <form class="form" action="adminlogin.php" method="post">
      	<label>Username:</label>
      			<input type="text" name="username" required />
      	<label>Password:</label>
      			<input type="password" name="password" required />

      	<input type="submit" value="Submit" name="submit" />
      </form>
    </article>
';

if(isset($_POST['username'], $_POST['password'])) {

  //prepare stmt to
  $stmt = $pdo-> prepare('SELECT * FROM admins WHERE username = :username;');

  $criteria = [
    'username' => $_POST['username']
  ];

  $stmt -> execute($criteria);

  $admins = $stmt -> fetch();

  //un hashing passwords!
  if(password_verify($_POST['password'], $admins['password'])) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_user'] = $_POST['username'];

    $stmt = $pdo->prepare('SELECT admin_id FROM admins WHERE username = "'.$_POST['username'].'"');
    $stmt->execute();

    foreach ($stmt as $admin) {
      $_SESSION['admin_id'] = $admin['admin_id'];
    }


    echo 'Welcome back ' . $_POST['username'];

    header("Location: adminhome.php");
    die();
  }
  else {
    echo 'Username OR Password did not match our records. Please try again';
    }
  }
}



require '../layout.php';

?>
