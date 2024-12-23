<!-- 
 Title: About page 
 Created by: Orlando Caetano
 Date: 16/10/2024 
 Discription: This page provides an overview of SurfSphere project
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

<?php
// Start the session to access session variables
session_start();

// Include the database connection and function files for functionality
include("../shared/db_connection.php");
include("../shared/functions.php");

// Set the page-specific title
$pageTitle = "About";  

// Include the header for the webpage
include("../shared/header.php");
?>

<!-- Main section for the About page  -->
<main class="container flex-fill mt-5">
    <h1>About Us</h1>

    <p style="font-size: 30px; font-weight: bold; text-align: justify">
        Welcome to SurfSphere! We are a social media platform dedicated to surfers and surf enthusiasts. Our mission is to create a community where members can share their experiences, showcase their surf skills, and connect with others who share their passion for the waves.
    </p>
    <p>
        <b>Final assessment for module Web Development<br>
        Created by: Orlando Caetano<br>
        Student Number: 2209032<br>
        Date: 17/10/2024</br>
        <a href="../References.pdf" target="_blank" class="styled-link" style="color: #001862">References</a>
    </p>

    <h2 style="font-family: 'Surfbars', Arial, sans-serif;">Contact Us</h2>

    <!-- Contact form for users to send messages -->
    <form id="contact-form" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label"><b>Name:</b></label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label"><b>Email:</b></label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label"><b>Message:</b></label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
        </div>

        <!-- Submit button for sending the message -->
        <button type="submit" class="btn btn-primary search-button" style="padding: 12px 24px;">Send Message</button>
    </form>
</main>

<!-- Modal for Notification -->
<!-- Modal Structure -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Under Construction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                This feature is currently under construction. Thank you for your understanding. Come back later!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary search-button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Include the footer for the webpage-->
<?php include("../shared/footer.php"); ?>

<script src="../resources/JS/aboutScripts.js"></script>
