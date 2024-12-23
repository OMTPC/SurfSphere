<!-- 
 Title: upload_post 
 Created by: Orlando Caetano
 Date: 14/10/2024 
 Discription: This PHP script facilitates the uploading of user posts, allowing users to add text and an optional image 
              to their profiles on the SurfSphere social media website. It handles file uploads, validates file types, and 
              inserts the post data into the database while ensuring the user is logged in before proceeding. 
 Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->
<?php

session_start();
include("../shared/db_connection.php");

if (!isset($_SESSION['membersID'])) {
    redirectTo("../public/login.php");
    exit;
}

$membersID = $_SESSION['membersID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the post text
    $postText = mysqli_real_escape_string($con, $_POST['postText']);

    // Check if an image was uploaded
    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imageUpload']['tmp_name'];
        $fileName = $_FILES['imageUpload']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileSize = $_FILES['imageUpload']['size'];

        // Define the allowed extensions
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 5 * 1024 * 1024;

        // Validate the file type
        if (in_array(strtolower($fileExtension), $allowedFileTypes)) {
            if ($fileSize <= $maxFileSize) {
            $newFileName = uniqid() . '.' . $fileExtension;
            $uploadFileDir = '../uploads/posts/';
            $destPath = $uploadFileDir . $newFileName;
                }
            // Move the uploaded file
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Insert the post data into the database
                $query = "INSERT INTO posts (membersID, imagePath, postText) VALUES ('$membersID', '$newFileName', '$postText')";
                if (mysqli_query($con, $query)) {
                    header("Location: ../private/profile.php?upload=success");
                    exit;
                } else {
                    echo "Error uploading the post.";
                }
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Unsupported file type.";
        }
    } else {
        echo "No image uploaded.";
    }
}
?>