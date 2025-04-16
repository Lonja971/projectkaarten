<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" />

    <section class="flex flex-col justify-center items-center gap-[20px] p-[50px] min-w-[400px] !border-[0.5px] !border-[#ccc] rounded-[25px] bg-[#fff]">
        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-[20px]">
            @csrf
            <div class="flex gap-[20px]">
                <div class="flex flex-col gap-[8px]">
                    <p class="text-[20px] text-[#000]">Email</p>
                    <input id="email" type="email" name="email" class="!border-[0.5px] !border-[#ccc] !pl-[10px] !pr-[10px] !pt-[4px] !pb-[4px] !rounded-[100px] font-[Inter] !w-fit" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Email" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <div class="flex flex-col gap-[8px]">
                    <p class="text-[20px] text-[#000]">Password</p>
                    <input id="password" 
                        type="password"
                        name="password"
                        class="!border-[0.5px] !border-[#ccc] !pl-[10px] !pr-[10px] !pt-[4px] !pb-[4px] !rounded-[100px] font-[Inter] !w-fit"
                        required autocomplete="current-password" 
                        placeholder="Password" />
                    <x-input-error :messages="$errors->get('password')" />
                </div>
            </div>

            <div class="flex flex-col gap-[8px]">
                <div class="flex items-center gap-[10px]">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">
                        <span class="!text-[#000] !font-[Inter] !text-[16px]">Onthoud mij</span>
                    </label>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="!text-[#000] !font-[Inter] !text-[16px] hover:underline">
                            Wachtwoord vergeten?
                        </a>
                    @endif

                    <button type="submit" class="!cursor-pointer !text-[#fff] !bg-[#292c64] !font-bold font-[Inter] !text-[16px] !pl-[10px] !pr-[10px] !pt-[4px] !pb-[4px] !rounded-[100px] !w-fit">
                        Log in
                    </button>
                </div>
            </div>
        </form>
    </section>
</x-guest-layout>
