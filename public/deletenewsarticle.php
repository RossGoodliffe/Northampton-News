<?php
$title = 'Delete News Article';

session_start();

//Connection to database
require '../databaseconnection.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
$content = '
<h2>Delete News Article</h2>
<form class="form" action="deletenewsarticle.php" method="post">
  <label>News Article:</label>
    <select name="news_article">
      <option value="" disabled selected>Please Select</option>';


    $results = $pdo->prepare('SELECT * FROM articles');
    $results->execute();

    foreach ($results as $row)
    {
      $content = $content. '<option value="'. $row['article_id'].'">'. $row['title'].'</option>';
    }

//content variable continues
$content = $content.'
    </select>

    <input type="submit" value="Delete" name="submit" />
</form>
';


//If delete button is pressed delete news category Username
if (isset($_POST['news_article']))
{
  $news_article = $_POST['news_article'];

  //prepare statement to delete article from articles table
  $stmt = $pdo->prepare('DELETE FROM articles WHERE article_id= :news_article');
  $stmt->bindParam(":news_article", $_POST['news_article']);
  $stmt->execute();

  echo "News article id - $news_article - has successfully been deleted";
}

//End of admin logged in IF
}
else {
	$content = 'Sorry, please log in as an admin to view this page';
}

require '../layout.php';
?>
