<!-- 
 Title: like submittion script
 Created by: Orlando Caetano
 Date: 17/10/2024 
 Discription: This script allows users to like a post by submitting a form. It checks if the user is logged in and whether the post ID is provided. 
              The script ensures that the user has not already liked the post before inserting a new like into the database. If a like already exists, 
              the user is informed, and in both cases, the script redirects back to the dashboard. If any input is missing or invalid, the user is redirected with an error.
 Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>. see About page
-->

<?php
    // Start the session to access session variables
    session_start();
    // Include the database connection
    include("../shared/db_connection.php");

    if (isset($_POST['postID']) && isset($_SESSION['membersID'])) {
        
        $postID = (int)$_POST['postID'];
        $membersID = (int)$_SESSION['membersID']; 

        // Check if the user has already liked the post
        $query = "SELECT * FROM likes WHERE postID = ? AND membersID = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "ii", $postID, $membersID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 0) {
            // If no like exists, insert a new like
            $query = "INSERT INTO likes (postID, membersID) VALUES (?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "ii", $postID, $membersID);

            if (mysqli_stmt_execute($stmt)) {
                // Redirect back to the dashboard after successful like
                header("Location: ../private/dashboard.php?liked=1");
                exit();
            } else {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            // User already liked the post
            header("Location: ../private/dashboard.php?already_liked=1");
            exit();
        }
    } else {
        // Redirect in case of invalid input
        header("Location: ../private/dashboard.php?error=1");
        exit();
    }
    ?>
