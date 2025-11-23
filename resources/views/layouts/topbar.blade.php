 <!-- Topbar -->
    <nav class="flex items-center justify-between bg-white text-gray-800 dark:bg-gray-900 dark:text-gray-100 px-4 py-2 shadow">
      <div class="flex items-center space-x-4">
         <button id="sidebarToggle" class="text-gray-600 hover:text-gray-900 md:block">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M4 6h16M4 12h16M4 18h16"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2">
          </path>
        </svg>
      </button>
        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900">Home</a>
      </div>
      <div class="flex items-center space-x-4">
      
        <div class="relative">
          <button class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 8h10M7 12h8m-5 8h-2a2 2 0 01-2-2v-4a2 2 0 012-2h2m0 0h2a2 2 0 012 2v4a2 2 0 01-2 2h-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            
              <span class="absolute top-0 right-0 inline-block w-2 h-2 rounded-full bg-red-600"></span>
            
          </button>
          <div class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded hidden group-hover:block"
               x-data="{ open: false }">
            <!-- dropdown with messages -->
              <div class="border-t">
                <a href="#" class="block px-4 py-2 text-center text-blue-600 hover:bg-gray-100">See All Messages</a>
              </div>
           
          </div>
        </div>
        <!-- Dark/Light Mode Toggle -->
      <button id="themeToggle" class="text-gray-600 hover:text-gray-900 focus:outline-none">
        <svg id="themeToggleIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <!-- Initial icon will be updated via JS -->
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v1m0 16v1m8.66-11.66l-.71.71M4.05 19.95l-.71-.71m16.97 0l-.71.71M4.05 4.05l.71.71M21 12h1M2 12H1"/>
        </svg>
      </button>

        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
          <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
          </form>
          
        <!-- Profile -->
        <div class="relative group">
          {{-- <button class="flex items-center space-x-2 text-gray-600 hover:text-gray-900">
            <span>{{ Auth::user()->name }}</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
          </button>
          <div class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded hidden group-hover:block">
            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
            </form>
          </div> --}}
        </div>
      </div>
    </nav>

    <script>
  // document.getElementById('sidebarToggle').addEventListener('click', function () {
  //   const sidebar = document.getElementById('sidebar');
  //   sidebar.classList.toggle('-translate-x-full');
  // });

  // Dark Mode Toggle
  const themeToggle = document.getElementById('themeToggle');
  const html = document.documentElement;
  const icon = document.getElementById('themeToggleIcon');

  // Load saved theme
  if (localStorage.getItem('theme') === 'dark' ||
      (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    html.classList.add('dark');
    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-11.66l-.71.71M4.05 19.95l-.71-.71m16.97 0l-.71.71M4.05 4.05l.71.71M21 12h1M2 12H1"/>';
  } else {
    html.classList.remove('dark');
    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.293 14.707a8 8 0 01-11.314-11.314 8.003 8.003 0 0011.314 11.314z"/>';
  }

  // Toggle theme
  themeToggle.addEventListener('click', function () {
    if (html.classList.contains('dark')) {
      html.classList.remove('dark');
      localStorage.setItem('theme', 'light');
      icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.293 14.707a8 8 0 01-11.314-11.314 8.003 8.003 0 0011.314 11.314z"/>';
    } else {
      html.classList.add('dark');
      localStorage.setItem('theme', 'dark');
      icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-11.66l-.71.71M4.05 19.95l-.71-.71m16.97 0l-.71.71M4.05 4.05l.71.71M21 12h1M2 12H1"/>';
    }
  });
</script>
