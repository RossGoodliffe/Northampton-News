<?php
$title = 'Register - Northampton News';

//Connection to database
require '../databaseconnection.php';

//registration form
$content = '
<h2>Register to Northampton News</h2>
<article>
<form class="form" action="register.php" method="post">
<p>Please enter your details</p>
		<label>Username:</label>
				<input type="text" placeholder="Max 20 characters" name="username" required />
		<label>Title:</label>
			<select name="title">
				<option value="" disabled selected>Please Select</option>
				<option value="Mr">Mr</option>
				<option value="Mrs">Mrs</option>
				<option value="Miss">Miss</option>
				<option value="NonBinary">Non-binary</option>
			</select>
		<label>Firstname:</label>
			<input type="text" placeholder="Required" name="firstname" required />
		<label>Surname:</label>
			<input type="text" placeholder="Required" name="surname" required />
		<label>E-mail address:</label>
			<input type="text" placeholder="Required" name="email" required />
		<label>Password:</label>
			<input type="password" placeholder="Required" name="password" required />
		<label>Confirm Password:</label>
			<input type="password" placeholder="Required" name="confirmpassword" required />

		<input type="submit" value="Submit" name="submit" />
	</form>
	</article>';

//Once submit button has been pressed
if (isset($_POST['username'], $_POST['title'], $_POST['firstname'], $_POST ['surname'], $_POST['email'], $_POST['password'])) {


	//Comparing database to see if anyone else has user the username
	$usernamecheckquery = $pdo->prepare('SELECT count(*) FROM users WHERE username="' . $_POST['username'] . '"');
	$usernamecheckquery -> execute();
	$usernamecount = $usernamecheckquery->fetchColumn();

	//If there is more than 0 accounts of username - display message
	if($usernamecount > 0) {
		echo 'Sorry, Username unavailable';
	}
	else {
		//Comparting database to see if anyone has used the e-mail address already
		$emailcheckquery = $pdo->prepare('SELECT count(*) FROM users WHERE email_address="' . $_POST['email'] . '"');
		$emailcheckquery -> execute();
		$emailcount = $emailcheckquery->fetchColumn();

		//If there is more than 0 accounts using the email provided - display message
		if($emailcount > 0){
			echo 'Sorry, email address is unavailable';
		}
		else {

			//Check to make sure password and confirm password match
			if ($_POST['password'] == $_POST['confirmpassword']) {
				
/*
Butler, T (2018). Nile.northampton.ac.uk. CSY2028 Web Programming Topic 9. [online] Available at: https://nile.northampton.ac.uk/webapps/blackboard/content/listContent.jsp?course_id=_70646_1&content_id=_4295889_1 [Accessed 15 Dec. 2017].
*/

				//Hashing of passwords for security
				$password=$_POST['password'];
				$hash = password_hash($password, PASSWORD_DEFAULT);

					//Adding information to the database using prepared statements
					$stmt = $pdo->prepare('INSERT INTO users (username, title, firstname, surname, email_address, password)
																VALUES ( :username, :title, :firstname, :surname, :email, :password)');

					$criteria = [
						'username' => $_POST['username'],
						'title' => $_POST['title'],
						'firstname'=> $_POST['firstname'],
						'surname'=>	$_POST['surname'],
						'email'=> $_POST['email'],
						'password'=> $hash
					];
					unset($_POST['submit']);
					$stmt -> execute($criteria);

							$username = ($_POST['username']);
							echo " $username has been successfully registered - Please Log in";
						}

						else {
							echo "Please enter matching Passwords and try again!";
			}
		}
	}
}


require '../layout.php';
?>
