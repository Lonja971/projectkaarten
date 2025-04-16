<h1>Sprint page</h1>
<div>Project id: {{ $project_by_user_identifier }}, by user: {{ $user_identifier }}</div>
<div>Sprint (week nr): {{ $sprint_nr ? $sprint_nr : "Not provided" }}</div>
<a href="{{ route('projects.show', ['user_identifier' => $user_identifier, 'project_by_user_identifier' => $project_by_user_identifier ]) }}">To Project page</a>
<a href="{{ route('home') }}">To Home page</a>

<button onclick="getData()">Click</button>

<script>

   async function getData(){
      const response = await fetch(`http://127.0.0.1:8000/api/test/`, {
         method: 'GET',
         headers: {
            'Content-Type': 'application/json',
         }
      });
      
      if (!response.ok){
         throw new Error(`Response status: ${response.status}`);
      }
      const myResponseData = await response.json();
      console.log(myResponseData);
   } 

</script>