<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ovijatrik Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon / Tab Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
<!-- toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- @vite('resources/css/app.css') --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans transition-colors duration-300"
      x-data="{ sidebarOpen: false, sidebarCollapsed: false, darkMode: false, pageLoading: true }"
      :class="{'dark bg-gray-900 ': darkMode, 'bg-gray-200 text-gray-900': !darkMode}"
      x-init="
          setTimeout(() => pageLoading = false, 1200);
          darkMode = localStorage.getItem('darkMode') === 'true' || false;
          $watch('darkMode', value => localStorage.setItem('darkMode', value));
      "
>

    <!-- Loader Overlay -->
    <div x-show="pageLoading" 
         class="fixed inset-0 bg-white flex items-center justify-center z-50"
         x-transition.opacity>
        <!-- Loader Animation -->
        <div class="flex flex-col items-center">
            <svg class="animate-spin h-12 w-12 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            <p class="mt-4 text-gray-600 font-medium">Loading ...</p>
        </div>
    </div>

    <div x-data="{ sidebarOpen: false, sidebarCollapsed: false }" class="flex h-screen">

        {{-- Sidebar --}}
        <aside 
            :class="sidebarCollapsed ? 'w-16' : 'w-64'" 
            class="hidden md:flex md:flex-col bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 shadow-md transition-all duration-300">
            @include('layouts.sidebarnew')
        

        <!-- Main content -->
        <div class="flex-1 flex flex-col">

           <!-- Header -->
        
           <header class="flex justify-between items-center px-6 py-2 shadow-md transition-colors duration-300"
        :class="darkMode ? 'bg-gray-800 text-white' : 'bg-white text-gray-900'">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = true" class="md:hidden text-gray-600">
                    ☰
                </button>

                <!-- Collapse button (Desktop only) -->
                <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden md:block text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Right side user menu -->
                <div class="flex items-center space-x-4">
                  <!-- Dark / Light mode toggle -->
                <button @click="darkMode = !darkMode" 
                        class="ml-4 p-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    <span x-show="!darkMode">🌞</span>
                    <span x-show="darkMode">🌙</span>
                </button>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="focus:outline-none">
                        <img src="{{ asset('profile_user.png')}}"  
                             alt="{{(Auth::user()->name ?? 'Guest') }}" class="w-10 h-10 rounded-full border">
                    </button>

                   <!-- Dropdown -->
                    <div x-show="open" @click.away="open=false"
                        x-transition
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg shadow-lg py-2 z-50"
                        x-cloak>
                        
                        <div class="px-4 py-2 border-b text-sm text-gray-600 dark:text-gray-300 dark:border-gray-700">
                            {{ Auth::user()->name ?? 'Guest' }}
                        </div>
                        
                        <a href="{{ route('profile.edit') }}" 
                        class="block px-4 py-2 text-sm text-gray-900 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition-colors">
                        ✏️ Edit Profile
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-2 text-sm text-gray-900 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition-colors">
                                🚪 Logout
                            </button>
                        </form>
                    </div>

                </div>
                </div>
            </header>


            <!-- Page content -->
            <main class="flex-1 p-3 overflow-y-auto transition-colors duration-300">
                @yield('content')
            </main>
            {{-- @include('layouts.footer') --}}
        </div>
    </div>

    <!-- Alpine.js for toggle -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')
</body>
</html>
