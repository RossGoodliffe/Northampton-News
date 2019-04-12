<?php
$title = 'News Articles';

session_start();

//Connection to database
require '../databaseconnection.php';

$category = $_GET['category'];

$content = '
  <h2>Latest ' . $category . ' Articles</h2>
  <article>
  ';
  
  //Getting all the articles from the database
  $results = $pdo->prepare('SELECT * FROM articles WHERE category="' . $category . '" ORDER BY date DESC ');
  $results -> execute();

  //Getting all the comments from the database
  $results1 = $pdo->prepare('SELECT * FROM comments');
  $results1 -> execute();

  //Adding news acrticles to page with a specific category.
  foreach ($results as $row) {
    $content = $content . '
      <a href="article.php?article='. $row['article_id'] . '" id="News-heading" >' .$row['title']. '</a>
      <p id=""><img src="' .$row['image']. '">  </p>
      <p id="">News Category: ' .$row['category']. '</p>
      <p id="">' .$row['article_text']. '</p>
      <p id="">' .$row['date']. '</p>';

      //Changing the admin_id to the admin username to be displayed with article
      $Convert = $pdo->prepare('SELECT username FROM admins WHERE admin_id="' .$row['admin_id']. '"');
      $Convert -> execute();

      foreach ($Convert as $usernameConvert) {
          $adminusername = $usernameConvert['username'];
      }

    $content = $content . '
      <p>News author: <a href="articlesfromauthors.php?author='. $row['admin_id'] . '" id="News-author">' .$adminusername   . '</a></p>


      ';
  }
$content = $content.'

  </article>
';


require '../layout.php';
?>
