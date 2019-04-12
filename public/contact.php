<?php
$title = 'Contact Us - Northampton News';

session_start();

/*
  contact us form which was included with orginal html
  DOES NOT FUNCTION
*/
$content = '
<h2>Contact Us</h2>
<article>
<form class="form" action="contact.php" id="contactform" method="post">
<label>Username:</label>
    <input type="text" placeholder="If applicable" name="username" />
		<label>Title:</label>
			<select name="title">
				<option value="Mr">Mr</option>
				<option value="Mrs">Mrs</option>
				<option value="Miss">Miss</option>
				<option value="NonBinary">Non-binary</option>
			</select>
		<label>Firstname:</label>
			<input type="text" name="firstname" required />
		<label>Surname:</label>
			<input type="text" name="surname" required />
		<label>E-mail address:</label>
      <input type="text" name="email" required />

    <label>Enter message here:</label>
    <textarea name="contactmessage" form="contactform"></textarea>

		<input type="submit" value="Submit" name="submit" />
	</form>

	</article>
  ';


require '../layout.php';
?>
