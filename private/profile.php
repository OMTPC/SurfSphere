<!-- 
 Title: Profile page
 Created by: Orlando Caetano
 Date: 06/10/2024 
 Updated: 18/10/2024
 Discription: This page allows users to view and edit their profile information, including their username, profile picture, and bio. 
              Users can also view their uploaded posts and interact with their profile. The profile page supports both personal 
              and public views, enabling users to view their own profiles when logged in or others' profiles when accessed through 
              a search link. Features include an upload form for changing the profile picture, a bio editing section, and a gallery 
              of user posts. Access to the profile page is restricted to logged-in users to ensure privacy and security.
 Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>. see About page
-->
<?php
    // Start the session to access session variables
    session_start();

    // Include the database connection and function files for functionality
    include("../shared/db_connection.php");
    include("../shared/functions.php");

    // Check if a user profile is being viewed from search or logged in
    if (isset($_GET['membersID'])) {
        // If accessing a profile from a search or link
        $viewedUserID = $_GET['membersID'];
        $isOwner = false;  
    } else if (isset($_SESSION['membersID'])) {
        // If the user is logged in and viewing their own profile
        $viewedUserID = $_SESSION['membersID'];
        $isOwner = true;  
    } else {
        // If not logged in or no profile to view, redirect to login
        redirectTo("../public/login.php");
        die;
    }

    // Fetch user data based on the viewed profile
    $query = "SELECT userName, profilePicture, bio FROM members WHERE membersID = ? LIMIT 1";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $viewedUserID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
    } else {
        // In case the user data is not found, redirect to login page
        redirectTo("../public/login.php");
        die;
    }

    // Fetch the user's posts from the database
    $postsQuery = "SELECT postID, imagePath, postText, created_at FROM posts WHERE membersID = ? ORDER BY created_at DESC";
    $stmt = $con->prepare($postsQuery);
    $stmt->bind_param("i", $viewedUserID);
    $stmt->execute();
    $postsResult = $stmt->get_result();

    // Fetch the user's profile picture from the database
    $profilePicture = !empty($user_data['profilePicture']) ? $user_data['profilePicture'] : 'logo.png';
    $uploadsFolder = '../uploads/';
    $profilePicturePath = $profilePicture;

    if ($profilePicture == 'logo.png') {
        $profilePicturePath = '../resources/images/logo.png'; 
    } else {
        $profilePicturePath = $uploadsFolder . $profilePicture;
    }

    // Check if the user came from the admin page
    $fromAdmin = isset($_GET['from']) && $_GET['from'] === 'admin';
?>

<!DOCTYPE html> 
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../resources/CSS/styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>

    <body class="d-flex flex-column min-vh-100" style="background-image: url('../resources/images/sebastian-leon-prado-mIVVo-wVNxQ-unsplash.jpg'); background-size: cover; background-position: center;">
        <header>
            <!-- Navigation Bar -->
            <nav class="navbar navbar-expand-sm bg-light">
                <div class="container-fluid">
                  <!-- Logo -->
                  <a class="navbar-brand" href="#">
                    <img src="../resources/images/logo.png" alt="SurfShere Logo" class="logo-image">
                  </a>
                  <h1><span>S</span>urf<span>S</span>phere - <?php echo $user_data['userName']; ?></h1>
                  
                  <!-- Search bar -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                <!-- Collapsible Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <!-- <li class="nav-item">
                                 <a class="nav-link font-weight-bold" style="font-size: 28px;" href="../public/index.php">Home</a> 
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="../private/dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../public/logout.php">Logout</a>
                            </li>
                        <li class="nav-item">
                            <form class="form-inline" action="../public/search.php" method="GET">
                                <input type="text" name="query" placeholder="Search..." class="form-control search-bar" style="width: 200px;">
                                <button class="btn btn-primary search-button">Search</button>
                            </form>
                        </li>
                    </ul>
                  </div>
                </div>
            </nav>
        </header>
        
        <!-- Main section for the profile page  -->   
        <main class="container flex-fill mt-5">
        <?php if ($fromAdmin): // Show button only if coming from admin ?>
            <a href="../private/admin.php" class="btn btn-secondary register-button" style="margin-bottom: 20px;">
            <i class="fas fa-arrow-left"></i> Return to Admin Page
                </a>
            <?php endif; ?>
          <section class="welcome-section">
            <h1>Welcome to your Profile!</h1>
            <h3>Hello, <?php echo $user_data['userName']; ?>! We've been expecting you.</h3>
            
            <!-- Display profile picture -->
            <div class="profile-picture">
                <img src="<?php echo $profilePicturePath; ?>" alt="Profile Picture" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
            </div>

            <!-- Upload Form for Profile Picture -->
            <?php if ($isOwner): ?>
                <form action="../uploads/profile_pictures.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label"><b>Upload a new profile picture:</b></label>
                        <input type="file" name="profilePicture" class="form-control" id="profilePicture" style="width: 350px">
                    </div>
                    <button type="submit" class="btn btn-primary search-button">Upload</button><br><br><br>
                </form>
            <?php endif; ?>

            <!-- Bio Section -->
            <div id="bio-section">
                <h4 style="font-family: 'Surfbars', Arial, sans-serif; font-size: 34px; color: #001862"><?php echo $user_data['userName']; ?>'s  Short Bio</h4>
                    <p id="bio-text" style="font-weight: bold; font-size: 20px;"><?php echo htmlspecialchars($user_data['bio']); ?></p>
                    <?php if ($isOwner): ?>
                        <button id="edit-bio-btn" class="btn btn-primary search-button">Edit Bio</button>
                    <?php endif; ?>
            </div>

            <!-- Bio Edit Form (hidden by default) -->
            <?php if ($isOwner): ?>
                <div id="bio-edit-form" style="display: none;">
                    <form action="../private/update_profile.php" method="POST">
                        <div class="mb-3">
                            <label for="bio" class="form-label">Edit your bio:</label>
                            <textarea name="bio" class="form-control" id="bio" rows="3" ><?php echo htmlspecialchars($user_data['bio']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Bio</button>
                        <button type="button" id="cancel-edit-btn" class="btn btn-secondary">Cancel</button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Section for uploading a post -->
            <div class="container mt-5">
              <h2 style="font-family: 'Surfbars', Arial, sans-serif; font-size: 34px; color: #001862">Upload a Post</h2>
                <?php if ($isOwner): ?>
                    <form action="../private/upload_post.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="postText" class="form-label"><b>Post Text:</b></label>
                            <textarea name="postText" class="form-control" rows="3" placeholder="Write something..." style="width: 350px"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imageUpload" class="form-label"><b>Upload an Image:</b></label>
                            <input type="file" name="imageUpload" class="form-control" style="width: 350px">
                        </div>
                        <button type="submit" class="btn btn-primary search-button">Upload Post</button>
                    </form>
                <?php else: ?>
                    <p><b>You cannot upload posts on this profile.</b></p>
                <?php endif; ?>
            </div>

            <!-- Gallery section displaying user's posts -->
            <div class="container mt-5">
                  <h2 style="font-family: 'Surfbars', Arial, sans-serif; font-size: 44px; color: #001862"><?php echo $user_data['userName']; ?>'s Gallery</h2>
                  <div class="row">
                      <?php if (mysqli_num_rows($postsResult) > 0): ?>
                          <?php while ($post = mysqli_fetch_assoc($postsResult)): ?>
                              <div class="col-md-4 mb-4">
                                  <div class="card">
                                      <!-- Display the image -->
                                      <img src="../uploads/posts/<?php echo $post['imagePath']; ?>" class="card-img-top img-fluid" alt="Post Image" style="max-height: 300px; object-fit: cover;">

                                      <div class="card-body">
                                          <!-- Display the post text -->
                                          <p class="card-text"><?php echo htmlspecialchars($post['postText']); ?></p>
                                          <small class="text-muted">Posted on <?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?></small>
                                          
                                            <!-- delete button -->
                                            <?php if ($isOwner || $_SESSION['roleName'] == 'admin'): ?>
                                                <form action="../private/delete_post.php" method="POST">
                                                    <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>">
                                                    <button type="submit" class="btn btn-danger search-button">Delete Post</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                  </div>
                              </div>
                          <?php endwhile; ?>
                      <?php else: ?>
                          <p><b>No posts yet. Start uploading your images and posts!</b></p>
                      <?php endif; ?>
                    </div>
             </div>

        </section>
        </main>

    <!-- Include the footer for the webpage-->
    <?php include("../shared/footer.php");?>

    <script src="../resources/JS/profileScripts.js"></script>

</body>
</html>
