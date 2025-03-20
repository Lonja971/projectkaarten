<h1>Home page</h1>

@if (Route::has('login'))
@auth
   <h3><a href="{{ url('/dashboard') }}">{{ Auth::user()->full_name }}</a>, u bent geregistreerd!!</h3>
   <form method="POST" action="{{ route('logout') }}" class="mt-4">
      @csrf
      <button type="submit">Logout</button>
  </form>
@else
   <div>
      <button onclick="window.location='{{ route('login') }}'" class="header__list-item btn-small">Log in</button>

      @if (Route::has('register'))
         <button onclick="window.location='{{ route('register') }}'" class="header__list-item btn-small">Register</button>
      @endif
   </div>
@endauth
@endif