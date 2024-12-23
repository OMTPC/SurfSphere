<!-- 
 Title: database connection  
 Created by: Orlando Caetano
 Date: 03/10/2024 
 Discription: This script establishes a connection to the MySQL database using MySQLi.
              This file is essential for enabling interactions with the database in other parts of the application.
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

<?php

// variables to hold database login info
$dbhost = "lochnagar.abertay.ac.uk";
$dbuser = "sql2209032";
$dbpass = "mary-needle-killing-someone";
$dbname = "sql2209032";

// attempt to connect to database
if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("Failed to connect!");
} 
?>
