<!-- 
 Title: logout
 Created by: Orlando Caetano
 Date: 10/10/2024 
 Discription: This PHP script handles user logout functionality for the SurfSphere social media website. 
              It starts the session, checks if the user is logged in, and unsets the session variable associated with the user's ID to log them out. 
              After successfully logging out, the user is redirected to the homepage. 
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->



<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the index page
header("Location: ../public/index.php");
exit();
?>
