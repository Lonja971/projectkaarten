<x-guest-layout>

    <style>
        .email-block-none{
            display: none;
        }
    </style>

    <section class="flex flex-col justify-center items-center gap-[20px] p-[50px] min-w-[500px] !border-[0.5px] !border-[#ccc] rounded-[25px] bg-[#fff]">
        <form method="POST" action="/import-users-excel" enctype="multipart/form-data" class="flex flex-col gap-[20px]">
            @csrf
            <div class="flex justify-center gap-[20px]">
                <div class="flex flex-col gap-[8px]">
                    <p class="text-[20px] text-[#000]">Gebruikers importeren via Excel</p>
                    <div class="flex flex-col gap-2 w-full">
                        <label for="file-upload" id="drop-zone" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 border-gray-300">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16V4m0 0L3 8m4-4l4 4M17 16v-6m0 6l-4-4m4 4l4-4"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 px-3"><span class="font-semibold">Klik om te uploaden</span> of sleep hier het bestand</p>
                                <p class="text-xs text-gray-500">.xls, .xlsx of .csv (max 20MB)</p>
                            </div>
                            <input id="file-upload" type="file" name="file" accept=".xlsx,.xls,.csv" required class="hidden" onchange="updateFileName()"/>
                        </label>
                        <p id="fileName" class="text-sm text-gray-500 italic">Geen bestand gekozen</p>
                    </div>
                </div>
            </div>

            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="flex flex-col gap-[8px]">
                    <ul class="text-red-500 text-[16px]">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-2 flex justify-center items-center">
                <button type="submit" class="!cursor-pointer !text-[#fff] !bg-[#292c64] !font-bold font-[Inter] !text-[16px] !pl-[10px] !pr-[10px] !pt-[4px] !pb-[4px] !rounded-[100px] !w-fit">
                    Importeren
                </button>
            </div>
        </form>
    </section>
    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-upload');
        const fileNameDisplay = document.getElementById('fileName');

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('bg-gray-200', 'border-blue-400');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('bg-gray-200', 'border-blue-400');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('bg-gray-200', 'border-blue-400');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (!['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'].includes(file.type)) {
                    alert("Alleen .xls, .xlsx of .csv bestanden zijn toegestaan.");
                    return;
                }
                if (file.size > 20 * 1024 * 1024) {
                    alert('Het bestand is groter dan 20MB. Kies een kleiner bestand.');
                    return;
                }

                // Створити новий FileList для file input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                fileNameDisplay.textContent = file.name;
            }
        });

        function updateFileName() {
            const file = fileInput.files[0];
            if (file) {
                fileNameDisplay.textContent = file.name;
            } else {
                fileNameDisplay.textContent = 'Geen bestand gekozen';
            }
        }
    </script>
</x-guest-layout>