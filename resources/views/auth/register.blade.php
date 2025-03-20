<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        @if ($errors->any())
            <div class="text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required autofocus autocomplete="full_name" />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
        </div>

        <!-- Role -->
        <select id="role" name="role_id">
            @foreach($roles as $role)
                <option value="{{$role->id}}"
                    {{ old('role_id', 2) == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('role_id')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <!-- Student Number -->
        <div id="student_nr_block">
            <label for="student_nr">Student Number</label>
            <input id="student_nr" type="number" name="student_nr" value="{{ old('student_nr') }}" required>
        </div>

        @error('student_nr')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const roleSelect = document.getElementById("role");
                const studentNrBlock = document.getElementById("student_nr_block");
                const studentNrinput = document.getElementById("student_nr");
        
                function toggleStudentNr() {
                    if (roleSelect.value == "1") {
                        studentNrBlock.style.display = "none";
                        studentNrinput.value = false;
                    } else {
                        studentNrBlock.style.display = "block";
                    }
                }
        
                toggleStudentNr();
        
                roleSelect.addEventListener("change", toggleStudentNr);
            });
        </script>
    </form>
</x-guest-layout>
