@props(['user' => Auth::user()])

<header class="header">
    <div>
        <img src="" alt=""><!-- Logo --></img>
        <h1>Projectkaarten
            @if ($user && $user->role && $user->role->name === "Docent")
                 | Teacher
            @elseif ($user && $user->role && $user->role->name === "Student")
                 | Student
            @endif
        </h1>
    </div>
    <div>
        @if ($user)
            <span>{{ $user->full_name }}</span>
            @if ($user->role && $user->role->name === "Student")
                <span>{{ $user->student_nr }}</span>
            @endif
        @endif 
    </div>
</header>

<nav class="header__nav">
<!-- Menu -->
</nav>

<section class="header__banner">
<!-- Banner -->
</section>