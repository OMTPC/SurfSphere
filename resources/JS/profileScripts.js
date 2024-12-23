//Title: dashboard page
//Created by: Orlando Caetano
//Date: 17/10/2024 
//Discription: This JavaScript file contains functionalities that enhance user interactions on the SurfSphere social media website, 
//             specifically for the profile page.
//             It enables dynamic content manipulation, improving the user experience by allowing users to edit their bios.
//Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>. see About page


// Porfile.php page functionality
// JavaScript to toggle between Edit Bio button and the form
const editBioBtn = document.getElementById('edit-bio-btn');
const bioSection = document.getElementById('bio-section');
const bioEditForm = document.getElementById('bio-edit-form');
const cancelEditBtn = document.getElementById('cancel-edit-btn');

// Show bio edit form when the edit button is clicked
editBioBtn.addEventListener('click', function() {
    bioSection.style.display = 'none';
    bioEditForm.style.display = 'block';
});

// Cancel bio editing and restore original view
cancelEditBtn.addEventListener('click', function() {
    bioEditForm.style.display = 'none';
    bioSection.style.display = 'block';
});


