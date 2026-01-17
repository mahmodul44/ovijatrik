<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl w-full flex flex-col md:flex-row bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            
            <div class="hidden md:flex md:w-5/12 bg-emerald-600 p-12 text-white flex-col justify-between relative overflow-hidden">
                <div class="relative z-10">
                    <div class="mb-1 transition transform hover:scale-105 duration-500 origin-left">
                        <img src="{{ asset('logo_bgtransparent.png') }}" alt="Logo" class="w-44 lg:w-52 h-auto brightness-0 invert" />
                    </div>
                    <h3 class="text-3xl font-bold leading-tight mb-4">Join our mission to change lives.</h3>
                    <p class="text-emerald-100 leading-relaxed font-light">
                        By becoming a member, you contribute to a community dedicated to humanity, hope, and sustainable change.
                    </p>
                </div>
                
                <div class="relative z-10 bg-emerald-700/50 p-6 rounded-xl border border-emerald-400/30">
                    <p class="text-sm italic">"The best of people are those that bring most benefit to the rest of mankind."</p>
                </div>

                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-emerald-500 rounded-full opacity-50"></div>
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-400 rounded-full opacity-30"></div>
            </div>

            <div class="w-full md:w-7/12 p-8 lg:p-12">
                @if(session('success'))
                    <div id="success-message" class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-center animate-pulse">
                        <span class="font-bold">✨ Success!</span> {{ session('success') }}
                    </div>
                    <script>
                        setTimeout(() => { window.location.href = "{{ route('login') }}"; }, 1500);
                    </script>
                @endif

                <div class="mb-10 text-center md:text-left">
                    <h2 class="text-2xl font-black text-gray-800 tracking-tight">Create Account</h2>
                    <p class="text-gray-500 text-sm">Fill in your details to register as a member.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" class="text-xs uppercase tracking-widest font-bold text-gray-400" :value="__('Full Name')" />
                        <x-text-input id="name" class="block mt-1 w-full bg-gray-50 border-gray-200 focus:bg-white focus:ring-emerald-500" type="text" name="name" :value="old('name')" required autofocus placeholder="John Doe" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="member_id" class="text-xs uppercase tracking-widest font-bold text-gray-400" :value="__('Member ID')" />
                            <x-text-input id="member_id" class="block mt-1 w-full bg-gray-50 border-gray-200" type="text" name="member_id" :value="old('member_id')" required placeholder="OBM1234" />
                            <p class="text-[10px] text-emerald-600 mt-1 font-medium">Format: OBM, OBBM, or OBBBM</p>
                            <x-input-error :messages="$errors->get('member_id')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="phone_no" class="text-xs uppercase tracking-widest font-bold text-gray-400" :value="__('Phone Number')" />
                            <x-text-input id="phone_no" class="block mt-1 w-full bg-gray-50 border-gray-200" type="text" name="phone_no" :value="old('phone_no')" required placeholder="+880" />
                            <x-input-error :messages="$errors->get('phone_no')" class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="email" class="text-xs uppercase tracking-widest font-bold text-gray-400" :value="__('Email Address')" />
                        <x-text-input id="email" class="block mt-1 w-full bg-gray-50 border-gray-200" type="email" name="email" :value="old('email')" required placeholder="email@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="password" class="text-xs uppercase tracking-widest font-bold text-gray-400" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 border-gray-200" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" class="text-xs uppercase tracking-widest font-bold text-gray-400" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 border-gray-200" type="password" name="password_confirmation" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <div class="flex flex-col space-y-4 mt-8">
                        <x-primary-button class="w-full justify-center py-3 bg-emerald-600 hover:bg-emerald-700 text-white shadow-lg shadow-emerald-200 transition-all active:scale-95">
                            {{ __('Become a Member') }}
                        </x-primary-button>

                        <div class="text-center">
                            <span class="text-sm text-gray-500">Already a member?</span>
                            <a class="text-sm font-bold text-emerald-600 hover:text-emerald-700 ml-1" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>