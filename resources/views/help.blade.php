@props(['user' => Auth::user()])

<!DOCTYPE html>
<html lang="nl" class="h-full">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Help</title>
      <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
      <script src="https://kit.fontawesome.com/d4498571f5.js" crossorigin="anonymous"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
      <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
      
      <!-- Custom CSS -->
      <link href="{{ asset('css/home.css') }}" rel="stylesheet">
   </head>
   <body class="h-full flex flex-col min-h-screen">
      <x-header title="Help" />
      <x-help-navigation-buttons />
      
      <!-- Help Content Container -->
      <div class="flex-grow flex flex-col">
         <!-- Tab Contents -->
         <div id="student-help-content" class="font-[Inter] help-tab-content flex min-h-[60vh] pl-[20px] pr-[20px] pt-[10px] pb-[10px] gap-[20px]">
            <x-student-help />
         </div>
         @if ($user->role->name === "Docent")
         <div id="docent-help-content" class="font-[Inter] help-tab-content hidden flex min-h-[60vh] pl-[20px] pr-[20px] pt-[10px] pb-[10px] gap-[20px]">
            <x-docent-help />
         </div>
         @endif
         <div id="api-help-content" class="font-[Inter] help-tab-content hidden flex min-h-[60vh] pl-[20px] pr-[20px] pt-[10px] pb-[10px] gap-[20px]">
            <x-api-help />
         </div>
      </div>
      
      <x-footer />