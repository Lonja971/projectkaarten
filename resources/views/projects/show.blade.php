@props(['user_identifier' => null, 'project_by_user_identifier' => null, 'user' => Auth::user()])
@php
      $profile_user = \App\Models\User::where('identifier', $user_identifier)->first();
      $project = \App\Models\Project::where('user_id', $profile_user->id)
                  ->where('project_by_student', $project_by_user_identifier)
                  ->first();
@endphp

@if(!$project)
   <meta http-equiv="refresh" content="0;url={{ route('home') }}">
@elseif($user && !\App\Models\User::isTeacher($user->id) && $user->id != $profile_user->id)
   <script>window.location.href = "{{ route('home') }}";</script>
@endif

<!DOCTYPE html>
<html lang="nl" class="h-full">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>{{ $project->title }}</title>
      <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
      <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
      <script src="https://kit.fontawesome.com/d4498571f5.js" crossorigin="anonymous"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
      <link href="{{ asset('css/home.css') }}" rel="stylesheet">
   </head>
   @if($project)
   <body class="h-full flex flex-col min-h-screen">
      <x-header subtitle="{{ $profile_user->full_name }}'s Projectkaarten >" subtitleurl="{{ route('home') }}/{{ $profile_user->identifier }}" title="{{ $project->title }}" />
      <div class="flex-grow flex flex-col">
      </div>
      <x-footer />
   </body>
   @endif
</html>