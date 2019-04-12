<?php
$title = 'Northampton News';

//Connection to database
require '../databaseconnection.php';


$content = '
<h2>Latest Articles</h2>

';

  //prepare statment to select all articles and order by date
  $results = $pdo->prepare('SELECT * FROM articles ORDER BY date DESC');
  $results -> execute();

  //Adding news acrticles to homepage in date order.
  foreach ($results as $row) {

  //Changing the admin_id to the admin username to be displayed with article
    $Convert = $pdo->prepare('SELECT username FROM admins WHERE admin_id="' .$row['admin_id']. '"');
    $Convert -> execute();

    foreach ($Convert as $usernameConvert) {
      $adminusername = $usernameConvert['username'];
    }

  //content variable continues
  $content = $content . '

  <a href="article.php?article='. $row['article_id'] . '" id="News-heading" >' .$row['title']. '</a>
  <p><img src="' .$row['image']. '" id="News-image">  </p>
  <p id="">News Category: ' .$row['category']. '</p>
  <p>' .$row['article_text']. '</p>
  <p>' .$row['date']. '</p>
  <p>News author: <a href="articlesfromauthors.php?author='. $row['admin_id'] . '">' .$adminusername. '</a></p>';
}


require '../layout.php';
?>
