<?php
//title of webpage
$title = 'Add News Category';

session_start();

//Connection to database
require '../databaseconnection.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

//Adding news category form
$content = '
<h2>Add News Category</h2>
<article>
<form class="form" action="addcategory.php" method="post">
		<label>Category Name:</label>
				<input type="text" placeholder="Max 50 characters" name="category_name" required />
    <label>Category Description:</label>
    		<input type="text" name="category_description" required />

    <input type="submit" value="Submit" name="submit" />
</form>
';

//If submit button has been clicked.
if (isset($_POST['category_name'], $_POST['category_description'])) {

    $category_name = $_POST['category_name'];

		//prepare stmt to add cat nam & description to categories table
		$stmt = $pdo->prepare('INSERT INTO categories (category_name, category_description)
														VALUES (:category_name, :category_description)');

		$criteria = [
			'category_name' => $_POST['category_name'],
			'category_description' => $_POST['category_description']
		];

		unset($_POST['submit']);
		$stmt -> execute($criteria);

          echo " $category_name has successfully been created";
				}
}
//What will displayed if an admin user is NOT logged in
else {
	$content = 'Sorry, please log in as an admin to view this page';
}

require '../layout.php';
?>
