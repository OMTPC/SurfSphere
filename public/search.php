<!-- 
 Title: register page
 Created by: Orlando Caetano
 Date: 15/10/2024 
 Discription: This PHP script allows users to search for member profiles by username. It retrieves data from the members table in the 
              database based on the user's input and displays matching results. If a match is found, the usernames are displayed as links to their respective profiles. 
              This enhances user interaction by allowing them to easily find and connect with other members of the SurfSphere social media website.
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->
<?php

// Include database connection
include ("../shared/db_connection.php");
include("../shared/header.php");

// Check if the query parameter is set
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM members WHERE userName LIKE ?");
    $searchTerm = "%" . $searchQuery . "%"; 
    $stmt->bind_param("s", $searchTerm); 
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<div class='container'>"; 

    // Check if any results were found
    if ($result->num_rows > 0) {
        echo "<h2 style=\"font-family: 'Surfbars', Arial, sans-serif;\">Search Results for <span style=\"font-family: Arial, sans-serif;\">'$searchQuery'</span></h2>";
        while ($row = $result->fetch_assoc()) {
            // Display profile links
            echo "<a style=\"color: #001862; text-decoration: underline; font-weight: bold;\" href='../private/profile.php?membersID=" . urlencode($row['membersID']) . "'>" . htmlspecialchars($row['userName']) . "</a><br>";
        }
    } else {
        echo "<p style=\"font-family: 'Surfbars', Arial, sans-serif;\">Please enter a search query.</p>";
    }

    // Close statement and connection
    $stmt->close();
    $con->close();

    echo "</div>"; // End the main container
    } else {
        echo "<p style=\"font-family: 'Surfbars', Arial, sans-serif;\>Please enter a search query.</p>";
    }

// Include footer
include("../shared/footer.php");
?>
