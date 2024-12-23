<!-- 
 Title: surfsfhere homepage (index.php)
 Created by: Orlando Caetano
 Date: 04/10/2024 
 Discription: This is the main homepage for the SurfSphere social media platform project
 Resourses: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

<?php
// Start the session to access session variables
  session_start ();

  // Include the database connection and function files for functionality
  include("../shared/db_connection.php");
  include("../shared/functions.php");

  // Set the page-specific title
  $pageTitle = "SurfSphere";  

?>

<!-- Include the header for the webpage -->
  <?php  include("../shared/header.php"); ?>

  <!-- Main section for the index page  -->
  <main class="flex-fill">
    <!-- Hero Section or first part of the main section-->
    
    <h1 class="text-center text-md-left">Welcome to Your Surf World</h1>
    
    <section class="hero">
      <div class="row">
        <div class="col-12 col-md-8"> <!-- Column for the carousel display -->
          
          <div class="carousel-container">
            <div id="carousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-indicators"> 
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="3"></button>
              </div>

              <!-- The slideshow/carousel containing images-->
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="../resources/images/jeremy-bishop-pikyGuAmwpM-unsplash.jpg" alt="surfers_0" class="d-block" style="width:100%">
                </div>
                <div class="carousel-item">
                  <img src="../resources/images/frank-mckenna-R7YtoUH3x8Y-unsplash.jpg" alt="surfers_1" class="d-block" style="width:100%">
                </div>
                <div class="carousel-item">
                  <img src="../resources/images/tim-marshall-Dg3TICnB_uc-unsplash.jpg" alt="surfers_2" class="d-block" style="width:100%">
                </div>
                <div class="carousel-item">
                  <img src="../resources/images/mohamed-nohassi-vOdYauqVTVw-unsplash.jpg" alt="surfers_3" class="d-block" style="width:100%">
                </div>
              </div>

              <!-- Left and right controls/icons -->
              <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>
            </div>
          </div>
        </div>
        <div class="col 12 col-md-4">  <!-- Column for promotional content and sign-up button -->
          <p>Catch the wave, <b>Join Now!</b> </p>
          <p><b>A place where you can share your gnarly barrels and tall waves. Everyone, surfs on! 🤙</b></p>
          <button class="btn btn-primary signup-button" onclick="window.location.href='register.php '">Sign Up</button>
        </div>
      </div>
    </section>

      <!-- Features Section or second part of the main section -->
    <section class="features">
      <div class="feature-container">
        <div class="feature">
          <h3>Create Posts</h3>
          <p><b>Share your experiences with the world!</b></p>
        </div>
        <div class="feature">
          <h3>Connect</h3>
          <p><b>Meet fellow surfers, organize events, and ride the waves together!</b></p>
        </div>
        <div class="feature">
          <h3>Like & Comment</h3>
          <p><b>Engage with posts from other surfers in the community.</b></p>
        </div>
      </div>
    </section>

  </main>

  <!-- Include the footer for the webpage-->
  <?php include("../shared/footer.php");?>