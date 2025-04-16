@props(['user' => null])

<section class="border-b-[0.5px] border-[#ddd] pl-[20px] pr-[20px] pt-[10px] pb-[10px] flex gap-[20px] justify-between" id="help-navigation-buttons">
   <div class="flex gap-[20px]">
      <button 
         id="student-help-button"
         class="help-nav-toggle-button text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px] active-nav-button"
         data-tab-id="student-help"
         data-default="true"
      >
         <i class="fa-solid fa-graduation-cap pr-[6px]"></i> Voor Student
      </button>
      
      <button 
         id="docent-help-button"
         class="help-nav-toggle-button text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px]"
         data-tab-id="docent-help"
         data-default="false"
      >
         <i class="fa-solid fa-chalkboard-user pr-[6px]"></i> Voor Docent
      </button>
      
      <button 
         id="api-help-button"
         class="help-nav-toggle-button text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px]"
         data-tab-id="api-help"
         data-default="false"
      >
         <i class="fa-solid fa-code pr-[6px]"></i> API
      </button>
   </div>
</section>

<script>
   document.addEventListener('DOMContentLoaded', function() {
      // Get all help navigation buttons
      var buttons = document.querySelectorAll('.help-nav-toggle-button');
      
      // Add click event listeners to each button
      buttons.forEach(function(button) {
         button.addEventListener('click', function() {
            // Remove active class from all buttons
            buttons.forEach(function(btn) {
               btn.classList.remove('active-nav-button');
            });
            
            // Add active class to clicked button
            this.classList.add('active-nav-button');
            
            // Hide all tab contents
            document.querySelectorAll('.help-tab-content').forEach(function(content) {
               content.classList.add('hidden');
            });
            
            // Show clicked tab content
            var tabId = this.getAttribute('data-tab-id');
            document.getElementById(tabId + '-content').classList.remove('hidden');
         });
      });
   });
</script>
