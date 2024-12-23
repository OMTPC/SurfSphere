
<!-- 
 Title: delete user script
 Created by: Orlando Caetano
 Date: 17/10/2024 
 Discription: This script handles the removal of the 'admin' role from a specified user. It first retrieves the roleID for the 'admin' role, 
              then deletes the user's admin role from the `member_roles` table based on their user ID. 
              It also remove a user from the database.
              After successful role removal, the script redirects back to the admin page.
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

<?php

session_start();
include("../shared/db_connection.php");
include("../shared/functions.php");

// Ensure the user ID is set
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Start by deleting the user's roles from member_roles
    $deleteRoleQuery = "DELETE FROM member_roles WHERE memberID = ?";
    $stmt = $con->prepare($deleteRoleQuery);
    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error deleting user roles: " . $con->error;
        exit();
    }

    // Now delete the user from the members table
    $deleteUserQuery = "DELETE FROM members WHERE membersID = ?";
    $stmt = $con->prepare($deleteUserQuery);
    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
        // Redirect back to admin page after successful deletion
        redirectTo("../private/admin.php");
        exit();
    } else {
        echo "Error deleting user: " . $con->error;
    }
} else {
    echo "No user ID specified.";
}
?>
