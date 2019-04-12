<?php
$title = 'Delete News Category';

session_start();

//Connection to database
require '../databaseconnection.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
$content = '
<h2>Delete News Category</h2>
<form class="form" action="deletenewscategory.php" method="post">
  <label>News Category:</label>
    <select name="category">
      <option value="" disabled selected>Please Select</option>';

    //prepared statement to select all categories
    $results = $pdo->prepare('SELECT * FROM categories');
    $results->execute();

    foreach ($results as $row)
    {
      $content = $content. '<option value="'. $row['category_id'].'">'. $row['category_name'].'</option>';
    }

//content variable continues
$content = $content.'
    </select>

    <input type="submit" value="Delete" name="submit" />
</form>
';


//If delete button is pressed delete news category Username
if (isset($_POST['category']))
{

  //prepare statement to delete category from categories table
  $results = $pdo->prepare('DELETE FROM categories WHERE category_id=:category');

  $delete_category =[
    'category'=> $_POST['category']
  ];

  unset($_POST['submit']);
  $results->execute($delete_category);

  echo "News category has successfully been deleted";

}

//End of admin logged in IF
}
else {
	$content = 'Sorry, please log in as an admin to view this page';
}

require '../layout.php';
?>
