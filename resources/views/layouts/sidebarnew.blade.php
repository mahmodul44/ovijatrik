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
    @php $aboutActive = in_array($currentRoute, ['about.index','about.create','about.missionvission']); @endphp
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
    <!-- Head Menu Dropdown -->
    @php $projectActive = in_array($currentRoute, ['category.index', 'category.create', 'subcategory.index', 'subcategory.create', 'category.edit','expensecategory.index','expensecategory.edit','expensecategory.create']); @endphp
    <div x-data="{ open: @json($projectActive) }">
        <button @click="open = !open" 
                :class="open ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
                class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">
            <span class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 1v2m0 18v2m11-11h-2M3 12H1m16.364-7.364l-1.414 1.414M6.05 17.95l-1.414 1.414M17.95 17.95l-1.414-1.414M6.05 6.05L4.636 4.636M12 8a4 4 0 100 8 4 4 0 000-8z"/>
            </svg>

                <span x-show="!sidebarCollapsed" x-transition>Head</span>
            </span>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('category.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['category.index','category.edit','category.create']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Project Category</span>
            </a>
            <a href="{{ route('subcategory.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{  in_array($currentRoute, ['subcategory.index','subcategory.create']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Project Sub Category</span>
            </a>
            <a href="{{ route('expensecategory.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['expensecategory.index','expensecategory.edit','expensecategory.create']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Expense Category</span>
            </a>
        </div>
    </div>

    <!-- Account info Menu Dropdown -->
    @php $accountActive = in_array($currentRoute, ['account.index', 'account.create', 'account.index']); @endphp
    <div x-data="{ open: @json($accountActive) }">
        <button @click="open = !open" 
                :class="open ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
                class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">
            <span class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 1v2m0 18v2m11-11h-2M3 12H1m16.364-7.364l-1.414 1.414M6.05 17.95l-1.414 1.414M17.95 17.95l-1.414-1.414M6.05 6.05L4.636 4.636M12 8a4 4 0 100 8 4 4 0 000-8z"/>
            </svg>
                <span x-show="!sidebarCollapsed" x-transition>Account Info</span>
            </span>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('account.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['account.create']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Add New</span>
            </a>
            <a href="{{ route('account.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{  in_array($currentRoute, ['account.index']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- List</span>
            </a>
        </div>
    </div>

    <!-- Project Dropdown -->
    @php $projectActive = in_array($currentRoute, ['project.index', 'project.create', 'project.edit', 'project.show','project.completeprojectlist']); @endphp
    <div x-data="{ open: @json($projectActive) }">
        <button @click="open = !open" 
                :class="open ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
                class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">
            <span class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition>Project</span>
            </span>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
             <a href="{{ route('project.create') }}" 
            class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                    {{ $currentRoute == 'project.create' 
                        ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' 
                        : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add New</span>
            </a>
            <!-- Ongoing List -->
    <a href="{{ route('project.index') }}" 
       class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
              {{ in_array($currentRoute, ['project.index','project.edit','project.show']) 
                 ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' 
                 : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
        </svg>
        <span>Ongoing List</span>
    </a>

    <!-- Complete List -->
    <a href="{{ route('project.completeprojectlist') }}" 
       class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
              {{ in_array($currentRoute, ['project.completeprojectlist']) 
                 ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' 
                 : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <span>Complete List</span>
    </a>
        </div>
    </div>
@endif
@if(Auth::check() && in_array(Auth::user()->role, [1, 2]))
    <!-- Gallery Dropdown -->
    @php $galleryActive = in_array($currentRoute, ['gallery.index', 'gallery.create','gallery.edit']); @endphp
    <div x-data="{ open: @json($galleryActive) }">
        <button @click="open = !open" 
                :class="open ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
                class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">
            <span class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7 6 4-5 5 4"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition>Gallery</span>
            </span>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('gallery.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'gallery.create' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add New</span>
            </a>
            <a href="{{ route('gallery.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['gallery.index','gallery.edit']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                </svg>
                <span>List</span>
            </a>
            
        </div>
    </div>

     <!-- Member Receipt Menu -->
    @php $mrActive = in_array($currentRoute, ['memberreceipt.index', 'memberreceipt.create','memberreceipt.edit','memberreceipt.memberreceiptpending']); @endphp
    <div x-data="{ open: @json($mrActive) }">
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

                <span x-show="!sidebarCollapsed" x-transition>Member Receipt</span>
            </span>

            <!-- Arrow Icon -->
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('memberreceipt.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'memberreceipt.create' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span> Add New</span>
            </a>
            <a href="{{ route('memberreceipt.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['memberreceipt.index','memberreceipt.edit']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                </svg>
                <span> List</span>
            </a>
            
            @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('memberreceipt.memberreceiptpending') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'memberreceipt.memberreceiptpending' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span> Pending List</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Money Receipt Menu -->
    @php $mrActive = in_array($currentRoute, ['moneyreceipt.index', 'moneyreceipt.create','moneyreceipt.edit','moneyreceipt.moneyreceiptpending']); @endphp
    <div x-data="{ open: @json($mrActive) }">
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

                <span x-show="!sidebarCollapsed" x-transition>Money Receipt</span>
            </span>

            <!-- Arrow Icon -->
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('moneyreceipt.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'moneyreceipt.create' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            <span> Add New</span>
            </a>
            
            <a href="{{ route('moneyreceipt.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['moneyreceipt.index','moneyreceipt.edit']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h12M4 10h12M4 14h12M4 18h12" />
                </svg>
                <span>List</span>
            </a>
           
            @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('moneyreceipt.moneyreceiptpending') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'moneyreceipt.moneyreceiptpending' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span> Pending List</span>
            </a>
            @endif
        </div>
    </div>


    <!-- False Money Receipt Menu -->
    @php $mrActive = in_array($currentRoute, ['falsereceipt.index','falsereceipt.create']); @endphp
    <div x-data="{ open: @json($mrActive) }">
        <button @click="open = !open" 
            :class="open 
                ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' 
                : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
            class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">
            <span class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 17v-2a4 4 0 014-4h4M5 12h.01M5 16h.01M5 8h.01M17 17h.01M17 13h.01M17 9h.01M4 21h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v15a1 1 0 001 1z"/>
                </svg>
                <span x-show="!sidebarCollapsed" x-transition>False Receipt</span>
            </span>
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('falsereceipt.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'falsereceipt.create' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 4.5v15m7.5-7.5h-15" />
             </svg>
                <span> Add New</span>
            </a>
            <a href="{{ route('falsereceipt.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['falsereceipt.index','falsereceipt.edit']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h12M4 10h12M4 14h12M4 18h12" />
                </svg>
                    <span> List</span>
            </a>
            
        </div>
    </div>

    <!-- Project Expense Menu -->
    @php $expenseActive = in_array($currentRoute, ['projectexpense.index', 'projectexpense.create','projectexpense.edit','projectexpense.projectexpensepending']); @endphp
    <div x-data="{ open: @json($expenseActive) }">
        <button @click="open = !open" 
        :class="open 
        ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' 
        : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
        class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">

        <span class="flex items-center space-x-2">
        <!-- Expense Icon -->
        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12h6m-3-3v6"/>
        </svg>
        <span x-show="!sidebarCollapsed" x-transition>Project Expense</span>
        </span>

        <!-- Arrow Icon -->
        <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('projectexpense.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'projectexpense.create' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            <span> Add New</span>
            </a>
            <a href="{{ route('projectexpense.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['projectexpense.index','projectexpense.edit']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h12M4 10h12M4 14h12M4 18h12" />
                </svg>
                <span> List</span>
            </a>
            @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('projectexpense.projectexpensepending') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'projectexpense.projectexpensepending' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Pending List</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Expense Menu -->
    @php $expenseActive = in_array($currentRoute, ['expense.index', 'expense.create','expense.edit','expense.expensepending']); @endphp
    <div x-data="{ open: @json($expenseActive) }">
        <button @click="open = !open" 
        :class="open 
        ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' 
        : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
        class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">

        <span class="flex items-center space-x-2">
        <!-- Expense Icon -->
        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12h6m-3-3v6"/>
        </svg>
        <span x-show="!sidebarCollapsed" x-transition>Expense</span>
        </span>

        <!-- Arrow Icon -->
        <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('expense.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'expense.create' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add New</span>
            </a>
            <a href="{{ route('expense.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['expense.index','expense.edit']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h12M4 10h12M4 14h12M4 18h12" />
                </svg>
                <span> List</span>
            </a>
            
            @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('expense.expensepending') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'expense.expensepending' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span> Pending List</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Transfer Menu -->
    @php $mrActive = in_array($currentRoute, ['transfer.index', 'transfer.create','transfer.edit','transfer.transferpending']); @endphp
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
    </div>

    <!-- Member Menu -->
    @php $userActive = in_array($currentRoute, ['member.index', 'member.create','member.edit','member.pendinglist']); @endphp
    <div x-data="{ open: @json($userActive) }">
        <button @click="open = !open" 
        :class="open 
        ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' 
        : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
        class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">

        <span class="flex items-center space-x-2">
        <!-- Member Icon -->
        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z"/>
        </svg>
        <span x-show="!sidebarCollapsed" x-transition>Member</span>
        </span>

        <!-- Arrow Icon -->
        <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('member.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'member.create' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span> Add New</span>
            </a>
            <a href="{{ route('member.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['member.index','member.edit']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h12M4 10h12M4 14h12M4 18h12" />
                </svg>
                <span>List</span>
            </a>
            
            @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('member.pendinglist') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'member.pendinglist' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Pending List</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Employee Menu -->
    @php $empActive = in_array($currentRoute, ['employee.index', 'employee.create','employee.edit']); @endphp
    <div x-data="{ open: @json($empActive) }">
        <button @click="open = !open" 
        :class="open 
        ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' 
        : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
        class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">

        <span class="flex items-center space-x-2">
        <!-- Member Icon -->
        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z"/>
        </svg>
        <span x-show="!sidebarCollapsed" x-transition>Employee Info</span>
        </span>

        <!-- Arrow Icon -->
        <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            
            <a href="{{ route('employee.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'employee.create' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add New</span>
            </a>
            <a href="{{ route('employee.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['employee.index','employee.edit']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h12M4 10h12M4 14h12M4 18h12" />
                </svg>
                <span>List</span>
            </a>
        </div>
    </div>

    <!-- Salary Menu -->
    @php $empActive = in_array($currentRoute, ['salary.index', 'salary.create','salary.edit','salary.pendinglist']); @endphp
    <div x-data="{ open: @json($empActive) }">
        <button @click="open = !open" 
        :class="open 
        ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' 
        : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
        class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">

        <span class="flex items-center space-x-2">
        <!-- Member Icon -->
        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z"/>
        </svg>
        <span x-show="!sidebarCollapsed" x-transition>Salary Info</span>
        </span>

        <!-- Arrow Icon -->
        <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            
            <a href="{{ route('salary.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'salary.create' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add New</span>
            </a>
            <a href="{{ route('salary.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['salary.index','salary.edit']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h12M4 10h12M4 14h12M4 18h12" />
                </svg>
                <span>List</span>
            </a>
             @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('salary.salarypendinglist') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'salary.salarypendinglist' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Pending List</span>
            </a>
            @endif
        </div>
    </div>

    <!-- User Menu -->
    @php $userActive = in_array($currentRoute, ['user.index', 'user.create','user.edit','user.pendinglist']); @endphp
    <div x-data="{ open: @json($userActive) }">
        <button @click="open = !open" 
        :class="open 
        ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' 
        : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
        class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">

        <span class="flex items-center space-x-2">
        <!-- Users Icon -->
        <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z"/>
        </svg>
        <span x-show="!sidebarCollapsed" x-transition>User</span>
        </span>

        <!-- Arrow Icon -->
        <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        </button>

        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('user.create') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'user.create' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span> Add New</span>
            </a>
            <a href="{{ route('user.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ in_array($currentRoute, ['user.index','user.edit']) ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h12M4 10h12M4 14h12M4 18h12" />
                </svg>
                <span>List</span>
            </a>
            @if(Auth::check() && Auth::user()->role == 1)
            <a href="{{ route('user.pendinglist') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'user.pendinglist' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Pending List</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Report Menu -->
    @php $reportActive = in_array($currentRoute, ['report.index','report.project-wise','report.member-wise']); @endphp
    <div x-data="{ open: @json($reportActive) }">
        <button @click="open = !open" 
            :class="open 
                ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 dark:from-blue-900 dark:to-blue-800 dark:text-blue-200' 
                : 'text-gray-900 dark:text-gray-200 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white'"
            class="flex w-full items-center justify-between p-2 rounded-lg transition-colors">

                <span class="flex items-center space-x-2">
                <!-- Report Icon -->
                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 17v-2a4 4 0 014-4h4M5 12h14M5 8h14M5 16h14M4 21h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v15a1 1 0 001 1z"/>
                </svg>

                <span x-show="!sidebarCollapsed" x-transition>Report</span>
            </span>

            <!-- Arrow Icon -->
            <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <!-- Submenu -->
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('report.index') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'report.index' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Ledger</span>
            </a>
        </div>
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('report.project-wise') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'report.project-wise' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Project Wise</span>
            </a>
        </div>
        <div x-show="open && !sidebarCollapsed" class="ml-6 space-y-1" x-cloak>
            <a href="{{ route('report.member-wise') }}" 
               class="flex items-center space-x-2 p-2 rounded-md text-sm font-medium transition
                      {{ $currentRoute == 'report.member-wise' ? 'bg-gradient-to-r from-blue-400 to-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-blue-100 hover:to-blue-200 dark:hover:from-blue-800 dark:hover:to-blue-900 hover:text-white' }}">
               <span>- Member Wise</span>
            </a>
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
