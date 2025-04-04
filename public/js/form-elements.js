// Function to reset form to default values
function resetFormToDefaults(event) {
    // Prevent default button behavior
    event.preventDefault();
    
    // Get the form
    const form = event.target.closest('form');
    if (!form) return;
    
    // Clear text inputs
    const textInputs = form.querySelectorAll('input[type="text"]');
    textInputs.forEach(input => {
        input.value = '';
    });
    
    // Find default radio and check it
    const defaultRadio = document.getElementById('sort-name-a-z');
    if (defaultRadio) {
        defaultRadio.checked = true;
        
        // Uncheck other radios in same group
        const radios = form.querySelectorAll('input[type="radio"][name="sort"]');
        radios.forEach(radio => {
            if (radio.id !== 'sort-name-a-z') {
                radio.checked = false;
            }
        });
        
        // Remove checked class from all labels
        const labels = form.querySelectorAll('label[for^="sort-"], label[for^="amount-of-projects-"]');
        labels.forEach(label => {
            label.classList.remove('checked');
        });
        
        // Add checked class to default label
        const defaultLabel = document.querySelector('label[for="sort-name-a-z"]');
        if (defaultLabel) {
            defaultLabel.classList.add('checked');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all inputs
    const inputs = document.querySelectorAll('input[type="radio"], input[type="checkbox"]');
    
    // First, make sure all checked inputs have their labels properly styled
    inputs.forEach(input => {
        // Set initial state
        updateLabelState(input);
        
        // Add event listener for changes
        input.addEventListener('change', function() {
            if (this.type === 'radio') {
                // For radio buttons, remove checked class from all in the same group
                const radios = document.querySelectorAll(`input[type="radio"][name="${this.name}"]`);
                radios.forEach(radio => updateLabelState(radio));
            } else {
                // For checkboxes
                updateLabelState(this);
            }
        });
    });
    
    // Extra check to ensure the default option is visually selected
    const defaultRadios = document.querySelectorAll('input[type="radio"]:checked');
    defaultRadios.forEach(radio => {
        const label = document.querySelector(`label[for="${radio.id}"]`);
        if (label) {
            label.classList.add('checked');
        }
    });
    
    // Manual check for the reset button 
    const resetButton = document.getElementById('reset-student-filters');
    if (resetButton) {
        resetButton.addEventListener('click', function(e) {
            resetFormToDefaults(e);
        });
    }
    
    function updateLabelState(input) {
        const label = document.querySelector(`label[for="${input.id}"]`);
        if (label) {
            if (input.checked) {
                label.classList.add('checked');
            } else {
                label.classList.remove('checked');
            }
        }
    }
});
