// Navigation buttons functionality
document.addEventListener('DOMContentLoaded', function() {
    // Get all navigation toggle buttons
    const navToggleButtons = document.querySelectorAll('.nav-toggle-button');
    
    // Content sections
    const projectsContent = document.getElementById('projects-content');
    const studentsContent = document.getElementById('students-content');
    
    // Filter elements
    const filterToggleButton = document.getElementById('filter-toggle-button');
    const filterSection = document.getElementById('filter-section');
    
    // Add click event listener to each nav toggle button
    navToggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            navToggleButtons.forEach(btn => {
                btn.classList.remove('active-nav-button');
            });
            
            // Add active class to clicked button
            this.classList.add('active-nav-button');
            
            // Reset filter button and hide filter section when switching views
            if (filterToggleButton && filterToggleButton.classList.contains('active-nav-button')) {
                filterToggleButton.classList.remove('active-nav-button');
            }
            
            if (filterSection && !filterSection.classList.contains('hidden')) {
                filterSection.classList.add('hidden');
            }
            
            // Show/hide content based on which button is clicked
            if (this.id === 'projects-button' || this.id === 'my-projects-button') {
                // Show projects content, hide students content
                projectsContent.classList.remove('hidden');
                if (studentsContent) {
                    studentsContent.classList.add('hidden');
                }
            } else if (this.id === 'students-button') {
                // Show students content, hide projects content
                if (studentsContent) {
                    studentsContent.classList.remove('hidden');
                }
                projectsContent.classList.add('hidden');
            }
        });
    });
    
    // Check if filter is active from URL params
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('view') && urlParams.get('view') === 'students') {
        const studentsButton = document.getElementById('students-button');
        if (studentsButton) {
            // Simulate click on students button
            studentsButton.click();
        }
    } else {
        // Make sure "Alle Projectkaarten" or "Mijn Projectkaarten" is active by default
        const projectsButton = document.getElementById('projects-button');
        const myProjectsButton = document.getElementById('my-projects-button');
        
        if (projectsButton) {
            projectsButton.classList.add('active-nav-button');
        } else if (myProjectsButton) {
            myProjectsButton.classList.add('active-nav-button');
        }
    }
});
