<?php
$title = 'Create Admin user';

session_start();

//Connection to database
require '../databaseconnection.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

//Create admin form
$content = '
	<h2>Create Admin User</h2>
		<article>
			<form class="form" action="createadmin.php" method="post">
					<label>Username:</label>
							<input type="text" placeholder="Max 20 characters" name="username" required />
					<label>Firstname:</label>
						<input type="text" name="firstname" required />
					<label>Surname:</label>
						<input type="text" name="surname" required />
					<label>E-mail address:</label>
						<input type="text" name="email" required />
					<label>Password:</label>
						<input type="password" name="password" required />
					<label>Confirm Password:</label>
						<input type="password" name="confirmpassword" required />

						<input type="submit" value="Submit" name="submit" />
				</form>
			</article>
			';

  if (isset($_POST['username'], $_POST['firstname'], $_POST ['surname'], $_POST['email'], $_POST['password'])) {

  	//Check to see if passwords match - IF not user account will not be created.
  	if ($_POST['password'] == $_POST['confirmpassword']) {

			//Variable to state username for echo!
  		$username = $_POST['username'];

			//Hashing of passwords for security
			$password=$_POST['password'];
			$hash = password_hash($password, PASSWORD_DEFAULT);


				//prepared statement to insert admin information into admin table
				$stmt = $pdo->prepare('INSERT INTO admins (username, firstname, surname, email_address, password)
															VALUES ( :username, :firstname, :surname, :email, :password)');

				$criteria = [
					'username' => $_POST['username'],
					'firstname'=> $_POST['firstname'],
					'surname'=>	$_POST['surname'],
					'email'=> $_POST['email'],
					'password'=> $hash
				];

				unset($_POST['submit']);
				$stmt -> execute($criteria);

  					echo "Admin user $username has been successfully added";

  				} //End of Password matching IF
  				else {
  					echo "Please enter matching Passwords and try again!";
  				}

  } //End of submit IF
} //End of admin logged in IF
else {
	$content = 'Sorry, please log in as an admin to view this page';
}


  require '../layout.php';
?>
