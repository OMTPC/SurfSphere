<!-- 
 Title: dashboard page
 Created by: Orlando Caetano
 Date: 17/10/2024 
 Discription: This page serves as the main dashboard for the SurfSphere social media website, displaying posts made by users. 
              Users can view images and associated captions along with the post date. It also provides action buttons for liking and commenting on posts.
 Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>. see About page
-->

<?php
// Start the session to access session variables
session_start();

// Include the database connection and function files for functionality
include("../shared/db_connection.php");
include("../shared/functions.php");

// Check if the user is logged in and retrieve their data
$user_data = CheckLogin($con);

// Fetch posts from the database using the SafeQuery function
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = SafeQuery($con, $query);

// Handle the Like submission
if (isset($_POST['like'])) {
    $postID = $_POST['postID'];
    $membersID = $user_data['membersID']; 

    // Insert a like into the database
    $likeQuery = "INSERT INTO likes (postID, membersID) VALUES (?, ?)";
    SafeQuery($con, $likeQuery, [$postID, $membersID]);
}

// Fetch posts from the database 
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = SafeQuery($con, $query);

// Fetch liked post IDs for the current user
$likedPostsQuery = "SELECT postID FROM likes WHERE membersID = ?";
$likedPostsResult = SafeQuery($con, $likedPostsQuery, [$user_data['membersID']]);
$likedPosts = [];
while ($row = mysqli_fetch_assoc($likedPostsResult)) {
    $likedPosts[] = $row['postID']; 
}

// Comment submission
if (isset($_POST['comment'])) {
    $postID = $_POST['postID'];
    $membersID = $user_data['membersID']; 
    $commentText = $_POST['commentText'];

    // Insert a comment into the database
    $commentQuery = "INSERT INTO comments (postID, membersID, commentText) VALUES (?, ?, ?)";
    SafeQuery($con, $commentQuery, [$postID, $membersID, $commentText]);
}

// Fetch posts from the database 
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = SafeQuery($con, $query);

// Fetch comments for each post, joining with the members table to get usernames
$commentsQuery = "SELECT c.commentText, m.userName FROM comments c JOIN members m ON c.membersID = m.membersID WHERE c.postID = ?";

// Fetch posts from the database 
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = SafeQuery($con, $query);
?>

<!DOCTYPE html> 
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../resources/CSS/styles.css">
</head>

<body class="d-flex flex-column min-vh-100" style="background-image: url('../resources/images/paje-victoria-FXB79QuRX3M-unsplash.jpg'); background-size: cover; background-position: center;">

    <header>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-sm bg-light">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand" href="#">
                    <img src="../resources/images/logo.png" alt="SurfShere Logo" class="logo-image">
                </a>
                <h1><span>S</span>urf<span>S</span>phere - <?php echo $user_data['userName']; ?></h1>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Collapsible Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                            <a class="nav-link" href="../private/profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../public/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

<!-- Main section for the dashboard page  -->    
        <main class="container mt-5">
            <h1>Dashboard</h1>
            <div class="post-grid">
                <!-- Loop through each post -->
                <?php while ($post = mysqli_fetch_assoc($result)) : ?>
                    <div class="post-card" style="font-weight: bold;">
                        <img src="../uploads/posts/<?php echo $post['imagePath']; ?>" alt="Post Image">
                        <?php if (!empty($post['postText'])) : ?>
                            <p class="caption"><?php echo htmlspecialchars($post['postText']); ?></p>
                        <?php endif; ?>
                        <p class="small text-muted" style="font-weight: bold;" color: #001862>Posted on: <?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?></p>
                    
                        <div class="post-actions d-flex">
                            <!-- Like Form -->
                            <form action="like_sub.php" method="POST" class="me-2">
                                <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>">
                                <button class="btn btn-primary search-button" <?php echo in_array($post['postID'], $likedPosts) ? 'disabled' : ''; ?>>Like</button><br><br>
                            </form>
                            

                        <div class="post-actions">
                            <button class="btn btn-primary search-button comment-btn">Comment</button>
                        </div>

                        <!-- Hidden comment form (initially hidden) -->
                        <div class="comment-section" style="display: none;">
                            <form action="../private/comment_sub.php" method="POST" class="comment-form">
                                <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>">
                                <textarea name="commentText" class="form-control" placeholder="Write a comment..." required></textarea>
                                <button type="submit" class="btn btn-success mt-2 search-button">Submit Comment</button>
                                <button type="button" class="btn btn-secondary mt-2 cancel-comment-btn search-button">Cancel</button>
                            </form>
                        </div>
                    </div>

                    <!-- Display comments for the post -->
                    <div class="comments-section mt-3">
                        <?php
                        // Get comments for the current post
                        $commentResult = SafeQuery($con, $commentsQuery, [$post['postID']]);
                        while ($comment = mysqli_fetch_assoc($commentResult)) : ?>
                            <div class="comment">
                            <p><strong><?php echo htmlspecialchars($comment['userName']); ?>:</strong> <?php echo htmlspecialchars($comment['commentText']); ?></p>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
        </main>

        <!-- Include the footer for the webpage-->
        <?php include("../shared/footer.php");?>

        <script src="../resources/JS/dashboardScripts.js"></script>
        
    </body>
</html>
