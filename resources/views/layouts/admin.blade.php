<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
<!-- toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
 <body
    x-data="{ page: 'admin', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >

   <div class="flex min-h-screen bg-gray-100">
 @include('layouts.sidebar')

  <!-- Main content area -->
  <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
   @include('layouts.topbar')

    <!-- Content -->
    <main class="flex-1 overflow-auto p-4">
      @yield('content')
    </main>

    @include('layouts.footer')
  </div>
</div>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('scripts')

<script>
 
  // Sidebar submenu toggle
  function toggleMenu(id) {
    const submenu = document.getElementById(id);
    const icon = document.getElementById('icon-' + id);
    submenu.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
  }

  // Sidebar toggle for both mobile and desktop
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');

  sidebarToggle.addEventListener('click', function () {
    if (window.innerWidth < 768) {
      // For mobile - slide sidebar in/out
      sidebar.classList.toggle('-translate-x-full');
    } else {
      // For desktop - collapse/expand
      sidebar.classList.toggle('w-64');
      sidebar.classList.toggle('w-20');

      // Toggle labels visibility
      document.querySelectorAll('.sidebar-label').forEach(el => {
        el.classList.toggle('hidden');
      });
    }
  });
</script>

</body>
</html>
