// Function to reset form to default values
function resetFormToDefaults(event) {
    console.log('Reset function called');
    
    // Prevent default button behavior
    event.preventDefault();
    
    // Get the form
    const form = event.target.closest('form');
    console.log('Form found:', form);
    if (!form) return;
    
    // Clear text inputs
    const textInputs = form.querySelectorAll('input[type="text"]');
    console.log('Text inputs found:', textInputs.length);
    textInputs.forEach(input => {
        input.value = '';
        console.log('Cleared input:', input.id);
    });
    
    // Find default radio and check it
    const defaultRadio = document.getElementById('sort-name-a-z');
    console.log('Default radio found:', defaultRadio);
    if (defaultRadio) {
        defaultRadio.checked = true;
        console.log('Default radio checked');
        
        // Uncheck other radios in same group
        const radios = form.querySelectorAll('input[type="radio"][name="sort"]');
        console.log('Radio buttons found:', radios.length);
        radios.forEach(radio => {
            if (radio.id !== 'sort-name-a-z') {
                radio.checked = false;
                console.log('Unchecked radio:', radio.id);
            }
        });
        
        // Remove checked class from all labels
        const labels = form.querySelectorAll('label[for^="sort-"], label[for^="amount-of-projects-"]');
        console.log('Labels found:', labels.length);
        labels.forEach(label => {
            label.classList.remove('checked');
            console.log('Removed checked class from:', label.getAttribute('for'));
        });
        
        // Add checked class to default label
        const defaultLabel = document.querySelector('label[for="sort-name-a-z"]');
        console.log('Default label found:', defaultLabel);
        if (defaultLabel) {
            defaultLabel.classList.add('checked');
            console.log('Added checked class to default label');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded');
    
    // Initialize all inputs
    const inputs = document.querySelectorAll('input[type="radio"], input[type="checkbox"]');
    console.log('Inputs found:', inputs.length);
    
    // First, make sure all checked inputs have their labels properly styled
    inputs.forEach(input => {
        // Set initial state
        updateLabelState(input);
        
        // Add event listener for changes
        input.addEventListener('change', function() {
            console.log('Input changed:', this.id);
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
    console.log('Default checked radios:', defaultRadios.length);
    defaultRadios.forEach(radio => {
        console.log('Default radio ID:', radio.id);
        const label = document.querySelector(`label[for="${radio.id}"]`);
        if (label) {
            label.classList.add('checked');
            console.log('Added checked class to label for:', radio.id);
        }
    });
    
    // Manual check for the reset button 
    const resetButton = document.getElementById('reset-student-filters');
    console.log('Reset button found:', resetButton);
    if (resetButton) {
        resetButton.addEventListener('click', function(e) {
            console.log('Reset button clicked via event listener');
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
