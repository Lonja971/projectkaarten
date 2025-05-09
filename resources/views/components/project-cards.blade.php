@php
    use Illuminate\Support\Facades\DB;
@endphp

@props(['projects' => [], 'user' => null])

<section class="pl-[20px] pr-[20px] pt-[10px] pb-[10px]" style="min-height: calc(100vh - 68px);">
   @if(isset($projects) && ((count($projects) > 0 && $user->role->name === "Docent") || ($user->role->name === "Student")))
      <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-[10px]">
         @if ($user->role && $user->role->name === "Student")
         <!-- New "Add Project" block -->
         <div id="add-project-button" class="rounded-[25px] overflow-hidden bg-[#292c64] flex items-center justify-center cursor-pointer">
            <div class="text-white text-6xl font-bold p-[20px] flex items-center justify-center h-full w-full"><i class="fa-solid fa-plus"></i></div>
         </div>
         @endif
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
                          $statusColor = $project->color ?? '#808080';
                          $bgColor = isset($project->filled) && $project->filled ? $statusColor : 'transparent';
                          $statusStyle = "border-color: " . $statusColor . "; background-color: " . $bgColor;
                        @endphp
                        <span class="w-3 h-3 rounded-full border-3" style="<?php echo $statusStyle; ?>"></span>
                        {{ $project->status_name ?? 'Onbekend' }}
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
      <x-empty-state-projects :user="$user" />
   @endif
</section>
