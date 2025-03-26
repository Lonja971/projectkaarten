<h1>Sprint page</h1>
<div>Project id: {{ $project_by_user_identifier }}, by user: {{ $user_identifier }}</div>
<div>Sprint (week nr): {{ $sprint_week_nr ? $sprint_week_nr : "Not provided" }}</div>
<a href="{{ route('projects.show', ['user_identifier' => $user_identifier, 'project_by_user_identifier' => $project_by_user_identifier ]) }}">To Project page</a>
<a href="{{ route('home') }}">To Home page</a>