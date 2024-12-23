<!-- 
 Title: functions
 Created by: Orlando Caetano
 Date: 16/10/2024 
 Discription: This PHP script handles user management functionalities for the SurfSphere social media website.
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

<?php

// Function to display all users from the database
function DisplayAllUsers ($con)
{
    // SQL query to select members' ID and user name from the members table
    $sql = "SELECT membersID, userName FROM members";
    $result = $con->query($sql);

    // Check if results were found
    if ($result->num_rows > 0 ) {
        echo "<br>" . "We have results!" . "<br>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<br> Members ID: " . $row["membersID"] . " - User Name: " . $row["userName"] . "<br>";
        }
    }
    else {
        echo " no results found" . "<br>";
    }
}

// Function to check if the user is logged in
function CheckLogin($con) {
    if (isset($_SESSION["membersID"])) {
        $membersID = $_SESSION["membersID"];
        $query = "SELECT * FROM members WHERE membersID = ? LIMIT 1";
        $result = SafeQuery($con, $query, [$membersID]);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    }
    // If no user is logged in, redirect
    header("Location: ../public/login.php");
    exit;
}

// Function to validate user input for username
function ValidateInput($input) {
    return preg_match("/^[a-zA-Z0-9_]{3,20}$/", $input); // Only allows letters, numbers, and underscores
}

// Function to sanitize output data
function SanitizeOutput($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Convert special characters to HTML entities
}

// Function to hash passwords securely
function HashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify entered password against hashed password
function VerifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

// Function to safely execute SQL queries with prepared statements
function SafeQuery($con, $sql, $params = []) {
    $stmt = $con->prepare($sql); 
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $con->error);
    }
    if ($params) {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i'; 
            } elseif (is_double($param)) {
                $types .= 'd'; 
            } else {
                $types .= 's'; 
            }
        }
        // Bind the parameters
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    
    // Check for execution errors
    if ($stmt->errno) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    return $stmt->get_result();
}


// Function to register a new user
function RegisterUser($con, $username, $password) {
    $hashedPassword = HashPassword($password);
    $sql = "INSERT INTO members (userName, userPassword) VALUES (?, ?)";
    SafeQuery($con, $sql, [$username, $hashedPassword]); 
}

function sanitizeInput($con, $data) {
    return mysqli_real_escape_string($con, htmlspecialchars($data));
}


// Function to update bio
function updateBio($con, $userID, $bio) {
    $query = "UPDATE members SET bio = '$bio' WHERE membersID = '$userID'";
    return mysqli_query($con, $query); 
}

// Function to redirect to a specified URL
function redirectTo($url) {
    header("Location: $url");
    exit;
}
?>

