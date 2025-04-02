@props(['user' => null])

<div class="pl-[20px] pr-[20px] pt-[10px] pb-[10px] flex gap-[20px] flex-col min-h-[60vh] justify-center items-center">
   <p class="text-[#000] font-[Inter] text-[20px]">
      @if($user->role && $user->role->name === "Docent")
         Geen projecten gevonden. Projecten zullen hier verschijnen zodra ze zijn aangemaakt.
      @else
         Je hebt nog geen projecten. 
      @endif
   </p>
   @if($user->role && $user->role->name === "Student")
      <a href="" class="text-[#fff] bg-[#292c64] font-bold font-[Inter] text-[20px] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px] w-fit">
         Maak een nieuw project
      </a>
   @endif
</div>
