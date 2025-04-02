@props(['statuses' => []])

<section id="filter-section" class="border-b-[0.5px] border-[#ddd] pl-[20px] pr-[20px] pt-[10px] pb-[20px] hidden">
   <form class="flex flex-col gap-[20px]">
      <div class="flex flex-col gap-[8px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Sorteren op</p>
         <div class="flex gap-x-[10px] gap-y-[14px] flex-wrap">
            <div>
               <input type="radio" checked name="sort" id="sort-creation-date-asc" class="hidden-input" />
               <label for="sort-creation-date-asc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer checked">Creatie Datum (Nieuw -> Oud)</label>
            </div>
            <div>
               <input type="radio" name="sort" id="sort-creation-date-desc" class="hidden-input" />
               <label for="sort-creation-date-desc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer">Creatie Datum (Oud -> Nieuw)</label>
            </div>
            <div>
               <input type="radio" name="sort" id="sort-update-date-asc" class="hidden-input" />
               <label for="sort-update-date-asc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer">Laatste Update (Nieuw -> Oud)</label>
            </div>
            <div>
               <input type="radio" name="sort" id="sort-update-date-desc" class="hidden-input" />
               <label for="sort-update-date-desc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer">Laatste Update (Oud -> Nieuw)</label>
            </div>
            <div>
               <input type="radio" name="sort" id="sort-end-date-asc" class="hidden-input" />
               <label for="sort-end-date-asc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer">Eind Datum (Eerstvolgend -> Laatste)</label>
            </div>
            <div>
               <input type="radio" name="sort" id="sort-end-date-desc" class="hidden-input" />
               <label for="sort-end-date-desc" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer">Eind Datum (Laatste -> Eerstvolgend)</label>
            </div>
            <div>
               <input type="radio" name="sort" id="sort-a-z" class="hidden-input" />
               <label for="sort-a-z" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer">Naam (A -> Z)</label>
            </div>
            <div>
               <input type="radio" name="sort" id="sort-z-a" class="hidden-input" />
               <label for="sort-z-a" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer">Naam (Z -> A)</label>
            </div>
         </div>
      </div>

      <div class="flex flex-col gap-[8px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Status</p>
         <div class="flex gap-x-[10px] gap-y-[14px] flex-wrap">
         @foreach($statuses ?? [] as $status)
            <div>
               <input type="checkbox" checked name="status-{{ $status->id }}" id="status-{{ $status->id }}" class="hidden-input" />
               <label for="status-{{ $status->id }}" class="border-[0.5px] border-[#ccc] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] font-[Inter] cursor-pointer checked">{{ $status->name }}</label>
            </div>
         @endforeach
         </div>
      </div>

      <div class="flex flex-col gap-[4px]">
         <p class="text-[#000] font-[Inter] text-[20px]">Functies</p>
         <div class="flex gap-[10px]">
            <button type="reset" class="text-[#fff] bg-[#292c64] font-bold font-[Inter] text-[16px] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] w-fit" onclick="resetFormToDefaults(event)">Resetten</button>
            <button type="submit" class="text-[#fff] bg-[#292c64] font-bold font-[Inter] text-[16px] pl-[10px] pr-[10px] pt-[4px] pb-[4px] rounded-[100px] w-fit">Opslaan</button>
         </div>
      </div>
   </form>
</section>
