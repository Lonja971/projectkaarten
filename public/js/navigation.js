// Navigation buttons functionality
document.addEventListener('DOMContentLoaded', function() {
    // Get all navigation toggle buttons
    const navToggleButtons = document.querySelectorAll('.nav-toggle-button');
    
    // Content sections
    const projectsContent = document.getElementById('projects-content');
    const studentsContent = document.getElementById('students-content');
    
    // Filter sections - using querySelector to ensure we get the exact elements
    const projectsFilters = document.querySelector('#sidebar #projects-filters');
    const studentsFilters = document.querySelector('#sidebar #students-filters');
    
    console.log('Navigation loaded');
    console.log('Projects filters element:', projectsFilters);
    console.log('Students filters element:', studentsFilters);
    
    // Verify both elements exist
    if (!projectsFilters || !studentsFilters) {
        console.error('Error: One or both filter elements not found!');
        console.error('Projects filters:', projectsFilters);
        console.error('Students filters:', studentsFilters);
    }
    
    // Function to toggle between projects and students view
    function toggleView(viewType) {
        if (viewType === 'projects') {
            // Show projects content, hide students content
            if (projectsContent) projectsContent.classList.remove('hidden');
            if (studentsContent) studentsContent.classList.add('hidden');
            
            // Show project filters, hide student filters
            if (projectsFilters) {
                projectsFilters.style.display = 'block';
                projectsFilters.classList.remove('hidden');
            }
            if (studentsFilters) {
                studentsFilters.style.display = 'none';
                studentsFilters.classList.add('hidden');
            }
            
            console.log('Projects view active');
        } else if (viewType === 'students') {
            // Show students content, hide projects content
            if (studentsContent) studentsContent.classList.remove('hidden');
            if (projectsContent) projectsContent.classList.add('hidden');
            
            // Show student filters, hide project filters
            if (studentsFilters) {
                studentsFilters.style.display = 'block';
                studentsFilters.classList.remove('hidden');
            }
            if (projectsFilters) {
                projectsFilters.style.display = 'none';
                projectsFilters.classList.add('hidden');
            }
            
            console.log('Students view active');
        }
    }
    
    // Add click event listener to each nav toggle button
    navToggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Button clicked:', this.id);
            
            // Remove active class from all buttons
            navToggleButtons.forEach(btn => {
                btn.classList.remove('active-nav-button');
            });
            
            // Add active class to clicked button
            this.classList.add('active-nav-button');
            
            // Toggle the appropriate view
            if (this.id === 'projects-button' || this.id === 'my-projects-button') {
                toggleView('projects');
            } else if (this.id === 'students-button') {
                toggleView('students');
            }
        });
    });
    
    // Initialize the view based on URL params
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('view') && urlParams.get('view') === 'students') {
        const studentsButton = document.getElementById('students-button');
        if (studentsButton) {
            // Simulate click on students button
            studentsButton.click();
        } else {
            // Fallback if button not found
            toggleView('students');
        }
    } else {
        // Default to projects view
        toggleView('projects');
        
        // Activate the appropriate button
        const projectsButton = document.getElementById('projects-button');
        const myProjectsButton = document.getElementById('my-projects-button');
        
        if (projectsButton) {
            projectsButton.classList.add('active-nav-button');
        } else if (myProjectsButton) {
            myProjectsButton.classList.add('active-nav-button');
        }
    }
});
