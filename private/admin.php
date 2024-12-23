<!-- 
 Title: Admin page
 Created by: Orlando Caetano
 Date: 17/10/2024 
 Discription:This page provides the administrative interface for managing users on the website. It displays a table of all registered users, 
             including their IDs, usernames, email addresses, and assigned roles. Admins can edit or delete user information. 
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

<?php

    // Start the session
    session_start();

    // Include the database connection
    include("../shared/db_connection.php");
    include("../shared/functions.php");

    // Set the page-specific title
    $pageTitle = "Admin";

    // Check if the user is logged in and is an admin
    if (!isset($_SESSION['roleName']) || $_SESSION['roleName'] !== 'admin') {
        // Redirect to login page if not admin
        redirectTo("../public/login.php");
        exit();
    }

    // Include the header for the webpage
    include("../shared/header.php");

    // Fetch all users and role from the database
    $query = "SELECT m.membersID, m.userName, m.userEmail, r.roleName 
            FROM members m
            LEFT JOIN member_roles mr ON m.membersID = mr.memberID
            LEFT JOIN roles r ON mr.roleID = r.roleID";
    $result = $con->query($query);
?>

    <!-- Main section for the admin page -->
    <main class="container flex-fill mt-5">
        <h2 class="text-center" style="font-family: 'Surfbars', Arial, sans-serif; font-size: 44px" >Admin Dashboard</h2>

        <h3>User Management</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="color: #001862">ID</th>
                    <th style="color: #001862">Username</th>
                    <th style="color: #001862">Email</th>
                    <th style="color: #001862">Role</th>
                    <th style="color: #001862">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['membersID']; ?></td>
                    <td>
                        <a href="../private/profile.php?membersID=<?php echo $row['membersID']; ?>&from=admin">
                            <?php echo htmlspecialchars($row['userName']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($row['userEmail']); ?></td>
                    <td><?php echo htmlspecialchars($row['roleName']); ?></td>
                    <td>
                        <a href="../private/edit_admin.php?id=<?php echo $row['membersID']; ?>" class="btn btn-warning btn-sm">Edit</a>


                        <a href="#" 
                            class="btn btn-danger btn-sm" 
                            onclick="event.preventDefault(); Swal.fire({
                                title: 'Are you sure?',
                                text: 'You are about to delete the user: <?php echo addslashes($row['userName']); ?>. This action cannot be undone.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '../private/delete_admin.php?id=<?php echo $row['membersID']; ?>';
                                }
                            });">
                            Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <!-- Include the footer for the webpage -->
    <?php include("../shared/footer.php"); ?>
