<?php
$title = 'Articles by author';

session_start();

//Connection to database
require '../databaseconnection.php';

//Getting admin_id from previous page
$admin_id = $_GET['author'];

//Changing the admin_id to the admin username to be displayed with article
$results1 = $pdo->prepare('SELECT username FROM admins WHERE admin_id="' . $admin_id . '"');
$results1 -> execute();

foreach ($results1 as $row1) {
  $admin_username = $row1['username'];
}


$content = '
  <h2>News Articles by ' . $admin_username . '</h2>
  <article>
  ';

  //Prepared statement to retrieve all news articles created by admin id.
  $results = $pdo->prepare('SELECT * FROM articles WHERE admin_id="' . $admin_id . '" ORDER BY date DESC ');
  $results -> execute();

  //Adding news acrticles to page
  foreach ($results as $row) {
    $content = $content . '
      <a href="article.php?article='. $row['article_id'] . '" id="News-heading" >' .$row['title']. '</a>
      <p id=""><img src="' .$row['image']. '">  </p>
      <p id="">News Category: ' .$row['category']. '</p>
      <p id="">' .$row['article_text']. '</p>
      <p id="">' .$row['date']. '</p>
      <p id="">'.$admin_username.'</p>
      ';
  }
$content = $content.'
  </article>
';

require '../layout.php';
?>
