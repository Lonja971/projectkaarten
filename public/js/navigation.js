// Navigation buttons functionality
document.addEventListener('DOMContentLoaded', function() {
    // Get all navigation toggle buttons
    const navToggleButtons = document.querySelectorAll('.nav-toggle-button');
    
    // Simple function to log all available elements for debugging
    function logTabElements() {
        console.log('Navigation buttons:', navToggleButtons.length);
        navToggleButtons.forEach(btn => {
            console.log(`Button: ${btn.id}, Tab ID: ${btn.dataset.tabId}, Default: ${btn.dataset.default}`);
        });
        
        // Log content sections
        document.querySelectorAll('[id$="-content"]').forEach(content => {
            console.log(`Content section: ${content.id}, Hidden: ${content.classList.contains('hidden')}`);
        });
        
        // Log filter sections
        document.querySelectorAll('[id$="-filters"]').forEach(filter => {
            console.log(`Filter section: ${filter.id}, Hidden: ${filter.classList.contains('hidden')}`);
        });
    }
    
    // Call debug function
    logTabElements();
    
    // Get all content sections and filter sections mapped by tab ID
    const contentSections = {};
    const filterSections = {};
    
    // Initialize collections of content and filter sections
    navToggleButtons.forEach(button => {
        const tabId = button.dataset.tabId;
        if (tabId) {
            contentSections[tabId] = document.getElementById(`${tabId}-content`);
            filterSections[tabId] = document.querySelector(`#sidebar #${tabId}-filters`);
            console.log(`Mapped button ${button.id} to content ${contentSections[tabId]?.id} and filter ${filterSections[tabId]?.id}`);
        }
    });
    
    // Add Project button functionality
    const addProjectButton = document.getElementById('add-project-button');
    if (addProjectButton) {
        addProjectButton.addEventListener('click', function() {
            // Create custom modal popup
            showProjectModal();
        });
    }
    
    // Function to show a custom modal with project creation form
    function showProjectModal() {
        // Fetch icons and backgrounds first
        Promise.all([
            axios.get('api/icons'),
            axios.get('api/backgrounds')
        ])
        .then(([iconsResponse, backgroundsResponse]) => {
            const icons = iconsResponse.data.data || [];
            const backgrounds = backgroundsResponse.data.data || [];
            createProjectModal(icons, backgrounds);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            alert('Er is een fout opgetreden bij het laden van de projectgegevens');
        });
    }
    
    // Create the project modal with the fetched data
    function createProjectModal(icons, backgrounds) {
        // Create modal overlay (background)
        const overlay = document.createElement('div');
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        overlay.style.display = 'flex';
        overlay.style.justifyContent = 'center';
        overlay.style.alignItems = 'center';
        overlay.style.zIndex = '1000';
        
        // Create modal content
        const modal = document.createElement('div');
        modal.classList.add('font-[Inter]');
        modal.style.backgroundColor = 'white';
        modal.style.borderRadius = '20px';
        modal.style.padding = '20px';
        modal.style.minWidth = '500px';
        modal.style.maxWidth = 'fit-content';
        modal.style.display = 'flex';
        modal.style.flexDirection = 'column';
        modal.style.gap = '20px';
        modal.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
        
        // Create modal header
        const header = document.createElement('div');
        header.textContent = 'Nieuw Project';
        header.classList.add('text-[24px]', 'text-[#000]', 'font-bold');
        header.style.textAlign = 'center';
        
        // Create form container
        const form = document.createElement('form');
        form.style.display = 'flex';
        form.style.flexDirection = 'column';
        form.style.gap = '15px';
        
        // Title input
        const titleGroup = document.createElement('div');
        titleGroup.style.display = 'flex';
        titleGroup.style.flexDirection = 'column';
        titleGroup.style.gap = '8px';
        
        const titleLabel = document.createElement('label');
        titleLabel.textContent = 'Titel';
        titleLabel.classList.add('text-[20px]', 'text-[#000]', 'font-[Inter]');
        titleLabel.setAttribute('for', 'project-title');
        
        const titleInput = document.createElement('input');
        titleInput.setAttribute('type', 'text');
        titleInput.setAttribute('id', 'project-title');
        titleInput.setAttribute('name', 'title');
        titleInput.setAttribute('required', 'true');
        titleInput.classList.add('font-[Inter]', 'text-[16px]', 'border-[0.5px]', 'border-[#ccc]', 'rounded-[100px]');
        titleInput.style.padding = '4px 10px';
        
        titleGroup.appendChild(titleLabel);
        titleGroup.appendChild(titleInput);
        
        // Deadline date input
        const dateGroup = document.createElement('div');
        dateGroup.style.display = 'flex';
        dateGroup.style.flexDirection = 'column';
        dateGroup.style.gap = '8px';
        
        const dateLabel = document.createElement('label');
        dateLabel.textContent = 'Einddatum';
        dateLabel.classList.add('text-[20px]', 'text-[#000]', 'font-[Inter]');
        dateLabel.setAttribute('for', 'project-deadline');
        
        const dateInput = document.createElement('input');
        dateInput.setAttribute('type', 'date');
        dateInput.setAttribute('id', 'project-deadline');
        dateInput.setAttribute('name', 'date_end');
        dateInput.setAttribute('required', 'true');
        dateInput.classList.add('font-[Inter]', 'text-[16px]', 'border-[0.5px]', 'border-[#ccc]', 'rounded-[100px]');
        dateInput.style.padding = '4px 10px';
        
        // Set default value to today + 1 month
        const defaultDate = new Date();
        defaultDate.setMonth(defaultDate.getMonth() + 1);
        dateInput.valueAsDate = defaultDate;
        
        dateGroup.appendChild(dateLabel);
        dateGroup.appendChild(dateInput);
        
        // Icon selector
        const iconGroup = document.createElement('div');
        iconGroup.style.display = 'flex';
        iconGroup.style.flexDirection = 'column';
        iconGroup.style.gap = '8px';
        
        const iconLabel = document.createElement('label');
        iconLabel.textContent = 'Icoon';
        iconLabel.classList.add('text-[20px]', 'text-[#000]', 'font-[Inter]');
        iconLabel.setAttribute('for', 'project-icon');
        
        const iconContainer = document.createElement('div');
        iconContainer.style.display = 'grid';
        iconContainer.style.gridTemplateColumns = 'repeat(24, 1fr)';
        iconContainer.style.gap = '8px';
        iconContainer.style.justifyItems = 'center';
        iconContainer.style.padding = '0';
        
        // We are using icons data from the API now
        // Show all available icons
        const iconOptions = icons;
        
        // Hidden input to store the selected icon
        const iconInput = document.createElement('input');
        iconInput.setAttribute('type', 'hidden');
        iconInput.setAttribute('id', 'project-icon');
        iconInput.setAttribute('name', 'icon_id');
        iconInput.setAttribute('required', 'true');
        
        // Create icon buttons
        iconOptions.forEach(icon => {
            const iconButton = document.createElement('button');
            iconButton.setAttribute('type', 'button');
            iconButton.classList.add('icon-option');
            iconButton.style.width = '36px';
            iconButton.style.height = '36px';
            iconButton.style.display = 'flex';
            iconButton.style.justifyContent = 'center';
            iconButton.style.alignItems = 'center';
            iconButton.style.borderRadius = '5px';
            iconButton.style.border = '1px solid #eee';
            iconButton.style.cursor = 'pointer';
            iconButton.style.transition = 'all 0.2s';
            
            const iconElement = document.createElement('i');
            iconElement.className = icon.icon; // Use the icon class from API
            
            iconButton.appendChild(iconElement);
            
            iconButton.addEventListener('click', function() {
                // Remove selected class from all buttons
                document.querySelectorAll('.icon-option').forEach(btn => {
                    btn.style.backgroundColor = '#fff';
                    btn.style.color = '#000';
                    btn.style.border = '1px solid #eee';
                });
                
                // Add selected class to clicked button
                this.style.backgroundColor = '#ef7e05';
                this.style.color = '#fff';
                this.style.border = '1px solid #ef7e05';
                
                // Set the value of the hidden input to the actual database ID
                iconInput.value = String(icon.id); // Use the actual ID from the API
            });
            
            iconContainer.appendChild(iconButton);
        });
        
        iconGroup.appendChild(iconLabel);
        iconGroup.appendChild(iconContainer);
        iconGroup.appendChild(iconInput);
        
        // Background color selector
        const bgGroup = document.createElement('div');
        bgGroup.style.display = 'flex';
        bgGroup.style.flexDirection = 'column';
        bgGroup.style.gap = '8px';
        
        const bgLabel = document.createElement('label');
        bgLabel.textContent = 'Kleur';
        bgLabel.classList.add('text-[20px]', 'text-[#000]', 'font-[Inter]');
        bgLabel.setAttribute('for', 'project-background');
        
        const bgContainer = document.createElement('div');
        bgContainer.style.display = 'grid';
        bgContainer.style.gridTemplateColumns = 'repeat(24, 1fr)';
        bgContainer.style.gap = '8px';
        bgContainer.style.justifyItems = 'center';
        bgContainer.style.padding = '0';
        
        // We are using backgrounds data from the API now
        // Show all available colors
        const bgColors = backgrounds;
        
        // Hidden input to store the selected background color
        const bgInput = document.createElement('input');
        bgInput.setAttribute('type', 'hidden');
        bgInput.setAttribute('id', 'project-background');
        bgInput.setAttribute('name', 'background_id');
        bgInput.setAttribute('required', 'true');
        
        // Create background color options
        bgColors.forEach(background => {
            const colorButton = document.createElement('button');
            colorButton.setAttribute('type', 'button');
            colorButton.classList.add('color-option');
            colorButton.style.width = '36px';
            colorButton.style.height = '36px';
            colorButton.style.borderRadius = '5px';
            colorButton.style.backgroundColor = background.background_color; // Use color from API
            colorButton.style.border = '1px solid #ddd';
            colorButton.style.cursor = 'pointer';
            colorButton.style.transition = 'all 0.2s';
            
            colorButton.addEventListener('click', function() {
                // Remove selected class from all buttons
                document.querySelectorAll('.color-option').forEach(btn => {
                    btn.style.transform = 'scale(1)';
                });
                
                // Add selected class to clicked button
                this.style.transform = 'scale(1.3)';
                
                // Set the value of the hidden input to the actual database ID
                bgInput.value = String(background.id); // Use the actual ID from the API
            });
            
            bgContainer.appendChild(colorButton);
        });
        
        bgGroup.appendChild(bgLabel);
        bgGroup.appendChild(bgContainer);
        bgGroup.appendChild(bgInput);
        
        // Submit button
        const submitButton = document.createElement('button');
        submitButton.setAttribute('type', 'button');
        submitButton.textContent = 'Aanmaken';
        submitButton.classList.add('cursor-pointer', 'text-[#fff]', 'bg-[#292c64]', 'font-bold', 'font-[Inter]', 'text-[16px]', 'rounded-[100px]');
        submitButton.style.padding = '4px 10px';
        submitButton.style.marginTop = '10px';
        
        submitButton.addEventListener('click', function() {
            // Form validation
            if (!titleInput.value) {
                alert('Vul een project titel in');
                return;
            }
            if (!dateInput.value) {
                alert('Selecteer een einddatum');
                return;
            }
            if (!iconInput.value) {
                alert('Selecteer een icoon voor uw project');
                return;
            }
            if (!bgInput.value) {
                alert('Selecteer een achtergrondkleur voor uw project');
                return;
            }

            axios.post('api/projects', {
                title: titleInput.value,
                date_end: dateInput.value,
                icon_id: parseInt(iconInput.value, 10),  // Convert to integer
                background_id: parseInt(bgInput.value, 10),  // Convert to integer
                api_key: "J7IzjpCTyiwQfF7XDJHYr0In7Z3er4BX",
            })
              .then(response => {
                receivedData = response.data;
                window.location.replace(`${userIdentifier}/${receivedData.data.project_by_student}`);
              })
              .catch(error => {
                console.error('API Error:', error.response?.data || error.message);
              });
            
            // For now, just show confirmation and close modal
        });
        
        // Cancel button
        const cancelButton = document.createElement('button');
        cancelButton.setAttribute('type', 'button');
        cancelButton.textContent = 'Annuleren';
        cancelButton.classList.add('border-[0.5px]', 'border-[#ccc]', 'font-[Inter]', 'text-[16px]', 'rounded-[100px]', 'cursor-pointer');
        cancelButton.style.padding = '4px 10px';
        cancelButton.style.marginTop = '10px';
        
        cancelButton.addEventListener('click', function() {
            document.body.removeChild(overlay);
        });
        
        // Button container
        const buttonContainer = document.createElement('div');
        buttonContainer.style.display = 'flex';
        buttonContainer.style.flexDirection = 'column';
        buttonContainer.style.gap = '0';
        
        buttonContainer.appendChild(submitButton);
        buttonContainer.appendChild(cancelButton);
        
        // Add all form elements
        form.appendChild(titleGroup);
        form.appendChild(dateGroup);
        form.appendChild(iconGroup);
        form.appendChild(bgGroup);
        form.appendChild(buttonContainer);
        
        // Append elements to modal
        modal.appendChild(header);
        modal.appendChild(form);
        
        // Append modal to overlay
        overlay.appendChild(modal);
        
        // Append overlay to body
        document.body.appendChild(overlay);
        
        // Select first icon and background color by default
        document.querySelector('.icon-option').click();
        document.querySelector('.color-option').click();
    }
    
    // Function to toggle between different content views
    function toggleView(tabId) {
        console.log(`Toggling view to tab: ${tabId}`);
        
        // Hide all content sections
        const allContentSections = document.querySelectorAll('[id$="-content"]');
        allContentSections.forEach(section => {
            section.classList.add('hidden');
            console.log(`Hiding content section: ${section.id}`);
        });
        
        // Hide all filter sections
        const allFilterSections = document.querySelectorAll('[id$="-filters"]');
        allFilterSections.forEach(section => {
            section.classList.add('hidden');
            console.log(`Hiding filter section: ${section.id}`);
        });
        
        // Show the selected content section
        const selectedContent = document.getElementById(`${tabId}-content`);
        if (selectedContent) {
            selectedContent.classList.remove('hidden');
            console.log(`Showing content section: ${selectedContent.id}`);
        } else {
            console.error(`Content section not found for tab: ${tabId}`);
        }
        
        // Show the selected filter section
        const selectedFilter = document.getElementById(`${tabId}-filters`);
        if (selectedFilter) {
            selectedFilter.classList.remove('hidden');
            console.log(`Showing filter section: ${selectedFilter.id}`);
        } else {
            console.error(`Filter section not found for tab: ${tabId}`);
        }
        
        // Update URL parameter
        const url = new URL(window.location);
        url.searchParams.set('view', tabId);
        window.history.pushState({}, '', url);
        console.log(`Updated URL to: ${url.toString()}`);
    }
    
    // Add click event listener to each nav toggle button
    navToggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            navToggleButtons.forEach(btn => {
                btn.classList.remove('active-nav-button');
            });
            
            // Add active class to clicked button
            this.classList.add('active-nav-button');
            
            // Get the tab ID from the data attribute
            const tabId = this.dataset.tabId;
            if (tabId) {
                toggleView(tabId);
            }
        });
    });
    
    // Initialize the view based on URL params
    setTimeout(() => {
        console.log('Initializing tab view based on URL or defaults');
        
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('view')) {
            const viewParam = urlParams.get('view');
            console.log(`URL has view parameter: ${viewParam}`);
            
            const targetButton = document.querySelector(`.nav-toggle-button[data-tab-id="${viewParam}"]`);
            console.log('Target button found:', targetButton);
            
            if (targetButton) {
                // Simulate click on the button
                console.log(`Clicking target button for tab: ${viewParam}`);
                targetButton.click();
            } else {
                // If no button found for the view param, use the first default button
                console.log(`No button found for tab: ${viewParam}, falling back to default`);
                const defaultButton = document.querySelector('.nav-toggle-button[data-default="true"]');
                if (defaultButton) {
                    console.log('Clicking default button');
                    defaultButton.click();
                } else {
                    console.log('No default button found');
                }
            }
        } else {
            // If no view param, use the default button
            console.log('No view parameter in URL, using default button');
            const defaultButton = document.querySelector('.nav-toggle-button[data-default="true"]');
            if (defaultButton) {
                console.log(`Clicking default button: ${defaultButton.dataset.tabId}`);
                defaultButton.click();
            } else if (navToggleButtons.length > 0) {
                // Fallback to first button if no default is set
                console.log('No default button, using first available button');
                navToggleButtons[0].click();
            } else {
                console.log('No buttons found at all');
            }
        }
    }, 100); // Short delay to ensure DOM is fully processed
});
