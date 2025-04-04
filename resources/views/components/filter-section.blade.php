@props(['statuses' => [], 'schoolyears' => [], 'projectFilters' => ['sort' => 'creation-date-asc', 'name' => ''] ])

<section class="pl-[20px] pr-[20px] pt-[10px] pb-[10px] flex flex-col gap-[20px]" style="min-height: calc(100vh - 68px);">
   <form class="flex flex-col gap-[20px]" action="#navigation-buttons" method="POST" id="filter-form" onsubmit="localStorage.setItem('studentSortDefault', 'name-asc');">
      @csrf
      <div class="flex flex-col gap-[8px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Sorteren op</p>
         <div class="flex gap-x-[10px] gap-y-[14px] flex-wrap">
            <div>
               <input type="radio" {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'creation-date-asc' ? 'checked' : '' }} name="sort" id="sort-creation-date-asc" value="creation-date-asc" class="hidden-input" />
               <label for="sort-creation-date-asc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'creation-date-asc' ? 'checked' : '' }}">Creatie Datum (Nieuw -> Oud)</label>
            </div>
            <div>
               <input type="radio" {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'creation-date-desc' ? 'checked' : '' }} name="sort" id="sort-creation-date-desc" value="creation-date-desc" class="hidden-input" />
               <label for="sort-creation-date-desc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'creation-date-desc' ? 'checked' : '' }}">Creatie Datum (Oud -> Nieuw)</label>
            </div>
            <div>
               <input type="radio" {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'update-date-asc' ? 'checked' : '' }} name="sort" id="sort-update-date-asc" value="update-date-asc" class="hidden-input" />
               <label for="sort-update-date-asc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'update-date-asc' ? 'checked' : '' }}">Laatste Update (Nieuw -> Oud)</label>
            </div>
            <div>
               <input type="radio" {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'update-date-desc' ? 'checked' : '' }} name="sort" id="sort-update-date-desc" value="update-date-desc" class="hidden-input" />
               <label for="sort-update-date-desc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'update-date-desc' ? 'checked' : '' }}">Laatste Update (Oud -> Nieuw)</label>
            </div>
            <div>
               <input type="radio" {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'end-date-asc' ? 'checked' : '' }} name="sort" id="sort-end-date-asc" value="end-date-asc" class="hidden-input" />
               <label for="sort-end-date-asc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'end-date-asc' ? 'checked' : '' }}">Einddatum (Eerstvolgend -> Laatste)</label>
            </div>
            <div>
               <input type="radio" {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'end-date-desc' ? 'checked' : '' }} name="sort" id="sort-end-date-desc" value="end-date-desc" class="hidden-input" />
               <label for="sort-end-date-desc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'end-date-desc' ? 'checked' : '' }}">Einddatum (Laatste -> Eerstvolgend)</label>
            </div>
            <div>
               <input type="radio" {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'name-asc' ? 'checked' : '' }} name="sort" id="sort-a-z" value="name-asc" class="hidden-input" />
               <label for="sort-a-z" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'name-asc' ? 'checked' : '' }}">Naam (A -> Z)</label>
            </div>
            <div>
               <input type="radio" {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'name-desc' ? 'checked' : '' }} name="sort" id="sort-z-a" value="name-desc" class="hidden-input" />
               <label for="sort-z-a" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($projectFilters['sort']) && $projectFilters['sort'] === 'name-desc' ? 'checked' : '' }}">Naam (Z -> A)</label>
            </div>
         </div>
      </div>

      <div class="flex flex-col gap-[8px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Titel</p>
         <div class="flex gap-x-[10px] gap-y-[14px] flex-col mt-[-4px]">
            <input type="text" name="name" id="project-name-filter" value="{{ $projectFilters['name'] ?? '' }}" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] w-fit" placeholder="Titel" />
         </div>
      </div>

      <div class="flex flex-col gap-[8px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Status</p>
         <div class="flex gap-x-[10px] gap-y-[14px] flex-wrap">
         @foreach($statuses ?? [] as $status)
            <div>
               <input type="checkbox" {{ isset($projectFilters['status-'.$status->id]) ? 'checked' : '' }} name="status-{{ $status->id }}" id="status-{{ $status->id }}" class="hidden-input" />
               <label for="status-{{ $status->id }}" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ isset($projectFilters['status-'.$status->id]) ? 'checked' : '' }}">{{ $status->name }}</label>
            </div>
         @endforeach
         </div>
      </div>

      <div class="flex flex-col gap-[8px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Schooljaar</p>
         <div class="flex gap-x-[10px] gap-y-[14px] flex-wrap">
         @php
            // Check if any schoolyear filters are already selected
            $anySchoolyearSelected = false;
            foreach($schoolyears ?? [] as $year) {
               if(isset($projectFilters['schoolyear-'.$year])) {
                  $anySchoolyearSelected = true;
                  break;
               }
            }
            
            // Calculate current schoolyear dynamically based on current date
            $now = \Carbon\Carbon::now();
            $currentSchoolyearStart = $now->month >= 8 ? $now->year : $now->year - 1;
            $currentSchoolyear = $currentSchoolyearStart . '-' . ($currentSchoolyearStart + 1);
         @endphp
         @foreach($schoolyears ?? [] as $schoolyear)
            <div>
               @php
                  $isCurrentSchoolyear = ($schoolyear == $currentSchoolyear);
                  // Only mark current schoolyear as checked if it's explicitly set OR
                  // if it's the current schoolyear AND no other schoolyears have been selected
                  $shouldBeChecked = isset($projectFilters['schoolyear-'.$schoolyear]) ? true : ($isCurrentSchoolyear && !$anySchoolyearSelected);
               @endphp
               <input type="checkbox" {{ $shouldBeChecked ? 'checked' : '' }} name="schoolyear-{{ $schoolyear }}" id="schoolyear-{{ $schoolyear }}" class="hidden-input" />
               <label for="schoolyear-{{ $schoolyear }}" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer {{ $shouldBeChecked ? 'checked' : '' }}">{{ $schoolyear }}</label>
            </div>
         @endforeach
         </div>
      </div>

      <div class="flex flex-col gap-[4px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Functies</p>
         <div class="flex gap-[10px] flex-wrap">
            <button type="submit" class="cursor-pointer text-[#fff] bg-[#292c64] font-bold font-[Inter] text-[16px] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] w-fit">Toepassen</button>
         </div>
      </div>
   </form>
</section>

<script>
   document.addEventListener('DOMContentLoaded', function() {
      // Check if no radio is selected, select the default one
      const projectForm = document.getElementById('filter-form');
      if (projectForm && !projectForm.querySelector('input[name="sort"]:checked')) {
         const defaultRadio = document.getElementById('sort-creation-date-asc');
         if (defaultRadio) {
            defaultRadio.checked = true;
            
            // Update visual styling
            const defaultLabel = document.querySelector('label[for="sort-creation-date-asc"]');
            if (defaultLabel) {
               // Remove checked class from all sort labels
               document.querySelectorAll('label[for^="sort-"]').forEach(label => {
                  label.classList.remove('checked');
               });
               
               // Add checked class to default label
               defaultLabel.classList.add('checked');
            }
         }
      }
   });
</script>
