@php
    use Illuminate\Support\Facades\DB;
@endphp

@props(['projects' => [], 'user' => null])

<section class="pl-[20px] pr-[20px] pt-[10px] pb-[10px]">
   @if(isset($projects) && count($projects) > 0)
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-[10px]">
         @if ($user->role && $user->role->name === "Student")
         <!-- New "Add Project" block -->
         <div class="rounded-[25px] overflow-hidden bg-[#292c64] flex items-center justify-center cursor-pointer">
            <div class="text-white text-6xl font-bold p-[20px] flex items-center justify-center h-full w-full"><i class="fa-solid fa-plus"></i></div>
         </div>
         @endif
         @foreach($projects as $project)
            <div class="border border-gray-200 rounded-[20px] overflow-hidden bg-white">
               <div class="h-[40px] pl-[20px] pr-[20px] pt-[10px] pb-[10px] border-b border-gray-200 flex justify-between items-center gap-[6px]" style="background-color: {!! isset($project->background_id) ? DB::table('backgrounds')->where('id', $project->background_id)->value('background_color') : '#EEEEEE' !!};">
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
                        @if(isset($project->filled) && $project->filled)
                           <span class="w-3 h-3 rounded-full border-3" 
                              style="border-color: {!! $project->color ?? '#808080' !!}; background-color: {!! $project->color ?? '#808080' !!};"></span>
                        @else
                           <span class="w-3 h-3 rounded-full border-3 bg-transparent" 
                              style="border-color: {!! $project->color ?? '#808080' !!};"></span>
                        @endif
                        {{ $project->status_name }}
                     </span>
                  </div>
                  @if($user->role && $user->role->name === "Docent" && isset($project->user_name))
                     <div class="flex justify-between items-center">
                        <span class="text-[16px] text-[#000]">Student:</span>
                        <span class="text-[16px] text-[#000]">{{ $project->user_name }}</span>
                     </div>
                  @endif
                  <div class="flex justify-between items-center">
                     <span class="text-[16px] text-[#000]">Startdatum:</span>
                     <span class="text-[16px] text-[#000]">{{ $project->date_start ? date('d/m/Y', strtotime($project->date_start)) : 'Niet ingesteld' }}</span>
                  </div>
                  <div class="flex justify-between items-center">
                     <span class="text-[16px] text-[#000]">Einddatum:</span>
                     <span class="text-[16px] text-[#000]">{{ $project->date_end ? date('d/m/Y', strtotime($project->date_end)) : 'Niet ingesteld' }}</span>
                  </div>
               </div>
            </div>
         @endforeach
      </div>
   @else
      <x-empty-state :user="$user" />
   @endif
</section>
