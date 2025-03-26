@props(['user' => Auth::user()])

<!DOCTYPE html>
<html lang="en" class="h-full">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Homepage</title>
      <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
      <script src="https://kit.fontawesome.com/d4498571f5.js" crossorigin="anonymous"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
   </head>
   <body class="h-full flex flex-col min-h-screen">
      <x-header />

      <section class="border-b-[0.5px] border-[#ddd] pl-[20px] pr-[20px] pt-[10px] pb-[10px] flex gap-[20px] justify-between">
         @if ($user && $user->role && $user->role->name === "Docent")
         <div class="flex gap-[20px]">
            <button class="text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px]"><i class="fa-regular fa-file pr-[6px]"></i> Alle Projectkaarten</button>
            <button class="text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px]"><i class="fa-regular fa-user pr-[6px]"></i> Studenten</button>
         </div>
         @elseif ($user && $user->role && $user->role->name === "Student")
         <div class="flex gap-[20px]">
            <button class="text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px]"><i class="fa-regular fa-file pr-[6px]"></i> Mijn Projectkaarten</button>
            <button class="text-[#000] font-[Inter] text-[20px] border-[0.5px] border-[#ccc] pl-[20px] pr-[20px] pt-[8px] pb-[8px] rounded-[100px]"><i class="fa-regular fa-star pr-[6px]"></i> Review</button>
         </div>
         @endif
         <button class="text-[#000] font-[Inter] text-[20px] rounded-[100px]"><i class="fa-solid fa-sliders pr-[6px]"></i> Filteren</button>
      </section>

      <section class="border-b-[0.5px] border-[#ddd] pl-[20px] pr-[20px] pt-[10px] pb-[10px]">
         Test
      </section>

      <section class="pl-[20px] pr-[20px] pt-[10px] pb-[10px]">
         Test
      </section>

      <x-footer />
   </body>
</html>