<h1>Project Page</h1>
<div>Project: {{ $project_by_user_nr ? $project_by_user_nr : "Not provided" }} , by user: {{ $user_nr }}</div>
<a href="{{ route('home') }}">To Home page</a>