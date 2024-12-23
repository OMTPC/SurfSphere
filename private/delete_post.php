<!-- 
 Title: delete posts script
 Created by: Orlando Caetano
 Date: 17/10/2024 
 Discription: 
 Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>. see About page
-->

<?php
// Start the session to access session variables
session_start();

// Include the database connection
include("../shared/db_connection.php");

// Check if the user is logged in
if (!isset($_SESSION['membersID'])) {
    header("Location: ../public/login.php");
    exit();
}

// Check if the post ID is set
if (isset($_POST['postID'])) {
    $postID = $_POST['postID'];
    $membersID = $_SESSION['membersID'];
    $userRole = $_SESSION['roleName'];


    // Admins can delete any post, but regular users can only delete their own posts
    if ($userRole == 'admin') {
        // Admins can delete any post, no need to check membersID
        $deleteQuery = "DELETE FROM posts WHERE postID = ?";
        $stmt = $con->prepare($deleteQuery);
        $stmt->bind_param("i", $postID);
    } else {
        // Regular users can only delete their own posts
        $deleteQuery = "DELETE FROM posts WHERE postID = ? AND membersID = ?";
        $stmt = $con->prepare($deleteQuery);
        $stmt->bind_param("ii", $postID, $membersID);
    }

        // Execute the statement
    if ($stmt->execute()) {
            
        if ($stmt->affected_rows > 0) {
            
            echo "Post deleted successfully.";
            header("Location: ../private/profile.php");
            exit();
        } else {
            // Post not found or no permission to delete
            echo "Post not found or you do not have permission to delete it.";
        }
    } else {
        // Error executing the statement
        echo "Error executing delete statement.";
    }
    $stmt->close();
} else {
    // No post ID provided
    echo "No post ID provided.";
}

// Close the database connection
$con->close();
?>

