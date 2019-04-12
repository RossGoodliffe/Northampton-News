<?php
$title = 'Login - Northampton News';

session_start();

//Connection to database
require '../databaseconnection.php';

//login form
$content = '
<h2>Login to Northampton News</h2>
<article>
<form class="form" action="login.php" method="post">
		<label>Username:</label>
				<input type="text" name="username" required />
		<label>Password:</label>
			<input type="password" name="password" required />

		<input type="submit" value="Submit" name="submit" />
	</form>
	</article>';

	if(isset($_POST['username'], $_POST['password'])) {

		//prepare statement to select all users from user table
		$stmt = $pdo-> prepare('SELECT * FROM users WHERE username = :username;');

		$criteria = [
			'username' => $_POST['username']
		];

		$stmt -> execute($criteria);
		$users = $stmt -> fetch();

		//un hashing passwords!
		if(password_verify($_POST['password'], $users['password'])) {
			$_SESSION['user_logged_in'] = true;
      $_SESSION['user'] = $_POST['username'];

      //Once logged in re-directs the user to the homepage
      header("Location: index.php");
      die();

		}

    //If username and password do not match display this message
		else {
			echo 'Username OR Password did not match our records. Please try again';
		}

	}

require '../layout.php';
?>
