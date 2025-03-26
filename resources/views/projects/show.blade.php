<h1>Project Page</h1>
<div>Project: {{ $project_by_user_identifier ? $project_by_user_identifier : "Not provided" }} , by user: {{ $user_identifier }}</div>
<a href="{{ route('home') }}">To Home page</a>