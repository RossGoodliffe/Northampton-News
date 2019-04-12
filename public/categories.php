<?php

//Connection to database
require '../databaseconnection.php';

		//prepare stmt to get category names from categories table
		$results = $pdo->prepare('SELECT * FROM categories');
		$results->execute();

		foreach ($results as $row)
		{
		  echo '<a href="">'. $row['category_name'] . '</a>';
		}
?>
