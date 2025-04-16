<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" />

    <section class="flex flex-col justify-center items-center gap-[20px] p-[50px] min-w-[400px] !border-[0.5px] !border-[#ccc] rounded-[25px] bg-[#fff]">
        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-[20px]">
            @csrf

            @if ($errors->any())
                <div class="flex flex-col gap-[8px]">
                    <ul class="text-red-500 text-[16px]">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex gap-[20px]">
                <!-- Name -->   
                <div class="flex flex-col gap-[8px]">
                    <p class="text-[20px] text-[#000]">{{ __('Name') }}</p>
                    <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" class="!border-[0.5px] !border-[#ccc] !pl-[10px] !pr-[10px] !pt-[4px] !pb-[4px] !rounded-[100px] font-[Inter] !w-fit" required autofocus autocomplete="full_name" placeholder="Name" />
                    <x-input-error :messages="$errors->get('full_name')" />
                </div>

                <!-- Email Address -->
                <div class="flex flex-col gap-[8px]">
                    <p class="text-[20px] text-[#000]">{{ __('Email') }}</p>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="!border-[0.5px] !border-[#ccc] !pl-[10px] !pr-[10px] !pt-[4px] !pb-[4px] !rounded-[100px] font-[Inter] !w-fit" required autocomplete="username" placeholder="Email" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>
            </div>

            <div class="flex gap-[20px]">   
                <!-- Role -->
                <div class="flex flex-col gap-[8px]">
                    <p class="text-[20px] text-[#000]">{{ __('Role') }}</p>
                    <select id="role" name="role_id" class="!border-[0.5px] !border-[#ccc] !pl-[10px] !pr-[10px] !pt-[4px] !pb-[4px] !rounded-[100px] font-[Inter] !w-[224px]">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}"
                                {{ old('role_id', 2) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <div class="text-red-500 text-[16px]">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Student Number / Afkorting -->
                <div id="identifier_block" class="flex flex-col gap-[8px]">
                    <p id="identifier_label" class="text-[20px] text-[#000]">{{ __('Studentnummer') }}</p>
                    <input id="identifier" type="text" name="identifier" value="{{ old('identifier') }}" class="!border-[0.5px] !border-[#ccc] !pl-[10px] !pr-[10px] !pt-[4px] !pb-[4px] !rounded-[100px] font-[Inter] !w-fit" required placeholder="Studentnummer">
                    @error('identifier')
                        <div class="text-red-500 text-[16px]">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('password.request') }}" class="!text-[#000] !font-[Inter] !text-[16px] hover:underline">
                    Sheet importeren?
                </a>

                <button type="submit" class="!cursor-pointer !text-[#fff] !bg-[#292c64] !font-bold font-[Inter] !text-[16px] !pl-[10px] !pr-[10px] !pt-[4px] !pb-[4px] !rounded-[100px] !w-fit">
                    Register
                </button>
            </div>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const identifierLabel = document.getElementById('identifier_label');
            const identifierInput = document.getElementById('identifier');
            
            // Check initial value
            updateIdentifierField();
            
            // Add event listener for changes
            roleSelect.addEventListener('change', updateIdentifierField);
            
            function updateIdentifierField() {
                // Find the selected option text
                const selectedText = roleSelect.options[roleSelect.selectedIndex].text.trim().toLowerCase();
                
                if (selectedText === 'docent') {
                    identifierLabel.textContent = 'Afkorting';
                    identifierInput.placeholder = 'Afkorting';
                } else {
                    identifierLabel.textContent = 'Studentnummer';
                    identifierInput.placeholder = 'Studentnummer';
                }
            }
        });
    </script>
</x-guest-layout>
