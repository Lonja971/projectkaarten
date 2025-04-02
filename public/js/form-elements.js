document.addEventListener('DOMContentLoaded', function() {
    // Initialize all inputs
    const inputs = document.querySelectorAll('input[type="radio"], input[type="checkbox"]');
    
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
