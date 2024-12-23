//Title: javascript for the about page
//Created by: Orlando Caetano
//Date: 17/10/2024 
//Discription: This JavaScript file contains functionalities that enhance user interactions on the SurfSphere social media website's About page. 
//              It provides a dynamic user experience by displaying a modal popup when users interact with the contact form. 
//              The modal alerts users that the contact feature is currently under construction, ensuring they receive immediate 
//              feedback when they attempt to submit the form or when they start typing in the input fields.
//Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>. see About page


// Function to show the modal
function showModal() {
    var contactModal = new bootstrap.Modal(document.getElementById('contactModal'));
    contactModal.show();
}

// Add event listeners for input fields
document.getElementById('name').addEventListener('input', showModal);
document.getElementById('email').addEventListener('input', showModal);

// Handle form submission
document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault(); 
    showModal(); 
});