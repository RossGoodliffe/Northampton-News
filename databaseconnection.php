<?php

//Connecting to database variables
$server = 'assignment1.v.je';
$usernameone = 'student';
$passwordone = 'student';
$schema = "assignment1";


//Connection being made to MySQL database.
$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $usernameone, $passwordone,
  [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

 ?>
