@props(['user_identifier' => null, 'user' => Auth::user()])
@php
      use Illuminate\Support\Facades\DB;
      $profile_user = \App\Models\User::where('identifier', $user_identifier)->first();
@endphp

@if(!$profile_user)
   <meta http-equiv="refresh" content="0;url={{ route('home') }}">
@elseif($user && !\App\Models\User::isTeacher($user->id) && $user->id != $profile_user->id)
   <script>window.location.href = "{{ route('home') }}";</script>
@endif

<!DOCTYPE html>
<html lang="nl" class="h-full">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>{{ $profile_user->full_name }}'s Projectkaarten</title>
      <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
      <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
      <script src="https://kit.fontawesome.com/d4498571f5.js" crossorigin="anonymous"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
      <link href="{{ asset('css/home.css') }}" rel="stylesheet">
   </head>
   @if($profile_user)
   <body class="h-full flex flex-col min-h-screen">
      <x-header title="{{ $profile_user->full_name }}'s Projectkaarten" />
      <div class="flex-grow flex flex-col">
         @php
            $projects = $profile_user->projects->sortBy(function($project) {
                $statusId = $project->status_id ?? 0;
                switch($statusId) {
                    case 2: return 1;
                    case 1: return 2;
                    case 3: return 3;
                    default: return 4;
                }
            });
         @endphp
         
         <section class="pl-[20px] pr-[20px] pt-[10px] pb-[10px]">
            @if(isset($projects) && ((count($projects) > 0 && $user->role->name === "Docent") || ($user->role->name === "Student")))
               <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-[10px]">
                  @foreach($projects as $project)
                     <div class="border border-gray-200 rounded-[20px] overflow-hidden bg-white">
                        @php 
                           $bgColor = isset($project->background_id) ? DB::table('backgrounds')->where('id', $project->background_id)->value('background_color') : '#EEEEEE';
                           $headerStyle = "background-color: " . $bgColor;
                        @endphp
                        <div class="h-[40px] pl-[20px] pr-[20px] pt-[10px] pb-[10px] border-b border-gray-200 flex justify-between items-center gap-[6px]" style="<?php echo $headerStyle; ?>">
                           <div class="flex items-center gap-[6px]">
                              <i class="{{ isset($project->icon_id) ? DB::table('icons')->where('id', $project->icon_id)->value('icon') : 'fa-file' }} text-[#FFF]"></i>
                              <h3 class="text-lg font-semibold text-[#FFF] font-[Inter]">{{ $project->title }}</h3>
                           </div>
                           @php
                              $projectOwnerIdentifier = DB::table('users')->where('id', $project->user_id)->value('identifier');
                           @endphp
                           <a href="{{ route('projects.show', [$projectOwnerIdentifier, $project->project_by_student]) }}"><i class="fa-solid fa-arrow-right text-[#FFF]"></i></a>
                        </div>
                        <div class="pl-[20px] pr-[20px] pt-[10px] pb-[10px] font-[Inter] flex flex-col">
                           <div class="flex justify-between items-center">
                              <span class="text-[16px] text-[#000]">Status:</span>
                              <span class="text-[16px] text-[#000] flex items-center gap-[6px]">
                                  @php
                                    $status = DB::table('project_statuses')->where('id', $project->status_id)->first();
                                    $statusColor = $status->color ?? '#808080';
                                    $bgColor = isset($status->filled) && $status->filled ? $statusColor : 'transparent';
                                    $statusStyle = "border-color: " . $statusColor . "; background-color: " . $bgColor;
                                  @endphp
                                  <span class="w-3 h-3 rounded-full border-3" style="<?php echo $statusStyle; ?>"></span>
                                  {{ $status->name ?? 'Onbekend' }}
                              </span>
                           </div>
                           <div class="flex justify-between items-center">
                              <span class="text-[16px] text-[#000]">Vanaf:</span>
                              <span class="text-[16px] text-[#000]">{{ isset($project->date_start) ? \Carbon\Carbon::parse($project->date_start)->format('d-m-Y') : 'Onbekend' }}</span>
                           </div>
                           <div class="flex justify-between items-center">
                              <span class="text-[16px] text-[#000]">Deadline:</span>
                              <span class="text-[16px] text-[#000]">{{ isset($project->date_end) ? \Carbon\Carbon::parse($project->date_end)->format('d-m-Y') : 'Onbekend' }}</span>
                           </div>
                           @if(isset($project->user_name))
                           <div class="flex justify-between items-center">
                              <span class="text-[16px] text-[#000]">Student:</span>
                              <span class="text-[16px] text-[#000]">{{ $project->user_name ?? 'Onbekend' }}</span>
                           </div>
                           @endif
                        </div>
                     </div>
                  @endforeach
               </div>
            @else
               <div class="flex justify-center items-center min-h-[60vh] flex-col gap-[20px] font-[Inter] text-[20px] text-[#000]">
                  <p>{{ $profile_user->full_name }} heeft nog geen projecten.</p>
                  @if($user && $user->id === $profile_user->id && $user->role->name === "Student")
                     <button id="add-project-empty" class="text-[#fff] bg-[#292c64] font-bold rounded-[100px] pl-[20px] pr-[20px] pt-[10px] pb-[10px]">Project toevoegen</button>
                  @endif
               </div>
            @endif
         </section>
      </div>
      <x-footer />
   </body>
   @endif
</html>