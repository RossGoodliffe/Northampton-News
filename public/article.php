<?php
$title = 'News Articles';

session_start();

//Connection to database
require '../databaseconnection.php';

//Information passed from URL to locate article
$article_id = $_GET['article'];

  //Prepare statment to get article information
  $results = $pdo->prepare('SELECT * FROM articles WHERE article_id="' . $article_id . '"');
  $results -> execute();

  //Adding news acrticle to page using article_id
  foreach ($results as $row) {

    //news article information and image
    $content = '
      <h2 id="News-heading">' .$row['title']. '</h2>
        <article>
    ';

    //Changing the admin_id to the admin username to be displayed with article
      $Convert = $pdo->prepare('SELECT username FROM admins WHERE admin_id="' .$row['admin_id']. '"');
      $Convert -> execute();

      foreach ($Convert as $usernameConvert) {
        $adminusername = $usernameConvert['username'];
      }

      //content variable continued
      $content = $content . '
      <p><img src="' .$row['image']. '" id="News-image">  </p>
      <p id="">News Category: ' .$row['category']. '</p>
      <p id="">' .$row['article_text']. '</p>
      <p id="">' .$row['date']. '</p>
      <p>Created By:
        <a href="articlesfromauthors.php?author='. $row['admin_id'] . '" id="News-author">
          ' .$adminusername. '</a></p>
      <h3 id="Comments">Comments:</h3>
      </article>
      ';
  }

  //Prepare statement to get comments related to article_id
  $results1 = $pdo->prepare('SELECT * FROM comments WHERE article_id="' . $article_id . '"');
  $results1 -> execute();

  //Displaying already made comments on news article
  foreach ($results1 as $row1){

    //Converting user_id to username
    $ConvertUser = $pdo->prepare('SELECT username FROM users WHERE user_id="' .$row1['user_id']. '"');
    $ConvertUser -> execute();

    foreach ($ConvertUser as $userConvert) {
      $username = $userConvert['username'];
    }

    //content variable continues
    $content = $content. '
      <p id="Comment-username"><b>' . $username .'</b> commented on '. $row1['date'] .'</p>
      <p id="Comment-content">' . $row1['comments_text'] .'</p>
    ';
  }


//Checks if user is logged in before displaying enter comments section
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {

  //Form for adding comments to a news artcile
  $content = $content.'
    <h3 id="Comments">Enter your comment</h3>

    <form action="article.php?article='. $article_id . '" method="post">
      <label>Please Enter your comments here:</label>
        <textarea name="comment" placeholder="Max 200 Characters"></textarea>

      <input type="submit" value="Submit" name="submit" />
    </form>
    ';

//If comment submit button is pressed
if (isset($_POST['comment'])){

  //Information passed from session to state user.
  $current_user = $_SESSION['user'];

  //prepare stmt to locate user ID from current user
  $user_search = $pdo->prepare('SELECT user_id FROM users WHERE username = "' . $current_user . '"');
  $user_search -> execute();

  foreach ($user_search as $row2){
    $logged_in_user_id = $row2['user_id'];
  }

  $date = date('Y-m-d H:i:s');

  //prepare stmt to add comments into to comments table
  $stmt1 = $pdo->prepare('INSERT INTO comments (comments_text, date, user_id, article_id)
                        VALUES ( :comment, :date, :user_id, :article_id)');

  $criteria = [
    'comment' => $_POST['comment'],
    'date' => $date,
    'user_id' => $logged_in_user_id,
    'article_id' => $article_id
  ];

  unset($_POST['submit']);
  $stmt1 -> execute($criteria);

}

}
//IF a user is not logged in this message will display instead of comments
else {

  //content variable continues
  $content = $content .'
    <h3>Please Create an account or Log in to add a comment</h3>
  ';
}

require '../layout.php';
?>
