<!-- 
 Title: Login page
 Created by: Orlando Caetano
 Date: 10/10/2024 
 Description: This PHP script handles user login functionality. It includes the necessary HTML form for users to 
              input their credentials, processes the form data to authenticate users. If successful, the user is redirected to their profile page. 
              The script also ensures input validation and sanitization to prevent security vulnerabilities.
 Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>. see About page
-->

<?php
    // Start output buffering
    ob_start();

    // Start the session to access session variables
    session_start();

    // Include the database connection and function files for functionality
    include ("../shared/db_connection.php");
    include ("../shared/functions.php");

    // Set the page-specific title
    $pageTitle = "Login";  

    // Include the header for the webpage
    include("../shared/header.php");
    
    // Check if the form has been submitted via POST
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve posted data from the form
        $userName = $_POST['userName'];
        $userPassword = $_POST['userPassword'];
        $selectedRole = $_POST['roleName']; 

    // Validate the input
    if (!empty($userName) && !empty($userPassword) && ValidateInput($userName)) {
        // Query to fetch the user's details along with their role
        $sql = "SELECT m.userPassword, m.membersID, r.roleName
                FROM members m
                INNER JOIN member_roles mr ON m.membersID = mr.memberID
                INNER JOIN roles r ON mr.roleID = r.roleID
                WHERE m.userName = ? AND r.roleName = ?";
        
        $result = SafeQuery($con, $sql, [$userName, $selectedRole]);

        // If a record is found
        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $hashedPassword = $user_data['userPassword'];
            $actualRole = $user_data['roleName'];
            
            // Verify the password
            if (VerifyPassword($userPassword, $hashedPassword)) {

                // Check if the selected role matches the actual role in the database
                if ($selectedRole !== $actualRole) {
                    // If the role does not match, set the message
                    $message = "The role you selected is incorrect. Please select the correct role.";
                    echo "<script>Swal.fire('Error!', '$message', 'error');</script>";
                } else {
                    // Set session variables if the role matches
                    $_SESSION['membersID'] = $user_data['membersID'];
                    $_SESSION['roleName'] = $actualRole;

                    // Redirect based on role
                    if ($actualRole === 'admin') {
                        redirectTo("../private/admin.php");
                    } else if ($actualRole === 'user') {
                        redirectTo("../private/profile.php");
                    }
                    die;
                }
            } else {
                // If password verification fails
                $message = "Wrong password! Please try again.";
                echo "<script>Swal.fire('Error!', '$message', 'error');</script>";
            }
        } else {
            // If no user is found with the provided username and selected role
            $message = "Wrong username! Please try again.";
            echo "<script>Swal.fire('Error!', '$message', 'error');</script>";
        }
    } else {
        $message = "Please enter a valid username or password!";
        echo "<script>Swal.fire('Error!', '$message', 'error');</script>";
    }
    }
?>

<!-- Main section for the Login page  -->
<main class="container flex-fill mt-5">

    <h2 class="styleRegister">Login</h2>

    <!-- The login form -->
    <form id="loginForm" action="login.php" method="post">
        <div class="mb-3">
            <label for="roleName" class="form-label"><b>Select Role</b></label>
            <select class="form-select" id="roleName" name="roleName" required style="width: 350px; background-color: #e8f0fe">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="userName" class="form-label"><b>Username</b></label>
            <input type="userName" class="form-control" id="userName" name="userName" required style="width: 350px">
        </div>
        <div class="mb-3">
            <label for="userPassword" class="form-label"><b>Password</b></label>
            <input type="password" class="form-control" id="userPassword" name="userPassword" required style="width: 350px">
        </div>
        <button type="submit" class="btn btn-primary register-button">Login</button>
    </form>

    <br><h4 class="styleRegister">Don't Have an account?</h4>
    <a href="register.php" style="color: #001862; font-weight: bold; font-size: 20px;">Click to Signup</a><br><br>

</main>

<!-- Include the footer for the webpage-->
<?php include("../shared/footer.php");?>

