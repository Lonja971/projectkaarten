<form method="POST" action="/import-users-excel" enctype="multipart/form-data" class="max-w-md mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
   @csrf
   <h2 class="text-2xl font-bold mb-4">Gebruikers importeren via Excel</h2>

   <label class="block mb-2 text-sm font-medium text-gray-700" for="file">Selecteer een Excel-bestand</label>
   <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required
          class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none">

   <button type="submit"
           class="mt-4 w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
         Importeren
   </button>
</form>

@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

@if(session('errors'))
    <div class="alert alert-danger">
        <ul>
            @foreach(session('errors') as $index => $error)
                <li>Row {{ $index }}: {{ implode(' ', $error->all()) }}</li>
            @endforeach
        </ul>
    </div>
@endif