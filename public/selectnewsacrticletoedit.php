<?php
$title = 'Select News Article to Edit';

session_start();

//Connection to database
require '../databaseconnection.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

$content = '<h2>Select News Article to Edit</h2>
<article>
<form class="form" action="editnewsarticle.php" method="post">
		<label>Article Title:</label>
		<select name="select_article_title">
			<option value="" disabled selected>Please Select</option>';

				//prepared statement to select all articles for drop down menu
				$results = $pdo->prepare('SELECT * FROM articles');
				$results -> execute();

				foreach ($results as $row)
				{
					$content = $content. '

					<option value="'. $row['title'].'">'. $row['title'].'</option>';
				}

//content varibale continues
$content =$content.'
			</select>
			<input type="submit" value="Submit" name="submit" />
		</form>
</article>

';

//End of admin logged in IF
}
else {
	$content = 'Sorry, please log in as an admin to view this page';
}


require '../layout.php';
?>
