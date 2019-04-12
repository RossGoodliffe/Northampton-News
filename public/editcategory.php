<?php
$title = 'Edit Category';

session_start();

//Connection to database
require '../databaseconnection.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
$content = '
<h2>Edit Category</h2>
<form class="form" action="editcategory.php" method="post">
  <label>Category Name:</label>
    <select name="category_name">
      <option value="" disabled selected>Please Select</option>';

    //prepared statement to select all categories
    $results = $pdo->prepare('SELECT * FROM categories');
    $results->execute();

    foreach ($results as $row)
    {
      $content = $content. '

      <option value="'. $row['category_name'].'">'. $row['category_name'].'</option>';
    }

  //content variable continues
  $content =$content.'
    </select>
  <label>New Category Name:</label>
    <input type="text" name="new_category_name" required />

  <input type="submit" value="Submit" name="submit" />
</form>
';

if (isset($_POST['category_name'], $_POST['new_category_name'])) {

$category_name = $_POST['category_name'];
$new_category_name = $_POST['new_category_name'];


//prepared statement to update the category name in Categories table
$stmt = $pdo->prepare('UPDATE categories SET category_name=:new_category WHERE category_name=:old_category');

$criteria = [
  'old_category' => $_POST['category_name'],
  'new_category' => $_POST['new_category_name']
];

unset($_POST['submit']);
$stmt->execute($criteria);

//prepared statement to update all the articles with the new category name in the Articles table
$stmt1 = $pdo->prepare('UPDATE articles SET category=:new_category WHERE category=:old_category');

unset($_POST['submit']);
$stmt1->execute($criteria);


echo "Category name $category_name has successfully been changed to $new_category_name";
}

//End of admin logged in IF
}
else {
	$content = 'Sorry, please log in as an admin to view this page';
}

require '../layout.php';
?>
