@props(['users' => [], 'user' => null])

<section id="student-cards-section" class="pl-[20px] pr-[20px] pt-[10px] pb-[10px] grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-[20px]">
    @if(count($users) > 0)
        @foreach($users as $student)
            <div class="flex items-center justify-between gap-[10px] pl-[15px] pr-[15px] pt-[6px] pb-[6px] rounded-[20px] border-[0.5px] border-[#ccc]">
                <div class="flex flex-col">
                    <p class="text-[#000] font-[Inter] text-[16px] font-bold">{{ $student->full_name }}</p>
                    <p class="text-[#000] font-[Inter] text-[16px]">{{ $student->identifier}}</p>
                    <p class="text-[#000] font-[Inter] text-[16px]">Aantal projecten: {{ $student->projects->count() }}</p>
                </div>
                <a href="{{ route('users.index', $student->identifier) }}" class="text-[#292c64] font-bold font-[Inter] text-[16px]"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
        @endforeach
    @endif
</section>