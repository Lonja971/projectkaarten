<h1>Sprint page</h1>
<div>Project id: {{ $project_by_user_nr }}, by user: {{ $user_nr }}</div>
<div>Sprint (week nr): {{ $sprint_week_nr ? $sprint_week_nr : "Not provided" }}</div>
<a href="{{ route('projects.show', ['user_nr' => $user_nr, 'project_by_user_nr' => $project_by_user_nr ]) }}">To Project page</a>
<a href="{{ route('home') }}">To Home page</a>