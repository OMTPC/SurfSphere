<!-- 
 Title: functions
 Created by: Orlando Caetano
 Date: 14/10/2024 
 Discription: This script handles the upload and validation of a user's profile picture. It checks if the user is logged in, then processes the file uploaded by the user. 
              The file is validated for type (only JPG, PNG, and GIF are allowed) and size (maximum of 5MB). If the file passes validation, it is given a unique name and 
              moved to the 'uploads' directory. The file path is then updated in the user's profile in the database. If any errors occur during this process, appropriate 
              error messages are displayed, and further execution is halted.
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

<?php
// error handling 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session to access session variables
session_start();

// Include the database connection
include("../shared/db_connection.php");

// Check if the user is logged in
if (!isset($_SESSION['membersID'])) {
    header("Location: ../public/login.php");
    exit; 
}

// Define allowed file types and size
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxFileSize = 5 * 1024 * 1024; // 5MB

if (isset($_FILES['profilePicture'])) {
    $file = $_FILES['profilePicture'];
    $userID = $_SESSION['membersID'];

    // Validate file type
    $fileType = strtolower($file['type']); 
    if (!in_array($fileType, $allowedTypes)) {
        echo "Error: Only JPG, PNG, and GIF files are allowed.";
        exit; 
    }

    // Validate file size
    if ($file['size'] > $maxFileSize) {
        echo "Error: File size exceeds 5MB limit.";
        exit; 
    }

    // Assign a unique name to the file and move it to the 'uploads' folder
    $fileName = uniqid() . '-' . basename($file['name']);
    $uploadPath = '../uploads/' . $fileName; 

    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // Update the profile picture path in the database
        $query = "UPDATE members SET profilePicture = '$fileName' WHERE membersID = '$userID'";
        
        if (mysqli_query($con, $query)) {
            
            header("Location: ../private/profile.php");
            exit; 
        } else {
            echo "Error: Could not update the database.";
            exit; 
        }
    } else {
        echo "Error: Failed to upload the file.";
        exit; 
    }
} else {
    echo "Error: No file was uploaded.";
    exit; 
}
?>
