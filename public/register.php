<!-- 
 Title: register page
 Created by: Orlando Caetano
 Date: 10/10/2024 
 Updated: 17/10/2024
 Discription: This PHP script facilitates the user registration process for the SurfSphere social media website. 
              It starts by checking if the user is already logged in and redirects them to the homepage if they are. 
              If the registration form is submitted, the script sanitizes and validates the user input.
              It hashes the password for security and stores the new user's information in the database. 
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

<?php

    // Start output buffering
    ob_start();

    // Start the session to access session variables
    session_start();

    // Include the database connection
    include("../shared/db_connection.php");
    include("../shared/functions.php");

    // Set the page-specific title
    $pageTitle = "Registration";  

    // Include the header for the webpage
    include("../shared/header.php");

    // Check if the registration form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPassword = password_hash($_POST['userPassword'], PASSWORD_DEFAULT); 

    // Check if the username already exists
    $checkQuery = "SELECT * FROM members WHERE userName = ?";
    $checkStmt = $con->prepare($checkQuery);
    $checkStmt->bind_param("s", $userName);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists
        $message = "Username already taken. Please choose a different one.";
        echo "<script>Swal.fire('Error!', '$message', 'error');</script>";
        } else {    
    // Prepare to insert into the members table
    $query = "INSERT INTO members (userName, userEmail, userPassword) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sss", $userName, $userEmail, $userPassword);

    if ($stmt->execute()) {
        // Get the inserted member ID
        $memberID = $stmt->insert_id; 

        // Assign the default role 
        $defaultRoleID = 2; // 2 is the default 'user' role
        $roleQuery = "INSERT INTO member_roles (memberID, roleID) VALUES (?, ?)";
        $roleStmt = $con->prepare($roleQuery);
        $roleStmt->bind_param("ii", $memberID, $defaultRoleID);

        if ($roleStmt->execute()) {
            echo "<script>
            Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Registration successful. Redirecting to login page...',
                        timer: 3500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location = '../public/login.php';
                    });
                </script>";
        } else {
            echo "Error assigning role: " . $con->error;
        }
    } else {
        echo "Error registering user: " . $con->error;
    }
}
}
?>

<!-- Main section for the register page  -->
<main class="container flex-fill mt-5">

    <h2 class="styleRegister">Register</h2>
    
    <!-- The registration form -->
    <form action="register.php" method="post">
        <div class="mb-3">
            <label for="userName" class="form-label"><b>Username</b></label>
            <input type="userName" class="form-control" id="userName" name="userName" required style="width: 350px">
        </div>
        <div class="mb-3">
            <label for="userEmail" class="form-label"><b>Email</b></label>
            <input type="userEmail" class="form-control" id="userEmail" name="userEmail" required style="width: 350px">
        </div>
        <div class="mb-3">
            <label for="userPassword" class="form-label"><b>Password</b></label>
            <input type="password" class="form-control" id="userPassword" name="userPassword" required style="width: 350px">
        </div>
        <button type="submit" class="btn btn-primary register-button">Register</button>
    </form>

</main>

<!-- Include the footer for the webpage-->
<?php include("../shared/footer.php");?>  