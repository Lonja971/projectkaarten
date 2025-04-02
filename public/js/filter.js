// Filter toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterToggleButton = document.getElementById('filter-toggle-button');
    const projectsFilterSection = document.getElementById('filter-section');
    const studentsFilterSection = document.getElementById('student-filter-section');
    const projectsContent = document.getElementById('projects-content');
    const studentsContent = document.getElementById('students-content');
    
    if (filterToggleButton) {
        filterToggleButton.addEventListener('click', function() {
            // Determine which filter section to toggle based on which content is visible
            let currentFilterSection;
            
            if (!studentsContent.classList.contains('hidden')) {
                // Students view is active
                currentFilterSection = studentsFilterSection;
            } else {
                // Projects view is active (default)
                currentFilterSection = projectsFilterSection;
            }
            
            if (currentFilterSection) {
                currentFilterSection.classList.toggle('hidden');
                
                // Change the button style when active
                if (!currentFilterSection.classList.contains('hidden')) {
                    filterToggleButton.classList.add('active-nav-button');
                } else {
                    filterToggleButton.classList.remove('active-nav-button');
                }
            }
        });
    }
});
