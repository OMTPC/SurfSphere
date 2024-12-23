//Title: javascript for the dashboard page
//Created by: Orlando Caetano
//Date: 17/10/2024 
//Discription: This JavaScript file contains functionalities that enhance user interactions on the SurfSphere social media website, specifically 
//             for dashboard pages.
//             It enables dynamic content manipulation, improving the user experience by allowing users to edit and manage comments on posts.
//Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>. see About page


// Dashboard.php page functionality 
// JavaScript to toggle between Comment button and the form 
document.querySelectorAll('.comment-btn').forEach(function(commentBtn) {
    commentBtn.addEventListener('click', function() {
        const postCard = commentBtn.closest('.post-card');
        const commentSection = postCard.querySelector('.comment-section');
        commentSection.style.display = 'block';
    });
});

document.querySelectorAll('.cancel-comment-btn').forEach(function(cancelBtn) {
    cancelBtn.addEventListener('click', function() {
        const postCard = cancelBtn.closest('.post-card');
        const commentSection = postCard.querySelector('.comment-section');
        commentSection.style.display = 'none';
    });
});