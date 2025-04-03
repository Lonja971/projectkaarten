// Auto switch to students tab after form submission
document.addEventListener('DOMContentLoaded', function() {
    // Check if the flag is set in localStorage
    if (localStorage.getItem('showStudentsTab') === 'true') {
        // Find the students button
        const studentsButton = document.getElementById('students-button');
        
        // Click it if found
        if (studentsButton) {
            studentsButton.click();
        }
        
        // Clear the flag
        localStorage.removeItem('showStudentsTab');
    }
});
