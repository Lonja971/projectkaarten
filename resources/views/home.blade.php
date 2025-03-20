<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Homepage</title>
      <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
   </head>
   <body>
      <x-header />

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
   </body>
</html>