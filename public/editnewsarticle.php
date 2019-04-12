<?php
$title = 'Edit News Article';

session_start();

//Connection to database
require '../databaseconnection.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

echo $_POST["select_article_title"];

$article_title = $_POST["select_article_title"];

$content = '
<h2>Edit News Article "' . $article_title . '"</h2>
<article>
<form class="form" action="editnewsarticle.php" method="post">
		<label>New Article Title:</label>
			<input type="text" placeholder="if changed" name="new_article_title" />
		<label>Category:</label>
		<select name="new_category_name">
			<option value="" disabled selected>Even if not changed</option>';

				//prepared statement to select all categories
				$results = $pdo->prepare('SELECT * FROM categories');
				$results->execute();

				foreach ($results as $row)
				{
					$content = $content. '

					<option value="'. $row['category_name'].'">'. $row['category_name'].'</option>';
				}

$content =$content.'
		</select>
		<label>Article Content:</label>
	    	<textarea name="new_article_content"></textarea>
		<label>Edited By:</label>
			<input type="text" placeholder="Username" name="new_article_author" required />

		<input type="submit" value="Submit" name="submit" />
	</form>
	</article>

';


//Editing Article once submit has been pressed
	if (isset($_POST['new_article_title'], $_POST['new_category_name'], $_POST['new_article_content'], $_POST['new_article_author'])) {

	  $new_article_title = $_POST['new_article_title'];
		$new_category_name = $_POST['new_category_name'];
		$new_article_content = $_POST['new_article_content'];
		$new_article_author = $_POST['new_article_author'];
		$date = date('Y-m-d H:i:s');



				//Update category name
				$pdo->query('UPDATE articles SET category = "' . $new_category_name . '"
										WHERE title = "' . $article_title . '"');

				//Insert new date for the article
				$pdo->query('INSERT INTO articles (date)
 		         VALUES ("' . $date . '")');


				//If new news article isn't blank
				if($new_article_title != ""){

			    $pdo->query('UPDATE articles SET title = "' . $new_article_title . '"
			                WHERE title = "' . $article_title . '"');

			    echo "$article_title - has been successfully changed to $new_article_title  -";
			  }
			  else {
			    echo  "No news title change  -";
			  }

				//If article content has been changed
				if($new_article_content != ""){

					$pdo->query('UPDATE articles SET article_text = "' . $new_article_content . '"
											WHERE title = "' . $article_title . '"');

					echo "$article_title content has been successfully changed  -";
				}
				else {
					echo  "No article content change  -";
				}

	}

	//End of admin logged in IF
	}
	else {
		$content = 'Sorry, please log in as an admin to view this page';
	}


require '../layout.php';
?>
