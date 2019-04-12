<?php
//title of webpage
$title = 'Admin Homeage';

session_start();

//only displayd if an admin user is logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

//list of a href links to all admin pages
$content ='
<h2>Admin Page</h2>
<nav>
  <ul>
    <li><a href="createadmin.php">Create Admin Account</a></li>
    <li><a href="addcategory.php">Add News Category</a></li>
    <li><a href="addnewsarticle.php">Add News Article</a></li>
    <li><a href="deletenewsarticle.php">Delete News Article</a></li>
    <li><a href="editadminaccount.php">Edit Admin Account</a></li>
    <li><a href="editcategory.php">Edit News Category</a></li>
    <li><a href="selectnewsacrticletoedit.php">Edit News Article</a></li>
    <li><a href="deletenewscategory.php">Delete News Category</a></li>
    <li><a href="deleteadminaccount.php">Delete Admin Account</a></li>
  </ul>
</nav>
';

}
else {
  $content = 'Sorry, please log in as an admin to view this page';
}

require '../layout.php';
?>
