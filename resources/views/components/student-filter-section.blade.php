@props(['studentFilters' => ['sort' => 'name-asc', 'name' => '', 'identifier' => '']])

<section class="pl-[20px] pr-[20px] pt-[10px] pb-[10px] flex flex-col gap-[20px]">
   <form id="student-filter-form" action="#navigation-buttons" method="POST" class="flex flex-col gap-[20px]" onsubmit="localStorage.setItem('showStudentsTab', 'true');">
      @csrf
   <div class="flex flex-col gap-[8px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Sorteren op</p>
         <div class="flex gap-x-[10px] gap-y-[14px] flex-wrap">
            <div>
               <input type="radio" {{ isset($studentFilters['sort']) && $studentFilters['sort'] === 'name-asc' ? 'checked' : '' }} name="sort" id="sort-name-a-z" value="name-asc" class="hidden-input" />
               <label for="sort-name-a-z" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($studentFilters['sort']) && $studentFilters['sort'] === 'name-asc' ? 'checked' : '' }}">Volledige naam (A -> Z)</label>
            </div>
            <div>
               <input type="radio" {{ isset($studentFilters['sort']) && $studentFilters['sort'] === 'name-desc' ? 'checked' : '' }} name="sort" id="sort-name-z-a" value="name-desc" class="hidden-input" />
               <label for="sort-name-z-a" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($studentFilters['sort']) && $studentFilters['sort'] === 'name-desc' ? 'checked' : '' }}">Volledige naam (Z -> A)</label>
            </div>
            <div>
               <input type="radio" {{ isset($studentFilters['sort']) && $studentFilters['sort'] === 'projects-desc' ? 'checked' : '' }} name="sort" id="amount-of-projects-desc" value="projects-desc" class="hidden-input" />
               <label for="amount-of-projects-desc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($studentFilters['sort']) && $studentFilters['sort'] === 'projects-desc' ? 'checked' : '' }}">Aantal projecten (Aflopend)</label>
            </div>
            <div>
               <input type="radio" {{ isset($studentFilters['sort']) && $studentFilters['sort'] === 'projects-asc' ? 'checked' : '' }} name="sort" id="amount-of-projects-asc" value="projects-asc" class="hidden-input" />
               <label for="amount-of-projects-asc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($studentFilters['sort']) && $studentFilters['sort'] === 'projects-asc' ? 'checked' : '' }}">Aantal projecten (Oplopend)</label>
            </div>
         </div>
      </div>

      <div class="flex flex-col gap-[8px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Naam</p>
         <div class="flex gap-x-[10px] gap-y-[14px] flex-col mt-[-4px]">
            <input type="text" name="name" id="student-name-filter" value="{{ $studentFilters['name'] }}" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] w-fit" placeholder="Naam" />
         </div>
      </div>

      <div class="flex flex-col gap-[8px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Studentnummer</p>
         <div class="flex gap-x-[10px] gap-y-[14px] flex-col mt-[-4px]">
            <input type="text" name="identifier" id="student-identifier-filter" value="{{ $studentFilters['identifier'] }}" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] w-fit" placeholder="Studentnummer" />
         </div>
      </div>

      <div class="flex flex-col gap-[4px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Functies</p>
         <div class="flex gap-[10px] flex-wrap">
            <button type="submit" id="apply-student-filters" class="cursor-pointer text-[#fff] bg-[#292c64] font-bold font-[Inter] text-[16px] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] w-fit">Toepassen</button>
         </div>
      </div>
   </form>
</section>

<script>
   document.addEventListener('DOMContentLoaded', function() {
      // Check if no radio is selected, select the default one
      const studentForm = document.getElementById('student-filter-form');
      if (studentForm && !studentForm.querySelector('input[name="sort"]:checked')) {
         const defaultRadio = document.getElementById('sort-name-a-z');
         if (defaultRadio) {
            defaultRadio.checked = true;
            
            // Update visual styling
            const defaultLabel = document.querySelector('label[for="sort-name-a-z"]');
            if (defaultLabel) {
               // Remove checked class from all sort labels
               document.querySelectorAll('label[for^="sort-"], label[for^="amount-of-projects-"]').forEach(label => {
                  label.classList.remove('checked');
               });
               
               // Add checked class to default label
               defaultLabel.classList.add('checked');
            }
         }
      }
   });
</script>
