<!-- resources/views/layouts/sidebar.blade.php -->

<!-- Sidebar (Desktop) -->
@php
    $currentRoute = Route::currentRouteName();
@endphp

<div class="p-2 text-xl text-center font-bold border-b dark:border-gray-700" x-show="!sidebarCollapsed">
    <!-- Light mode logo -->
    <img src="{{ asset('logo_bgtransparent-sm.png') }}" alt="Ovijatrik" class="w-20 h-11 mx-auto" x-show="!darkMode">
    <!-- Dark mode logo -->
    <img src="{{ asset('logo.png') }}" alt="Ovijatrik" class="w-20 h-11 mx-auto" x-show="darkMode">
</div> 

{{-- <div class="p-3 text-center font-bold border-b dark:border-gray-700" x-show="!sidebarCollapsed">
    <div x-show="!darkMode" class="space-y-1">
        <!-- Light Mode -->
        <div class="text-2xl font-extrabold tracking-wide text-gray-900">
            <span class="text-red-600">অ</span>ভিযাত্রিক
        </div>
        <div class="text-sm tracking-wider text-gray-600">
            হাসিমুখের খোঁজে অভিযাত্রা
        </div>
    </div>

    <div x-show="darkMode" class="space-y-1">
        <!-- Dark Mode -->
        <div class="text-2xl font-extrabold tracking-wide text-white">
            <span class="text-red-500">অ</span>ভিযাত্রিক
        </div>
        <div class="text-sm tracking-wider text-gray-300">
            হাসিমুখের খোঁজে অভিযাত্রা
        </div>
    </div>
</div> --}}


<nav class="p-4 space-y-2 flex-1 overflow-y-auto sidebar font-sans">

    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}" 
       class="flex items-center space-x-2 p-2 rounded-lg text-sm font-medium transition
              {{ $currentRoute == 'dashboard' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" stroke="none">
            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/>
        </svg>
        <span x-show="!sidebarCollapsed" x-transition>Dashboard</span>
    </a>

    <!-- Own donation Menu -->
    @if(Auth::check() && Auth::user()->role == 3)
    @php $mydonationsActive = in_array($currentRoute, ['mytransaction.index','mytransaction.report']); @endphp
    <div x-data="{ open: @json($mydonationsActive) }">
        <button @click="open = !open" 
            :class="open 
                ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' 
                : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
            class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">

            <span class="flex items-center space-x-2">
                <!-- Money Receipt Icon -->
                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 17v-2a4 4 0 014-4h4M5 12h.01M5 16h.01M5 8h.01M17 17h.01M17 13h.01M17 9h.01M4 21h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v15a1 1 0 001 1z"/>
                </svg>

                <span x-show="!sidebarCollapsed" x-transition>Donations</span>
            </span>

            <!-- Arrow Icon -->
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('mytransaction.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['mytransaction.index']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Receipts</span>
            </a>
            {{-- <a href="{{ route('mytransaction.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'mytransaction.index' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Voucher</span>
            </a> --}}
            <a href="{{ route('mytransaction.report') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'mytransaction.report' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Reports</span>
            </a>
        </div>
    </div>
    @endif
    @if(Auth::check() && Auth::user()->role == 1)

    <!-- Setting Dropdown -->
    @php $aboutActive = in_array($currentRoute, ['about.index','about.create','about.missionvission','about.basicsetting']); @endphp
    <div x-data="{ open: @json($aboutActive) }">
        <button @click="open = !open" 
                :class="open ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
                class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">
            <span class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.89 3.31.877 2.42 2.42a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.89 1.543-.877 3.31-2.42 2.42a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.89-3.31-.877-2.42-2.42a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.89-1.543.877-3.31 2.42-2.42.996.574 2.247.12 2.573-1.066z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-transition>Setting</span>
            </span>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('about.basicsetting') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['about.basicsetting']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Basic Setting</span>
            </a>
            <a href="{{ route('about.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['about.create']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- About</span>
            </a>
            <a href="{{ route('about.missionvission') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['about.missionvission']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Mission & Vission</span>
            </a>
            
        </div>
    </div>
    @endif
    @if(Auth::check() && in_array(Auth::user()->role, [1, 2]))
    <!-- Head Menu Dropdown -->
    @php $projectActive = in_array($currentRoute, ['category.index', 'category.create', 'subcategory.index', 'subcategory.create', 'category.edit','expensecategory.index','expensecategory.edit','expensecategory.create']); @endphp
    <div x-data="{ open: @json($projectActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-rose-500 bg-rose-50/30 dark:bg-rose-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-rose-600 text-white' : 'bg-rose-100 text-rose-600 dark:bg-rose-900/50 dark:text-rose-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 1v2m0 18v2m11-11h-2M3 12H1m16.364-7.364l-1.414 1.414M6.05 17.95l-1.414 1.414M17.95 17.95l-1.414-1.414M6.05 6.05L4.636 4.636M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]"
                      :class="open ? 'text-rose-700 dark:text-rose-300' : 'text-gray-700 dark:text-gray-200'">Head</span>
            </div>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-rose-600' : 'text-gray-400'" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" x-cloak x-transition class="px-3 pb-3 space-y-1">
            <a href="{{ route('category.index') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ in_array($currentRoute, ['category.index','category.edit','category.create']) ? 'bg-rose-600 text-white shadow-md' : 'text-gray-600 hover:bg-rose-100 hover:text-rose-700 dark:text-gray-400' }}">
               <span>- Project Category</span>
            </a>
            <a href="{{ route('subcategory.index') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ in_array($currentRoute, ['subcategory.index','subcategory.create']) ? 'bg-rose-600 text-white shadow-md' : 'text-gray-600 hover:bg-rose-100 hover:text-rose-700 dark:text-gray-400' }}">
               <span>- Project Sub Category</span>
            </a>
            <a href="{{ route('expensecategory.index') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ in_array($currentRoute, ['expensecategory.index','expensecategory.edit','expensecategory.create']) ? 'bg-rose-600 text-white shadow-md' : 'text-gray-600 hover:bg-rose-100 hover:text-rose-700 dark:text-gray-400' }}">
               <span>- Expense Category</span>
            </a>
        </div>
    </div>

    <!-- Account info Menu Dropdown -->
    @php $accountActive = in_array($currentRoute, ['account.index', 'account.create', 'account.index']); @endphp
    <div x-data="{ open: @json($accountActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-cyan-500 bg-cyan-50/30 dark:bg-cyan-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-cyan-600 text-white' : 'bg-cyan-100 text-cyan-600 dark:bg-cyan-900/50 dark:text-cyan-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M4 10l8-6 8 6M5 10v10m14-10v10M8 21h8" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]"
                      :class="open ? 'text-cyan-700 dark:text-cyan-300' : 'text-gray-700 dark:text-gray-200'">Account Info</span>
            </div>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-cyan-600' : 'text-gray-400'" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" x-cloak x-transition class="px-3 pb-3 space-y-1">
            <a href="{{ route('account.create') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ in_array($currentRoute, ['account.create']) ? 'bg-cyan-600 text-white shadow-md' : 'text-gray-600 hover:bg-cyan-100 hover:text-cyan-700 dark:text-gray-400' }}">
               <span>- Add New Account</span>
            </a>
            <a href="{{ route('account.index') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ in_array($currentRoute, ['account.index', 'account.edit']) ? 'bg-cyan-600 text-white shadow-md' : 'text-gray-600 hover:bg-cyan-100 hover:text-cyan-700 dark:text-gray-400' }}">
               <span>- Account List</span>
            </a>
        </div>
    </div>

    <!-- Loan Account info Menu Dropdown -->
    {{-- @php $accountActive = in_array($currentRoute, ['loanaccount.index', 'loanaccount.create', 'loanaccount.edit']); @endphp
    <div x-data="{ open: @json($accountActive) }">
        <button @click="open = !open" 
                :class="open ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
                class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">
            <span class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="1.8"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 10h18M4 10l8-6 8 6M5 10v10m14-10v10M8 21h8" />
            </svg>

                <span x-show="!sidebarCollapsed" x-transition>Loan Account</span>
            </span>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('loanaccount.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['loanaccount.create']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Add New</span>
            </a>
            <a href="{{ route('loanaccount.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{  in_array($currentRoute, ['loanaccount.index']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- List</span>
            </a>
        </div>
    </div> --}}
    <!-- Project Dropdown -->
  
@endif
@if(Auth::check() && in_array(Auth::user()->role, [1, 2]))
      @php $projectActive = in_array($currentRoute, ['project.index', 'project.create', 'project.edit', 'project.show','project.completeprojectlist']); @endphp
    <div x-data="{ open: @json($projectActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-amber-500 bg-amber-50/30 dark:bg-amber-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]"
                      :class="open ? 'text-amber-700 dark:text-amber-300' : 'text-gray-700 dark:text-gray-200'">Project</span>
            </div>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-amber-600' : 'text-gray-400'" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" x-cloak x-transition class="px-3 pb-3 space-y-1.5">
            <a href="{{ route('project.create') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all 
               {{ $currentRoute == 'project.create' ? 'bg-amber-600 text-white shadow-md' : 'text-gray-600 hover:bg-amber-100 hover:text-amber-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add New</span>
            </a>

            <a href="{{ route('project.index') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all 
               {{ in_array($currentRoute, ['project.index','project.edit','project.show']) ? 'bg-amber-600 text-white shadow-md' : 'text-gray-600 hover:bg-amber-100 hover:text-amber-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span>Ongoing List</span>
            </a>

            <a href="{{ route('project.completeprojectlist') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all 
               {{ $currentRoute == 'project.completeprojectlist' ? 'bg-amber-600 text-white shadow-md' : 'text-gray-600 hover:bg-amber-100 hover:text-amber-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Complete List</span>
            </a>
        </div>
    </div>
    <!-- Report Menu -->
    @php $reportActive = in_array($currentRoute, ['report.index','report.project-wise',
    'report.member-wise','report.account-wise','report.account-ledger','report.date-wise-account',
    'report.paymethod-wise','report.fiscalyearmember-wise','report.fsyrmember-type-wise','report.fsyrmonth-wise']); @endphp
    <div x-data="{ open: @json($reportActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-slate-500 bg-slate-50/30 dark:bg-slate-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            :class="open 
                ? 'text-slate-800 dark:text-slate-200' 
                : 'text-gray-900 dark:text-gray-200 hover:bg-slate-100 dark:hover:bg-slate-800'"
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">

            <span class="flex items-center space-x-3">
                <div :class="open ? 'bg-slate-700 text-white' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 17v-2a4 4 0 014-4h4M5 12h14M5 8h14M5 16h14M4 21h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v15a1 1 0 001 1z"/>
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]">Report</span>
            </span>

            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-slate-600' : 'text-gray-400'" class="w-5 h-5 transition-transform"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" class="px-3 pb-3 space-y-1" x-cloak x-transition>
            
            <a href="{{ route('report.index') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ $currentRoute == 'report.index' ? 'bg-slate-700 text-white shadow-md' : 'text-gray-600 hover:bg-slate-100 hover:text-slate-800 dark:text-gray-400' }}">
               <span>- Project Wise Ledger</span>
            </a>

            <a href="{{ route('report.account-ledger') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ $currentRoute == 'report.account-ledger' ? 'bg-slate-700 text-white shadow-md' : 'text-gray-600 hover:bg-slate-100 hover:text-slate-800 dark:text-gray-400' }}">
               <span>- Account Wise Ledger</span>
            </a>

            <a href="{{ route('report.date-wise-account') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ $currentRoute == 'report.date-wise-account' ? 'bg-slate-700 text-white shadow-md' : 'text-gray-600 hover:bg-slate-100 hover:text-slate-800 dark:text-gray-400' }}">
               <span>- Date Wise Account</span>
            </a>

            <a href="{{ route('report.account-wise') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ $currentRoute == 'report.account-wise' ? 'bg-slate-700 text-white shadow-md' : 'text-gray-600 hover:bg-slate-100 hover:text-slate-800 dark:text-gray-400' }}">
               <span>- Account Project Ledger</span>
            </a>

            <a href="{{ route('report.paymethod-wise') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ $currentRoute == 'report.paymethod-wise' ? 'bg-slate-700 text-white shadow-md' : 'text-gray-600 hover:bg-slate-100 hover:text-slate-800 dark:text-gray-400' }}">
               <span>- Pay Method Summary</span>
            </a>

            <a href="{{ route('report.project-wise') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ $currentRoute == 'report.project-wise' ? 'bg-slate-700 text-white shadow-md' : 'text-gray-600 hover:bg-slate-100 hover:text-slate-800 dark:text-gray-400' }}">
               <span>- Project Wise Summary</span>
            </a>

            <a href="{{ route('report.member-wise') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ $currentRoute == 'report.member-wise' ? 'bg-slate-700 text-white shadow-md' : 'text-gray-600 hover:bg-slate-100 hover:text-slate-800 dark:text-gray-400' }}">
               <span>- Member Wise Report</span>
            </a>

            <a href="{{ route('report.fiscalyearmember-wise') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ $currentRoute == 'report.fiscalyearmember-wise' ? 'bg-slate-700 text-white shadow-md' : 'text-gray-600 hover:bg-slate-100 hover:text-slate-800 dark:text-gray-400' }}">
               <span>- Fiscal Year Member Wise</span>
            </a>

            <a href="{{ route('report.fsyrmember-type-wise') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ $currentRoute == 'report.fsyrmember-type-wise' ? 'bg-slate-700 text-white shadow-md' : 'text-gray-600 hover:bg-slate-100 hover:text-slate-800 dark:text-gray-400' }}">
               <span>- FY Member Type Wise</span>
            </a>

            <a href="{{ route('report.fsyrmonth-wise') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ $currentRoute == 'report.fsyrmonth-wise' ? 'bg-slate-700 text-white shadow-md' : 'text-gray-600 hover:bg-slate-100 hover:text-slate-800 dark:text-gray-400' }}">
               <span>- Month Wise Report</span>
            </a>

            <a href="{{ route('report.expense-wise') }}" 
               class="flex items-center space-x-2 p-2.5 rounded-xl text-sm font-semibold transition-all
               {{ $currentRoute == 'report.expense-wise' ? 'bg-slate-700 text-white shadow-md' : 'text-gray-600 hover:bg-slate-100 hover:text-slate-800 dark:text-gray-400' }}">
               <span>- Expense Report</span>
            </a>

        </div>
    </div>

     <!-- Member Receipt Menu -->
    @php $mrActive = in_array($currentRoute, ['memberreceipt.index', 'memberreceipt.create','memberreceipt.edit','memberreceipt.memberreceiptpending']); @endphp
    <div x-data="{ open: @json($mrActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-emerald-500 bg-emerald-50/30 dark:bg-emerald-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="relative flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>

                <span x-show="!sidebarCollapsed" 
                      class="font-bold tracking-tight text-[15px] transition-colors"
                      :class="open ? 'text-emerald-700 dark:text-emerald-300' : 'text-gray-700 dark:text-gray-200'">
                    Member Receipt
                </span>
            </div>

            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-emerald-600' : 'text-gray-400'" 
                class="w-5 h-5 transition-transform duration-300"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" 
             x-cloak x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             class="px-3 pb-3 space-y-1.5">
            
            <a href="{{ route('memberreceipt.create') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                      {{ $currentRoute == 'memberreceipt.create' ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 hover:text-emerald-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Add New</span>
            </a>
            
            <a href="{{ route('memberreceipt.index') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                      {{ in_array($currentRoute, ['memberreceipt.index','memberreceipt.edit']) ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 hover:text-emerald-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span>View All List</span>
            </a>

            {{-- Pending List (যদি প্রয়োজন হয়) --}}
            {{-- @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('memberreceipt.memberreceiptpending') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                      {{ $currentRoute == 'memberreceipt.memberreceiptpending' ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 hover:text-emerald-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Pending Approvals</span>
            </a>
            @endif --}}
        </div>
    </div>

    @php $mrActive = in_array($currentRoute, ['moneyreceipt.index', 'moneyreceipt.create', 'moneyreceipt.edit', 'moneyreceipt.moneyreceiptpending']); @endphp
    <div x-data="{ open: @json($mrActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-blue-500 bg-blue-50/30 dark:bg-blue-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="relative flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>

                <span x-show="!sidebarCollapsed" 
                      class="font-bold tracking-tight text-[15px] transition-colors"
                      :class="open ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-200'">
                    Money Receipt
                </span>
            </div>

            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-blue-600' : 'text-gray-400'" 
                class="w-5 h-5 transition-transform duration-300"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" 
             x-cloak x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             class="px-3 pb-3 space-y-1.5">
            
            <a href="{{ route('moneyreceipt.create') }}" 
               class="group/item flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                      {{ $currentRoute == 'moneyreceipt.create' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 hover:text-blue-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Add New</span>
            </a>
            
            <a href="{{ route('moneyreceipt.index') }}" 
               class="group/item flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                      {{ in_array($currentRoute, ['moneyreceipt.index','moneyreceipt.edit']) ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 hover:text-blue-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>View All List</span>
            </a>
        </div>
    </div>


    @php $frActive = in_array($currentRoute, ['falsereceipt.index','falsereceipt.create','falsereceipt.edit']); @endphp
    <div x-data="{ open: @json($frActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-amber-500 bg-amber-50/30 dark:bg-amber-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" 
                      class="font-bold tracking-tight text-[15px] transition-colors"
                      :class="open ? 'text-amber-700 dark:text-amber-300' : 'text-gray-700 dark:text-gray-200'">
                    False Receipt
                </span>
            </div>
            
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-amber-600' : 'text-gray-400'" 
                class="w-5 h-5 transition-transform duration-300"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" 
             x-cloak x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             class="px-3 pb-3 space-y-1.5">
            
            <a href="{{ route('falsereceipt.create') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                      {{ $currentRoute == 'falsereceipt.create' ? 'bg-amber-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-amber-100 dark:hover:bg-amber-900/40 hover:text-amber-700' }}">
               <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
               </svg>
               <span>Add New</span>
            </a>
            
            <a href="{{ route('falsereceipt.index') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                      {{ in_array($currentRoute, ['falsereceipt.index','falsereceipt.edit']) ? 'bg-amber-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-amber-100 dark:hover:bg-amber-900/40 hover:text-amber-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>View All List</span>
            </a>
        </div>
    </div>


    <!-- Project Expense Menu -->
    @php $expenseActive = in_array($currentRoute, ['projectexpense.index', 'projectexpense.create','projectexpense.edit','projectexpense.projectexpensepending']); @endphp
    
    <div x-data="{ open: @json($expenseActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-rose-500 bg-rose-50/30 dark:bg-rose-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-rose-600 text-white' : 'bg-rose-100 text-rose-600 dark:bg-rose-900/50 dark:text-rose-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]"
                      :class="open ? 'text-rose-700 dark:text-rose-300' : 'text-gray-700 dark:text-gray-200'">
                    Project Expense
                </span>
            </div>

            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-rose-600' : 'text-gray-400'" 
                class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" x-cloak x-transition class="px-3 pb-3 space-y-1.5">
            <a href="{{ route('projectexpense.create') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ $currentRoute == 'projectexpense.create' ? 'bg-rose-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-rose-100 dark:hover:bg-rose-900/40 hover:text-rose-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Add New</span>
            </a>
            <a href="{{ route('projectexpense.index') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ in_array($currentRoute, ['projectexpense.index','projectexpense.edit']) ? 'bg-rose-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-rose-100 dark:hover:bg-rose-900/40 hover:text-rose-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h4m-4 4l-4-4m4 4l4-4" />
                </svg>
                <span>View All List</span>
            </a>
        </div>
    </div>


    <!-- Expense Menu -->
    @php $expenseActive = in_array($currentRoute, ['expense.index', 'expense.create','expense.edit','expense.expensepending']); @endphp
    <div x-data="{ open: @json($expenseActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-red-500 bg-red-50/30 dark:bg-red-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-red-600 text-white' : 'bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]"
                      :class="open ? 'text-red-700 dark:text-red-300' : 'text-gray-700 dark:text-gray-200'">
                    Official Expense
                </span>
            </div>

            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-red-600' : 'text-gray-400'" 
                class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" x-cloak x-transition class="px-3 pb-3 space-y-1.5">
            <a href="{{ route('expense.create') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ $currentRoute == 'expense.create' ? 'bg-red-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-red-100 dark:hover:bg-red-900/40 hover:text-red-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Add New</span>
            </a>
            <a href="{{ route('expense.index') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ in_array($currentRoute, ['expense.index','expense.edit']) ? 'bg-red-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-red-100 dark:hover:bg-red-900/40 hover:text-red-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>View All List</span>
            </a>
            </div>
        </div>
  
    <!-- Transfer Menu -->
     @php $mrActive = in_array($currentRoute, ['accbalancetransfer.index', 'accbalancetransfer.create','accbalancetransfer.edit']); @endphp
    <div x-data="{ open: @json($mrActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-purple-500 bg-purple-50/30 dark:bg-purple-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-purple-600 text-white' : 'bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]"
                      :class="open ? 'text-purple-700 dark:text-purple-300' : 'text-gray-700 dark:text-gray-200'">
                    Balance Transfer
                </span>
            </div>

            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-purple-600' : 'text-gray-400'" 
                class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" x-cloak x-transition class="px-3 pb-3 space-y-1.5">
            <a href="{{ route('accbalancetransfer.create') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ $currentRoute == 'accbalancetransfer.create' ? 'bg-purple-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-purple-100 dark:hover:bg-purple-900/40 hover:text-purple-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>New Transfer</span>
            </a>
            <a href="{{ route('accbalancetransfer.index') }}" 
               class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all
                      {{ in_array($currentRoute, ['accbalancetransfer.index','accbalancetransfer.edit']) ? 'bg-purple-600 text-white shadow-md' : 'text-gray-600 dark:text-gray-400 hover:bg-purple-100 dark:hover:bg-purple-900/40 hover:text-purple-700' }}">
                <svg xmlns="http://www.w3.org/2000/xl" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span>Transfer History</span>
            </a>
        </div>
    </div>
    <!-- Loan Account info Menu Dropdown -->
    {{-- @php $accountActive = in_array($currentRoute, ['loan.loanapply', 'loan.loancreate','loan.loanedit','loan.loanpending']); @endphp
    <div x-data="{ open: @json($accountActive) }">
        <button @click="open = !open" 
                :class="open ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
                class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">
            <span class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="1.8"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 10h18M4 10l8-6 8 6M5 10v10m14-10v10M8 21h8" />
            </svg>

                <span x-show="!sidebarCollapsed" x-transition>Loan Apply</span>
            </span>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('loan.loancreate') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['loan.loancreate']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add New</span>
            </a>
            <a href="{{ route('loan.loanapply') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{  in_array($currentRoute, ['loan.loanapply']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- List</span>
            </a>
            @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('loan.loanpending') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'loan.loanpending' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span> Pending List</span>
            </a>
            @endif
        </div>
    </div> --}}

    <!-- Transfer Menu -->
    {{-- @php $mrActive = in_array($currentRoute, ['transfer.index', 'transfer.create','transfer.edit','transfer.transferpending']); @endphp
    <div x-data="{ open: @json($mrActive) }">
        <button @click="open = !open" 
            :class="open 
                ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' 
                : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
            class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">

            <span class="flex items-center space-x-2">
                <!-- Transfer Icon -->
                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 17v-2a4 4 0 014-4h4M5 12h.01M5 16h.01M5 8h.01M17 17h.01M17 13h.01M17 9h.01M4 21h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v15a1 1 0 001 1z"/>
                </svg>

                <span x-show="!sidebarCollapsed" x-transition>Transfer</span>
            </span>

            <!-- Arrow Icon -->
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
             <a href="{{ route('transfer.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'transfer.create' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span> Add New</span>
            </a>
            <a href="{{ route('transfer.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['transfer.index','transfer.edit']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h12M4 10h12M4 14h12M4 18h12" />
                </svg>
                <span>List</span>
            </a>
            @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('transfer.transferpending') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'transfer.transferpending' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span> Pending List</span>
            </a>
            @endif
        </div>
    </div> --}}
      <!-- Gallery Dropdown -->
    @php $galleryActive = in_array($currentRoute, ['gallery.index', 'gallery.create','gallery.edit']); @endphp
    <div x-data="{ open: @json($galleryActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-indigo-500 bg-indigo-50/30 dark:bg-indigo-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-indigo-600 text-white' : 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]"
                      :class="open ? 'text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200'">Gallery</span>
            </div>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-indigo-600' : 'text-gray-400'" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" x-cloak x-transition class="px-3 pb-3 space-y-1.5">
            <a href="{{ route('gallery.create') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ $currentRoute == 'gallery.create' ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <span>Upload Photo</span>
            </a>
            <a href="{{ route('gallery.index') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ in_array($currentRoute, ['gallery.index','gallery.edit']) ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-indigo-100 hover:text-indigo-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                <span>View Albums</span>
            </a>
        </div>
    </div>
    <!-- Member Menu -->
    @php $userActive = in_array($currentRoute, ['member.index', 'member.create','member.edit','member.pendinglist']); @endphp
    <div x-data="{ open: @json($userActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-cyan-500 bg-cyan-50/30 dark:bg-cyan-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-cyan-600 text-white' : 'bg-cyan-100 text-cyan-600 dark:bg-cyan-900/50 dark:text-cyan-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]"
                      :class="open ? 'text-cyan-700 dark:text-cyan-300' : 'text-gray-700 dark:text-gray-200'">Member</span>
            </div>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-cyan-600' : 'text-gray-400'" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" x-cloak x-transition class="px-3 pb-3 space-y-1.5">
            <a href="{{ route('member.create') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ $currentRoute == 'member.create' ? 'bg-cyan-600 text-white shadow-md' : 'text-gray-600 hover:bg-cyan-100 hover:text-cyan-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <span>Add Member</span>
            </a>
            <a href="{{ route('member.index') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ in_array($currentRoute, ['member.index','member.edit']) ? 'bg-cyan-600 text-white shadow-md' : 'text-gray-600 hover:bg-cyan-100 hover:text-cyan-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" /></svg>
                <span>Member List</span>
            </a>
            @if(Auth::check() && Auth::user()->role == 2)
            <a href="{{ route('member.pendinglist') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ $currentRoute == 'member.pendinglist' ? 'bg-cyan-600 text-white shadow-md' : 'text-gray-600 hover:bg-cyan-100 hover:text-cyan-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>Pending Request</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Employee Menu -->
    @php $empActive = in_array($currentRoute, ['employee.index', 'employee.create','employee.edit']); @endphp
    <div x-data="{ open: @json($empActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-sky-500 bg-sky-50/30 dark:bg-sky-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-sky-600 text-white' : 'bg-sky-100 text-sky-600 dark:bg-sky-900/50 dark:text-sky-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]"
                      :class="open ? 'text-sky-700 dark:text-sky-300' : 'text-gray-700 dark:text-gray-200'">Employee Info</span>
            </div>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-sky-600' : 'text-gray-400'" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" x-cloak x-transition class="px-3 pb-3 space-y-1.5">
            <a href="{{ route('employee.create') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ $currentRoute == 'employee.create' ? 'bg-sky-600 text-white' : 'text-gray-600 hover:bg-sky-100 hover:text-sky-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>Hire Employee</span>
            </a>
            <a href="{{ route('employee.index') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ in_array($currentRoute, ['employee.index','employee.edit']) ? 'bg-sky-600 text-white' : 'text-gray-600 hover:bg-sky-100 hover:text-sky-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" /></svg>
                <span>Staff List</span>
            </a>
        </div>
    </div>

    <!-- Salary Menu -->
    @php $empActive = in_array($currentRoute, ['salary.index', 'salary.create','salary.edit','salary.salarypendinglist']); @endphp
    <div x-data="{ open: @json($empActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-emerald-500 bg-emerald-50/30 dark:bg-emerald-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2m-7-4h.01M9 16h.01M9 12h.01M11 12h5M11 16h5" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]"
                      :class="open ? 'text-emerald-700 dark:text-emerald-300' : 'text-gray-700 dark:text-gray-200'">Salary Info</span>
            </div>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-emerald-600' : 'text-gray-400'" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" x-cloak x-transition class="px-3 pb-3 space-y-1.5">
            <a href="{{ route('salary.create') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ $currentRoute == 'salary.create' ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-600 hover:bg-emerald-100 hover:text-emerald-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>Pay Salary</span>
            </a>
            <a href="{{ route('salary.index') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ in_array($currentRoute, ['salary.index','salary.edit']) ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-600 hover:bg-emerald-100 hover:text-emerald-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" /></svg>
                <span>Salary List</span>
            </a>
            @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('salary.salarypendinglist') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ $currentRoute == 'salary.salarypendinglist' ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-600 hover:bg-emerald-100 hover:text-emerald-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>Pending Salary</span>
            </a>
            @endif
        </div>
    </div>

    <!-- User Menu -->
    @php $userActive = in_array($currentRoute, ['user.index', 'user.create','user.edit','user.pendinglist']); @endphp
    <div x-data="{ open: @json($userActive) }" 
         class="group rounded-2xl border transition-all duration-300 shadow-sm"
         :class="open ? 'border-violet-500 bg-violet-50/30 dark:bg-violet-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800'">
        
        <button @click="open = !open" 
            class="flex w-full items-center justify-between p-1.5 rounded-2xl transition-all duration-300">
            
            <div class="flex items-center space-x-3">
                <div :class="open ? 'bg-violet-600 text-white' : 'bg-violet-100 text-violet-600 dark:bg-violet-900/50 dark:text-violet-400'"
                     class="p-2 rounded-xl transition-colors duration-300">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" class="font-bold tracking-tight text-[15px]"
                      :class="open ? 'text-violet-700 dark:text-violet-300' : 'text-gray-700 dark:text-gray-200'">User Settings</span>
            </div>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180 text-violet-600' : 'text-gray-400'" class="w-5 h-5 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open && !sidebarCollapsed" x-cloak x-transition class="px-3 pb-3 space-y-1.5">
            <a href="{{ route('user.create') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ $currentRoute == 'user.create' ? 'bg-violet-600 text-white shadow-md' : 'text-gray-600 hover:bg-violet-100 hover:text-violet-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <span>Create User</span>
            </a>
            <a href="{{ route('user.index') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ in_array($currentRoute, ['user.index','user.edit']) ? 'bg-violet-600 text-white shadow-md' : 'text-gray-600 hover:bg-violet-100 hover:text-violet-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <span>User List</span>
            </a>
            @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('user.pendinglist') }}" class="flex items-center space-x-3 p-2.5 rounded-xl text-sm font-semibold transition-all {{ $currentRoute == 'user.pendinglist' ? 'bg-violet-600 text-white shadow-md' : 'text-gray-600 hover:bg-violet-100 hover:text-violet-700 dark:text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                <span>Pending Access</span>
            </a>
            @endif
        </div>
    </div>

    @endif
    <!-- Users -->
    {{-- <a href="{{ route('user.index') }}" 
       class="flex items-center space-x-2 p-2 rounded-lg text-sm font-medium transition
              {{ $currentRoute == 'user.index' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z"/>
        </svg>
        <span x-show="!sidebarCollapsed" x-transition>Users</span>
    </a> --}}

</nav>
</aside>


<!-- Sidebar (Mobile Drawer) -->
<div x-show="sidebarOpen" class="fixed inset-0 z-40 flex md:hidden" x-cloak>
    <div @click="sidebarOpen=false" class="fixed inset-0 bg-black bg-opacity-50"></div>
    <aside class="relative z-50 w-64 bg-white dark:bg-gray-800 shadow-md h-full flex flex-col transition-transform duration-300">
        <div class="p-6 text-xl font-bold border-b dark:border-gray-700 flex justify-between items-center">
            <!-- Light mode logo -->
    <img src="{{ asset('logo_bgtransparent-sm.png') }}" 
         alt="Ovijatrik" 
         class="w-20 h-11 mx-auto" 
         x-show="!darkMode">

    <!-- Dark mode logo -->
    <img src="{{ asset('logo.png') }}" 
         alt="Ovijatrik" 
         class="w-20 h-11 mx-auto" 
         x-show="darkMode">
            <button @click="sidebarOpen = false" class="text-gray-500 dark:text-gray-300 text-lg">✖</button>
        </div>
       <!-- Navigation -->
        <nav class="p-4 space-y-2 flex-1 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center space-x-2 p-2 rounded-lg 
                      hover:bg-gray-200 dark:hover:bg-gray-700 
                      text-gray-900 dark:text-gray-200 transition-colors">
                 <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/>
                </svg>
                 <span x-show="!sidebarCollapsed" x-transition>Dashboard</span>
            </a>
            <!-- Donar personal history -->
            @if(Auth::check() && Auth::user()->role == 3)
            <!-- Money Receipt -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                    class="flex w-full items-center justify-between p-2 rounded-lg 
                        hover:bg-gray-200 dark:hover:bg-gray-700 
                        text-gray-900 dark:text-gray-200 transition-colors">
                    <span class="flex items-center space-x-2">
                    <!-- Money Receipt Icon -->
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 17v-2a4 4 0 014-4h4M5 12h.01M5 16h.01M5 8h.01M17 17h.01M17 13h.01M17 9h.01M4 21h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v15a1 1 0 001 1z"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition>Donations</span>
                    </span>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="ml-4 space-y-1" x-cloak>
                    <a href="{{ route('mytransaction.index') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Receipts</a>
                    <a href="{{ route('moneyreceipt.create') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Voucher</a>
                    <a href="{{ route('moneyreceipt.moneyreceiptpending') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Report</a>
                </div>
            </div>
            @endif

            @if(Auth::check() && Auth::user()->role == 1)
            <!-- Basic Configure -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                    class="flex w-full items-center justify-between p-2 rounded-lg 
                        hover:bg-gray-200 dark:hover:bg-gray-700 
                        text-gray-900 dark:text-gray-200 transition-colors">
                    <span class="flex items-center space-x-2">
                    <!-- Basic Configure Icon -->
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 1v2m0 18v2m11-11h-2M3 12H1m16.364-7.364l-1.414 1.414M6.05 17.95l-1.414 1.414M17.95 17.95l-1.414-1.414M6.05 6.05L4.636 4.636M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition>Head</span>
                    </span>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="ml-4 space-y-1" x-cloak>
                    <a href="{{ route('category.index') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Category</a>
                    <a href="{{ route('subcategory.index') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Sub Category</a>
                </div>
            </div>

            <!-- Project Dropdown -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                        class="flex w-full items-center justify-between p-2 rounded-lg 
                               hover:bg-gray-200 dark:hover:bg-gray-700 
                               text-gray-900 dark:text-gray-200 transition-colors">
                    <span class="flex items-center space-x-2">
                       <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" 
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 7h18M3 12h18M3 17h18"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition>Project</span>
                    </span>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="ml-4 space-y-1" x-cloak>
                    <a href="{{ route('project.index') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">List</a>
                    <a href="{{ route('project.create') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Add New</a>
                </div>
            </div>

            <!-- Gallery Dropdown -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                        class="flex w-full items-center justify-between p-2 rounded-lg 
                               hover:bg-gray-200 dark:hover:bg-gray-700 
                               text-gray-900 dark:text-gray-200 transition-colors">
                    <span class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" 
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3 8l7 6 4-5 5 4" />
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition>Gallery</span>
                    </span>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="ml-4 space-y-1" x-cloak>
                    <a href="{{ route('gallery.index') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">List</a>
                    <a href="{{ route('gallery.create') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Add New</a>
                </div>
            </div>

            <!-- Money Receipt -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                    class="flex w-full items-center justify-between p-2 rounded-lg 
                        hover:bg-gray-200 dark:hover:bg-gray-700 
                        text-gray-900 dark:text-gray-200 transition-colors">
                    <span class="flex items-center space-x-2">
                    <!-- Money Receipt Icon -->
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 17v-2a4 4 0 014-4h4M5 12h.01M5 16h.01M5 8h.01M17 17h.01M17 13h.01M17 9h.01M4 21h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v15a1 1 0 001 1z"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition>Money Receipt</span>
                    </span>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="ml-4 space-y-1" x-cloak>
                    <a href="{{ route('moneyreceipt.index') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">List</a>
                    <a href="{{ route('moneyreceipt.create') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Add New</a>
                    <a href="{{ route('moneyreceipt.moneyreceiptpending') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Pending List</a>
                </div>
            </div>

            <!-- Expense -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                    class="flex w-full items-center justify-between p-2 rounded-lg 
                        hover:bg-gray-200 dark:hover:bg-gray-700 
                        text-gray-900 dark:text-gray-200 transition-colors">
                    <span class="flex items-center space-x-2">
                    <!-- Expense Icon -->
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12h6m-3-3v6"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition>Expense</span>
                    </span>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="ml-4 space-y-1" x-cloak>
                    <a href="{{ route('expense.index') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">List</a>
                    <a href="{{ route('expense.create') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Add New</a>
                    <a href="{{ route('expense.expensepending') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Pending List</a>
                </div>
            </div>

            <!-- Money Receipt -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                    class="flex w-full items-center justify-between p-2 rounded-lg 
                        hover:bg-gray-200 dark:hover:bg-gray-700 
                        text-gray-900 dark:text-gray-200 transition-colors">
                    <span class="flex items-center space-x-2">
                    <!-- Money Receipt Icon -->
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 17v-2a4 4 0 014-4h4M5 12h.01M5 16h.01M5 8h.01M17 17h.01M17 13h.01M17 9h.01M4 21h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v15a1 1 0 001 1z"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition>Transfer</span>
                    </span>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="ml-4 space-y-1" x-cloak>
                    <a href="{{ route('moneyreceipt.index') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">List</a>
                    <a href="{{ route('moneyreceipt.create') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Add New</a>
                    <a href="{{ route('moneyreceipt.moneyreceiptpending') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Pending List</a>
                </div>
            </div>

            <!-- Users -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                    class="flex w-full items-center justify-between p-2 rounded-lg 
                        hover:bg-gray-200 dark:hover:bg-gray-700 
                        text-gray-900 dark:text-gray-200 transition-colors">
                    <span class="flex items-center space-x-2">
                    <!-- Users Icon -->
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition>Users</span>
                    </span>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="ml-4 space-y-1" x-cloak>
                    <a href="{{ route('user.index') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">List</a>
                    <a href="{{ route('user.create') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Add New</a>
                    <a href="{{ route('user.pendinglist') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Pending List</a>
                </div>
            </div>

            <!-- Report -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                    class="flex w-full items-center justify-between p-2 rounded-lg 
                        hover:bg-gray-200 dark:hover:bg-gray-700 
                        text-gray-900 dark:text-gray-200 transition-colors">
                    <span class="flex items-center space-x-2">
                    <!-- Report Icon -->
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 17v-2a4 4 0 014-4h4M5 12h14M5 8h14M5 16h14M4 21h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v15a1 1 0 001 1z"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition>Report</span>
                    </span>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="ml-4 space-y-1" x-cloak>
                    <a href="{{ route('report.index') }}" 
                       class="block p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 
                              text-gray-900 dark:text-gray-200 transition-colors">Ledger</a>
                </div>
            </div>
            @endif
            <!-- Users -->
            {{-- <a href="{{ route('user.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-lg 
                      hover:bg-gray-200 dark:hover:bg-gray-700 
                      text-gray-900 dark:text-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" 
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition>Users</span>
            </a> --}}
        </nav>
    </aside>
  
</div>
