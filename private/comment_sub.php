<!-- 
 Title: comments submittion script
 Created by: Orlando Caetano
 Date: 17/10/2024 
 Discription: This script handles the submission of comments on posts. It checks if the user is logged in and 
              if the required data (comment text and post ID) is provided. Once validated, it sanitizes the input and inserts 
              the comment into the database. If successful, the user is redirected to the dashboard; otherwise, an error is displayed.
 Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>. see About page
-->

<?php
session_start();
include("../shared/db_connection.php");

// Check if user is logged in
if (!isset($_SESSION['membersID'])) {
    // Redirect if user is not logged in
    header("Location: ../private/dashboard.php");
    exit();
}

// Check if comment text and post ID are set
if (isset($_POST['commentText'], $_POST['postID'])) {
    
    $commentText = $_POST['commentText'];
    $postID = (int)$_POST['postID'];
    $membersID = $_SESSION['membersID']; 

    // Sanitize the comment text to prevent SQL injection
    $commentText = mysqli_real_escape_string($con, $commentText);

    // Prepare the SQL query to insert the comment
    $query = "INSERT INTO comments (postID, membersID, commentText) VALUES ('$postID', '$membersID', '$commentText')";

    // Execute the query
    if (mysqli_query($con, $query)) {
        
        header("Location: ../private/dashboard.php");
        exit();
    } else {
        // Log error and redirect in case of failure
        echo "Error inserting comment: " . mysqli_error($con);
        exit();
    }
} else {
    // Redirect in case of invalid input
    header("Location: ../private/dashboard.php");
    exit();
}
?>
