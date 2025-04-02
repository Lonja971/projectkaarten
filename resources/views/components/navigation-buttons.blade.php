@props(['user' => null])

<section class="border-b-[0.5px] border-[#ddd] pl-[20px] pr-[20px] pt-[10px] pb-[10px] flex gap-[20px] justify-between">
   @if ($user && $user->role && $user->role->name === "Docent")
   <div class="flex gap-[20px]">
      <button id="projects-button" class="nav-toggle-button text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px] active-nav-button"><i class="fa-regular fa-file pr-[6px]"></i> Alle Projectkaarten</button>
      <button id="students-button" class="nav-toggle-button text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px]"><i class="fa-regular fa-user pr-[6px]"></i> Studenten</button>
   </div>
   @elseif ($user && $user->role && $user->role->name === "Student")
   <div class="flex gap-[20px]">
      <button id="my-projects-button" class="nav-toggle-button text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px] active-nav-button"><i class="fa-regular fa-file pr-[6px]"></i> Mijn Projectkaarten</button>
   </div>
   @endif
   <button id="filter-toggle-button" class="text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px]"><i class="fa-solid fa-sliders pr-[6px]"></i> Filteren</button>
</section>
