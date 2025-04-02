function resetFormToDefaults(event) {
    // Get the form element
    const form = event.target.closest('form');
    
    // Reset all form elements to their default values
    form.reset();
    
    // Find all checkboxes with 'checked' attribute in HTML and ensure they're checked
    form.querySelectorAll('input[type="checkbox"][checked]').forEach(checkbox => {
        checkbox.checked = true;
    });
    
    // Re-apply any 'checked' class to labels
    form.querySelectorAll('label').forEach(label => {
        const input = document.getElementById(label.getAttribute('for'));
        if (input && input.checked) {
            label.classList.add('checked');
        } else {
            label.classList.remove('checked');
        }
    });

    // Prevent the default reset behavior as we've handled it manually
    event.preventDefault();
}
