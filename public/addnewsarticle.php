<?php
//title of webpage
$title = 'Add News Article';

session_start();

//Connection to database
require '../databaseconnection.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

$admin_id = $_SESSION['admin_id'];

$content = '
<h2>Add News Article</h2>
<article>
<form class="form" action="addnewsarticle.php" method="post" enctype="multipart/form-data">
		<label>Article Title:</label>
			<input type="text" name="article_title" required />
		<label>Article Category:</label>
		<select name="article_cat">
			<option value="" disabled selected>Please Select</option>';

				//prepare stmt to load categories
				$results = $pdo->prepare('SELECT * FROM categories');
				$results->execute();

				//viewing results in form
				foreach ($results as $row)
				{
					$content = $content. '

					<option value="'. $row['category_name'].'">'. $row['category_name'].'</option>';
				}

//content variable continues
$content =$content.'
		</select>
		<label>Article Content:</label>
	    <textarea name="article_content"></textarea>
		<label>Upload Image:</label>
			<input type ="file" name="image">


		<input type="submit" value="Submit" name="submit" />
	</form>
	</article>
  ';

//Adding data once submit has been pressed
	if (isset($_POST['article_title'], $_POST['article_cat'], $_POST['article_content'])) {


	    $article_title = $_POST['article_title'];
			$date = date('Y-m-d H:i:s');
/*
Khodke, P. (2018). Upload, Insert, Update, Delete an Image using PHP MySQL.[online] Codingcage.com.
Available at: http://www.codingcage.com/2016/02/upload-insert-update-delete-image-using.html
[Accessed 12 Jan. 2018].
*/
			$image = $_FILES['image']['name'];
			$image_path = 'news_images/'.$image.'';
			$tmp_dir = $_FILES['image']['tmp_name'];

			//Copying image file to news_images folder
			if (copy($_FILES['image']['tmp_name'], $image_path)){

			}

			//prepare stmt to add news article to articles table
			$stmt = $pdo->prepare('INSERT INTO articles (title, category, article_text, admin_id, date, image)
						VALUES ( :title, :category, :article_text, :admin_id, :date, :image)');

			$criteria = [
				'title' => $_POST['article_title'],
				'category' => $_POST['article_cat'],
				'article_text' => $_POST['article_content'],
				'admin_id' => $admin_id,
				'date' => $date,
				'image' => $image_path
			];

			unset($_POST['submit']);
			$stmt -> execute($criteria);

	          echo " $admin_id has successfully been created to News article $article_title";

	}
}		//End of admin logged in IF stmt
else {
	$content = 'Sorry, please log in as an admin to view this page';
}

require '../layout.php';
?>
