<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8fafc] dark:bg-gray-950">
        
        <div class="w-full sm:max-w-4xl mt-6 flex flex-col md:flex-row bg-white dark:bg-gray-900 shadow-[0_20px_50px_rgba(8,_112,_184,_0.1)] rounded-[2.5rem] overflow-hidden border border-gray-100 dark:border-gray-800">
            
            <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-[#036056] via-[#024d45] to-[#013a34] p-12 text-white flex-col justify-between relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/pichica-pattern.png');"></div>
                
                <div class="relative z-10">
                    <div class="mb-4 transition transform hover:scale-105 duration-500 origin-left">
                        <img src="{{ asset('logo_bgtransparent.png') }}" alt="Logo" class="w-44 lg:w-52 h-auto brightness-0 invert" />
                    </div>

                    <div class="space-y-2"> <h3 class="text-4xl lg:text-5xl font-black leading-tight tracking-tighter italic">
                            Welcome to the <br><span class="text-emerald-400 font-serif font-light not-italic">Portal.</span>
                        </h3>
                        <p class="text-emerald-100/70 font-medium text-lg leading-relaxed max-w-xs">
                            Manage donations, track impact, and lead the change.
                        </p>
                    </div>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                        <div class="h-10 w-10 rounded-full bg-emerald-500 flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <span class="text-sm font-bold tracking-tight uppercase">Secure Portal</span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 sm:p-12 lg:p-16">
                <div class="mb-10">
                    <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Login</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Enter your details to access your dashboard.</p>
                </div>

                @if (session('success'))
                    <div class="mb-4 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 p-4 rounded-2xl text-sm border border-emerald-100 dark:border-emerald-800 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.15em] mb-2 px-1">Email Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-emerald-600 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                                class="block w-full pl-11 pr-4 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 focus:bg-white dark:focus:bg-gray-700 transition-all font-medium text-gray-900 dark:text-white" placeholder="">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2 px-1">
                            <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.15em]">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition" href="{{ route('password.request') }}">
                                    Forgot?
                                </a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-emerald-600 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="block w-full pl-11 pr-4 py-4 bg-gray-50 dark:bg-gray-800 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 focus:bg-white dark:focus:bg-gray-700 transition-all font-medium text-gray-900 dark:text-white" placeholder="">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-gray-300 dark:border-gray-700 text-emerald-600 shadow-sm focus:ring-emerald-500 transition-all cursor-pointer">
                        <label for="remember_me" class="ms-3 text-sm font-bold text-gray-500 dark:text-gray-400 cursor-pointer select-none tracking-tight">Remember this device</label>
                    </div>

                    <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-lg shadow-[0_10px_30px_rgba(16,_185,_129,_0.3)] transition transform active:scale-95 hover:-translate-y-1">
                        Sign In
                    </button>
                    
                    <p class="text-center text-sm font-bold text-gray-500 mt-6">
                        Don't have an account? <a href="/register" class="text-emerald-600 hover:underline">Register here</a>
                    </p>
                </form>
            </div>
        </div>

        <p class="mt-8 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">
            &copy; {{ date('Y') }} Ovijatrik Foundation • All Rights Reserved
        </p>
    </div>
</x-guest-layout>