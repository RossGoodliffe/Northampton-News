<!--<!DOCTYPE html> -->
<html>
	<head>
		<link rel="stylesheet" href="styles.css"/>
		<title>
			<?php
				echo $title;
			 ?>
		</title>
	</head>
	<body>
		<header>
			<section>
				<h1>Northampton News</h1>
			</section>
		</header>
		<nav>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="latestnewsarticles.php">Latest Articles</a></li>
				<li><a href="#">Select Category</a>
					<ul>
						<?php

							require '../databaseconnection.php';

							//prepare statment to select all categories
								$results = $pdo->prepare('SELECT * FROM categories ');
								$results -> execute();

								foreach ($results as $row)
								{
								  echo '<a href="categoryarticles.php?category='. $row['category_name'] . '">'. $row['category_name'] . '</a><br>';
								}

						?>
					</ul>
				</li>
				<li><a href="contact.php">Contact us</a></li>
				<li><a href="register.php">Register</a></li>
				<li><a href="adminlogin.php">Admin</a></li>
				<li><a href="login.php">Login</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</nav>
		<img src="images/banners/randombanner.php" />
		<main>
			<!-- Delete the <nav> element if the sidebar is not required -->
			<nav>
				<ul>
					<li>
							<?php

								require '../databaseconnection.php';

								//prepare statement to select all categories
								$results = $pdo->prepare('SELECT * FROM categories ');
								$results -> execute();

									foreach ($results as $row)
									{
									   echo '<a href="categoryarticles.php?category='. $row['category_name'] . '">'. $row['category_name'] . '</a><br>';
									}
							?>
					</li>
				<ul>
			</nav>
			<article>
				<?php
					echo $content;
				?>
			</article>
		</main>

		<footer>
			&copy; Northampton News 2017
		</footer>

	</body>
</html>
