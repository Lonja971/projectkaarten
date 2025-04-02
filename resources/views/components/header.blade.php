@props(['user' => Auth::user()])

<header class="flex justify-between items-center min-h-[100px] pl-[20px] pr-[20px] relative z-20">
    <div class="flex justify-start items-center gap-[20px]">
        <img src="https://ict-flex.nl/wp-content/uploads/2023/08/ICT-Flex-v2.png" alt="ICT Flex" class="h-[60px]"></img>
        <h1 class="text-[48px] font-bold font-[Inter] text-[#fff]">Projectkaarten
            @if ($user && $user->role && $user->role->name === "Docent")
                 | Docent
            @elseif ($user && $user->role && $user->role->name === "Student")
                 | Student
            @endif
        </h1>
    </div>
    <div class="flex flex-col justify-center items-end">
        @if ($user)
            <span class="text-[24px] font-bold font-[Inter] text-[#fff]">{{ $user->full_name }}</span>
        @endif 
    </div>
</header>

<nav class="min-h-[60px] bg-[#000000]/60 pl-[20px] pr-[20px] flex justify-between items-center relative z-20">
    <div class="flex justify-start items-center gap-[40px]">
        <a href="{{ route('home') }}" class="text-[#fff] font-[Inter] text-[20px] {{ request()->routeIs('home') ? 'underline font-bold' : 'hover:underline' }}">Overzicht</a>
        <a href="https://ict-flex.nl" class="text-[#fff] font-[Inter] text-[20px] hover:underline">ICT-Flex</a>
    </div>
    <div class="flex justify-end items-center gap-[40px]">
    <a href="{{ route('help') }}" class="text-[#fff] font-[Inter] text-[20px] {{ request()->routeIs('help') ? 'underline font-bold' : 'hover:underline' }}">Help</a>
        @if (Route::has('login'))
            @auth
                <form method="POST" action="{{ route('logout') }}" class="">
                    @csrf
                    <button type="submit" class="text-[#fff] hover:underline hover:cursor-pointer font-[Inter] text-[20px]">Logout</button>
                </form>
            @else
                <button onclick="window.location='{{ route('login') }}'" class="text-[#fff] hover:underline font-[Inter] text-[20px]">Log in</button>
            @endauth
        @endif
    </div>
</nav>  

<section class="min-h-[480px] pt-[160px] mt-[-160px] relative flex items-center pl-[20px] pr-[20px]">
    <div class="absolute inset-0 bg-[url('https://ict-flex.nl/wp-content/uploads/2023/10/deltion3large.webp')] bg-cover bg-center bg-no-repeat"></div>
    <div class="absolute inset-0 bg-black opacity-60"></div>
    <span class="text-[48px] font-bold font-[Inter] text-[#fff] relative z-10">Overzicht</span>
</section>