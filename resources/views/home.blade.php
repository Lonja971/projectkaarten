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
      
      <!-- Custom CSS -->
      <link href="{{ asset('css/home.css') }}" rel="stylesheet">
   </head>
   <body class="h-full flex flex-col min-h-screen">
      <x-header />
      @if ($user)
         <x-navigation-buttons :user="$user" />
         
         <!-- Projects content - visible by default -->
         <div id="projects-content">
            <x-filter-section :statuses="$statuses ?? []" />
            <x-project-cards :projects="$projects ?? []" :user="$user" />
         </div>
         
         <!-- Students content - hidden by default -->
         <div id="students-content" class="hidden">
            <x-student-filter-section :roles="$roles ?? []" />
            <x-student-list :users="$students ?? []" :user="$user" />
         </div>
      @else
         <x-login-required />
      @endif

      <x-footer />
      
      <!-- Custom JavaScript -->
      <script src="{{ asset('js/reset-form.js') }}"></script>
      <script src="{{ asset('js/form-elements.js') }}"></script>
      <script src="{{ asset('js/filter.js') }}"></script>
      <script src="{{ asset('js/navigation.js') }}"></script>
      <script src="{{ asset('js/student-filter.js') }}"></script>
   </body>
</html>
