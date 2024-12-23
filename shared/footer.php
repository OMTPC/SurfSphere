<!-- 
 Title: Search Page
 Created by: Orlando Caetano
 Date: 15/10/2024 
 Description: This footer was taken from the homepage.html file of the SurfSphere website and is reused here to maintain consistent design across all pages. 
              It is a Bootstrap-based footer that remains fixed at the bottom of the page and displays dynamic copyright information, updating automatically based on the current year.
 Resources: All the resources used are listed in <a href="../References.pdf" target="_blank">References</a>.see About page
-->

    <!-- Footer section begins -->
        <footer class="bg-light text-center text-lg-start mt-auto">
                <div class="text-center p-3">
                    &copy; <?php echo date('Y'); ?>: SurfSphere
                </div>
        </footer>
    
    <!-- Bootstrap JS bundle is included for handling interactive components like modals or dropdowns -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    </body>
</html>
        