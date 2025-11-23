<x-guest-layout>
    @if(session('success'))
        <div
          id="success-message"
          class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center"
        >
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 1500);
        </script>
    @endif

    <form method="POST" action="{{ route('register') }}" class="max-w-3xl mx-auto">
        @csrf

        <div class="grid grid-cols-1 gap-4">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Member ID & Phone No -->
            <div class="grid grid-cols-1">
                <div>
                    <x-input-label for="idno" :value="__('Member ID')" />
                    <x-text-input id="member_id" class="block mt-1 w-full" type="text" name="member_id" :value="old('member_id')" required autofocus autocomplete="off" />
                    <p class="text-sm text-gray-500 mt-1">Format: OBM1234, OBBM5678, OBBBM91011</p>
                    <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                </div>
            </div>
            <div class="grid grid-cols-1">
                    <x-input-label for="phone_no" :value="__('Phone No')" />
                    <x-text-input id="phone_no" class="block mt-1 w-full" type="text" name="phone_no" :value="old('phone_no')" required autocomplete="off" />
                    <x-input-error :messages="$errors->get('phone_no')" class="mt-2" />
            </div>
            

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="off" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password & Confirm Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
