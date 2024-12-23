<!-- 
 Title: Edit details page
 Created by: Orlando Caetano
 Date: 17/10/2024 
 Discription: This script allows admin users to edit user details, including the username, email, and role. 
              It handles form submission for updating user information in the database and manages role assignment. 
              If a user role does not exist, the script inserts a new role entry for the user. 
              The script also fetches existing user data to pre-fill the form for editing, ensuring proper validation and feedback. 
              It redirects back to the admin page upon successful updates.
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

<?php

// Start output buffering
ob_start(); 

// Start the session to access session variables
session_start();

// Include the database connection and function files for functionality
include("../shared/db_connection.php");
include("../shared/functions.php");

include("../shared/header.php");

// Handle form submission for editing user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Form submitted!";
    
    $userId = $_POST['membersID']; 
    $userName = $_POST['userName'];  
    $userEmail = $_POST['userEmail'];
    $userRole = $_POST['userRole'];

    // Update the user information in the members table
    $updateQuery = "UPDATE members SET userName = ?, userEmail = ? WHERE membersID = ?";
    $stmt = $con->prepare($updateQuery);
    if ($stmt) {
        $stmt->bind_param("ssi", $userName, $userEmail, $userId);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error updating user: " . $con->error;
    }

    // Get the roleID from the roles table
    $roleQuery = "SELECT roleID FROM roles WHERE roleName = ?";
    $stmt = $con->prepare($roleQuery);
    if ($stmt) {
        $stmt->bind_param("s", $userRole);
        $stmt->execute();
        $stmt->bind_result($roleId);
        $stmt->fetch();
        $stmt->close();

        // Check if the role already exists for the user
        $checkRoleQuery = "SELECT COUNT(*) FROM member_roles WHERE memberID = ? AND roleID = ?";
        $stmt = $con->prepare($checkRoleQuery);
        $stmt->bind_param("ii", $userId, $roleId);
        $stmt->execute();
        $stmt->bind_result($roleCount);
        $stmt->fetch();
        $stmt->close();

        // If the role does not exist for the user, insert a new entry
        if ($roleCount == 0) {
            $insertRoleQuery = "INSERT INTO member_roles (memberID, roleID) VALUES (?, ?)";
            $stmt = $con->prepare($insertRoleQuery);
            if ($stmt) {
                $stmt->bind_param("ii", $userId, $roleId);
                $stmt->execute();
                $stmt->close();
            } else {
                echo "Error inserting role: " . $con->error;
            }
        }
    } else {
        echo "Error looking up role: " . $con->error;
    }

    // Redirect back to admin page
    redirectTo("../private/admin.php");
    exit();
}

// Fetch user data to pre-fill the form
$userId = $_GET['id']; 
$query = "SELECT members.membersID, members.userName, members.userEmail, roles.roleName 
          FROM members 
          JOIN member_roles ON members.membersID = member_roles.memberID 
          JOIN roles ON member_roles.roleID = roles.roleID 
          WHERE members.membersID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if user exists
if (!$user) {
    echo "User not found.";
    exit();
}

echo '<a href="../private/admin.php" class="btn btn-secondary register-button" style="margin-bottom: 20px;">
      <i class="fas fa-arrow-left"></i> Return to Admin Page</a>'; 
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<form action="../private/edit_admin.php" method="POST"><br><br>
    <input type="hidden" name="membersID" value="<?php echo $user['membersID']; ?>">

    <div style="margin-bottom: 20px;">
        <label for="userName" style="color: #001862"><b>Username</b></label>
        <input type="text" name="userName" value="<?php echo htmlspecialchars($user['userName']); ?>" required
        style="width: 350px; padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; background-color: #e8f0fe;">
    </div>

    <div style="margin-bottom: 20px;">
        <label for="userEmail" style="color: #001862"><b>Email</b></label>
        <input type="email" name="userEmail" value="<?php echo htmlspecialchars($user['userEmail']); ?>" required
        style="width: 350px; padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; background-color: #e8f0fe;">
    </div>
    
    <div style="margin-bottom: 20px;">
        <label for="userRole" style="color: #001862"><b>Role</b></label>
        <select name="userRole" style="width: 350px; padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; background-color: #e8f0fe;">
            <option value="user" <?php echo ($user['roleName'] == 'user') ? 'selected' : ''; ?>>User</option>
            <option value="admin" <?php echo ($user['roleName'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary signup-button">Update User</button>
</form>

<?php include("../shared/footer.php"); ?>
