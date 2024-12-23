<!-- 
 Title: Update Profile 
 Created by: Orlando Caetano
 Date: 14/10/2024 
 Discription: This PHP script manages the functionality for updating a user’s bio on the SurfSphere social media website.
 Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

<?php
// Start the session to access session variables
session_start();

// Include the database connection and function files for functionality
include("../shared/db_connection.php");
include("../shared/functions.php"); 

// Check if the user is logged in
if (!isset($_SESSION['membersID'])) {
    redirectTo("../public/login.php");
    exit;
}

// Get user ID from session
$userID = $_SESSION['membersID'];

// Check if the bio is set
if (isset($_POST['bio'])) {
    // Sanitize input to prevent SQL injection
    $bio = sanitizeInput($con, trim($_POST['bio'])); 

    // Update bio in the database
    if (updateBio($con, $userID, $bio)) { 
        redirectTo("../private/profile.php?update=success"); 
    } else {
        // Handle error
        echo "Error: Could not update the bio.";
        exit;
    }
}  
// If bio was not set, redirect back
redirectTo("../private/profile.php");
exit;
?>


