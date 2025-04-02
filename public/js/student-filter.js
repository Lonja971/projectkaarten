// Student filter functionality
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const roleFilters = document.querySelectorAll('input[name="role-filter"]');
    const studentSearch = document.getElementById('student-search');
    const resetFiltersButton = document.getElementById('reset-student-filters');
    const studentCards = document.querySelectorAll('.student-card');
    
    // Function to apply filters
    function applyFilters() {
        const selectedRole = document.querySelector('input[name="role-filter"]:checked').value;
        const searchText = studentSearch.value.toLowerCase();
        
        studentCards.forEach(card => {
            const studentName = card.querySelector('h3').textContent.toLowerCase();
            const studentRole = card.dataset.role;
            
            // Check if student meets filter criteria
            const matchesRole = selectedRole === 'all' || studentRole === selectedRole;
            const matchesSearch = searchText === '' || studentName.includes(searchText);
            
            // Show/hide based on filter matches
            if (matchesRole && matchesSearch) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }
    
    // Add event listeners for filter changes
    roleFilters.forEach(filter => {
        filter.addEventListener('change', function() {
            // Update label styling
            document.querySelectorAll('label[for^="role-"]').forEach(label => {
                label.classList.remove('checked');
            });
            document.querySelector(`label[for="${this.id}"]`).classList.add('checked');
            
            // Apply filters
            applyFilters();
        });
    });
    
    // Add event listener for search input
    if (studentSearch) {
        studentSearch.addEventListener('input', applyFilters);
    }
    
    // Add event listener for reset button
    if (resetFiltersButton) {
        resetFiltersButton.addEventListener('click', function() {
            // Reset role filter to "All"
            const allRolesRadio = document.getElementById('all-roles');
            if (allRolesRadio) {
                allRolesRadio.checked = true;
                
                // Update label styling
                document.querySelectorAll('label[for^="role-"]').forEach(label => {
                    label.classList.remove('checked');
                });
                document.querySelector('label[for="all-roles"]').classList.add('checked');
            }
            
            // Clear search input
            if (studentSearch) {
                studentSearch.value = '';
            }
            
            // Reapply filters (which will show all students)
            applyFilters();
        });
    }
});
