<!-- Mobile Toggle Button -->
<div class="md:hidden flex justify-between items-center p-4 bg-white shadow">
  <div class="font-bold text-lg text-gray-800">Admin</div>
  <button id="sidebarToggleBtn" onclick="toggleSidebar()" class="text-gray-700 focus:outline-none">
    <!-- Hamburger Icon -->
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
  </button>
</div>

<div class="flex">
<!-- Sidebar -->
<aside id="sidebar" class="fixed md:relative top-0 left-0 w-64 h-full bg-white text-gray-800 dark:bg-gray-800 dark:text-gray-100 border-r transition-transform duration-300 ease-in-out z-50 -translate-x-full md:translate-x-0">
  <div class="h-16 flex items-center justify-center font-bold text-lg">
    Admin Panel
  </div>
  <div class="flex items-center p-4 space-x-3">
    <img src="{{ asset('img/avatar5.png') }}" class="w-10 h-10 rounded-full object-cover" alt="User">
    <span class="sidebar-label text-sm">{{ Auth::user()->name }}</span>
  </div>

  @php
    $current = request()->route()->getName();
  @endphp

  <nav class="flex-1 px-2 space-y-2">
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center px-3 py-2 rounded hover:bg-gray-400 {{ $current == 'admin.dashboard' ? 'bg-gray-300' : '' }}">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
      </svg>
     <span class="sidebar-label"> Dashboard</span>
    </a>
     @if(Auth::check() && Auth::user()->role == 1)
    <!-- Company -->
    @php $configureActive = Request::is('admin/configure*'); @endphp
    <div>
      <button class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-400 {{ $configureActive ? 'bg-gray-300' : '' }}"
              onclick="toggleMenu('configureSub')">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5.121 17.804A3 3 0 005 21h14a3 3 0 00.879-5.196M15 12h.01M11 12h.01M7 12h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
       <span class="sidebar-label"> Configure</span>
        <svg class="w-4 h-4 ml-auto transform transition-transform {{ $configureActive ? 'rotate-180' : '' }}" id="icon-configureSub" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
      </button>
      <div class="space-y-1 pl-12 mt-1 {{ $configureActive ? '' : 'hidden' }}" id="configureSub">
        <a href="{{ route('category.index') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'category.index' ? 'bg-gray-400' : '' }}">Category</a>
           <a href="{{ route('subcategory.index') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'subcategory.index' ? 'bg-gray-400' : '' }}">Sub Category</a>
      </div>
    </div>

    <!-- About -->
    @php $aboutActive = Request::is('admin/about*'); @endphp
    <div>
      <button class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-400 {{ $aboutActive ? 'bg-gray-300' : '' }}"
              onclick="toggleMenu('aboutsub')">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4v6h6M20 20v-6h-6M4 20l16-16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        <span class="sidebar-label">About</span>
        <svg class="w-4 h-4 ml-auto transform transition-transform {{ $aboutActive ? 'rotate-180' : '' }}" id="icon-aboutsub" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></path></svg>
      </button>
      <div class="space-y-1 pl-12 mt-1 {{ $aboutActive ? '' : 'hidden' }}" id="aboutsub">
        <a href="{{ route('about.create') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'about.create' ? 'bg-gray-400' : '' }}">Add</a>
      </div>
    </div>

    <!-- Slider -->
    @php $sliderActive = Request::is('admin/slider*'); @endphp
    <div>
      <button class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-400 {{ $sliderActive ? 'bg-gray-300' : '' }}"
              onclick="toggleMenu('sliderSub')">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h8m-8 6h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
       <span class="sidebar-label"> Slider</span>
        <svg class="w-4 h-4 ml-auto transform transition-transform {{ $sliderActive ? 'rotate-180' : '' }}" id="icon-sliderSub" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
      </button>
      <div class="space-y-1 pl-12 mt-1 {{ $sliderActive ? '' : 'hidden' }}" id="sliderSub">
        <a href="#"
           class="block px-2 py-1 rounded hover:bg-gray-400">Create</a>
        <a href="#"
           class="block px-2 py-1 rounded hover:bg-gray-400">List</a>
      </div>
    </div>
    @endif
    @if(Auth::check() && Auth::user()->role == 3)
      <!-- my transaction -->
    @php $mytransActive = Request::is('admin/my-transaction*'); @endphp
    <div>
      <button class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-400 {{ $mytransActive ? 'bg-gray-300' : '' }}"
              onclick="toggleMenu('mytranssub')">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4v6h6M20 20v-6h-6M4 20l16-16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        <span class="sidebar-label">My Transaction</span>
        <svg class="w-4 h-4 ml-auto transform transition-transform {{ $mytransActive ? 'rotate-180' : '' }}" id="icon-aboutsub" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></path></svg>
      </button>
      <div class="space-y-1 pl-12 mt-1 {{ $mytransActive ? '' : 'hidden' }}" id="mytranssub">
        <a href="{{ route('mytransaction.index') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'mytransaction.index' ? 'bg-gray-400' : '' }}">List</a>
      </div>
    </div>
    @endif
     @if(Auth::check() && Auth::user()->role == 1)
    <!-- Gallery -->
    @php $galleryActive = Request::is('admin/gallery*'); @endphp
    <div>
      <button class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-400 {{ $galleryActive ? 'bg-gray-300' : '' }}"
              onclick="toggleMenu('gallerySub')">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h8m-8 6h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
      <span class="sidebar-label">Gallery</span>
        <svg class="w-4 h-4 ml-auto transform transition-transform {{ $galleryActive ? 'rotate-180' : '' }}" id="icon-gallerySub" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
      </button>
      <div class="space-y-1 pl-12 mt-1 {{ $galleryActive ? '' : 'hidden' }}" id="gallerySub">
        <a href="{{ route('gallery.create') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'gallery.create' ? 'bg-gray-400' : '' }}">
          Create
        </a>
        <a href="{{ route('gallery.index') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'gallery.index' ? 'bg-gray-400' : '' }}">
          List
        </a>
      </div>
    </div>

     @php $projectActive = Request::is('admin/project*'); @endphp
    <div>
      <button class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-400 {{ $projectActive ? 'bg-gray-300' : '' }}"
              onclick="toggleMenu('projectSub')">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h8m-8 6h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         <span class="sidebar-label">Project</span>
        <svg class="w-4 h-4 ml-auto transform transition-transform {{ $projectActive ? 'rotate-180' : '' }}" id="icon-projectSub" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
      </button>
      <div class="space-y-1 pl-12 mt-1 {{ $projectActive ? '' : 'hidden' }}" id="projectSub">
        <a href="{{ route('project.create') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'project.create' ? 'bg-gray-400' : '' }}">
          Create
        </a>
        <a href="{{ route('project.index') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'project.index' ? 'bg-gray-400' : '' }}">
          List
        </a>
      </div>
    </div>

    @php $moneyReceiptActive = Request::is('admin/moneyreceipt*'); @endphp
    <div>
      <button class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-400 {{ $moneyReceiptActive ? 'bg-gray-300' : '' }}"
              onclick="toggleMenu('moneyreceiptSub')">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h8m-8 6h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         <span class="sidebar-label">Money Receipt</span>
        <svg class="w-4 h-4 ml-auto transform transition-transform {{ $moneyReceiptActive ? 'rotate-180' : '' }}" id="icon-projectSub" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
      </button>
      <div class="space-y-1 pl-12 mt-1 {{ $moneyReceiptActive ? '' : 'hidden' }}" id="moneyreceiptSub">
        <a href="{{ route('moneyreceipt.create') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'moneyreceipt.create' ? 'bg-gray-400' : '' }}">
          Create
        </a>
        <a href="{{ route('moneyreceipt.index') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'moneyreceipt.index' ? 'bg-gray-400' : '' }}">
          List
        </a>
         <a href="{{ route('moneyreceipt.moneyreceiptpending') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'moneyreceipt.moneyreceiptpending' ? 'bg-gray-400' : '' }}">
           Pending List
        </a>
      </div>
    </div>

     @php $expenseActive = Request::is('admin/expense*'); @endphp
    <div>
      <button class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-400 {{ $expenseActive ? 'bg-gray-300' : '' }}"
              onclick="toggleMenu('expenseSub')">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h8m-8 6h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         <span class="sidebar-label">Expense</span>
        <svg class="w-4 h-4 ml-auto transform transition-transform {{ $expenseActive ? 'rotate-180' : '' }}" id="icon-expenseSub" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
      </button>
      <div class="space-y-1 pl-12 mt-1 {{ $expenseActive ? '' : 'hidden' }}" id="expenseSub">
        <a href="{{ route('expense.create') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'expense.create' ? 'bg-gray-400' : '' }}">
          Create
        </a>
        <a href="{{ route('expense.index') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'expense.index' ? 'bg-gray-400' : '' }}">
          List
        </a>
         <a href="{{ route('expense.expensepending') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'expense.expensepending' ? 'bg-gray-400' : '' }}">
          Expense Pending List
        </a>
      </div>
    </div>

    @php $userActive = Request::is('admin/user*'); @endphp
    <div>
      <button class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-400 {{ $userActive ? 'bg-gray-300' : '' }}"
              onclick="toggleMenu('userSub')">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h8m-8 6h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         <span class="sidebar-label">User</span>
        <svg class="w-4 h-4 ml-auto transform transition-transform {{ $userActive ? 'rotate-180' : '' }}" id="icon-expenseSub" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
      </button>
      <div class="space-y-1 pl-12 mt-1 {{ $userActive ? '' : 'hidden' }}" id="userSub">
        <a href="{{ route('user.create') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'user.create' ? 'bg-gray-400' : '' }}">
          Create
        </a>
        <a href="{{ route('user.index') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'user.index' ? 'bg-gray-400' : '' }}">
          List
        </a>
        <a href="{{ route('user.pendinglist') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'user.pendinglist' ? 'bg-gray-400' : '' }}">
          Pending List
        </a>
      </div>
    </div>

    @php $reportActive = Request::is('admin/report*'); @endphp
    <div>
      <button class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-400 {{ $reportActive ? 'bg-gray-300' : '' }}"
              onclick="toggleMenu('reportSub')">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h8m-8 6h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
         <span class="sidebar-label">Report</span>
        <svg class="w-4 h-4 ml-auto transform transition-transform {{ $reportActive ? 'rotate-180' : '' }}" id="icon-expenseSub" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
      </button>
      <div class="space-y-1 pl-12 mt-1 {{ $reportActive ? '' : 'hidden' }}" id="reportSub">
        <a href="{{ route('report.index') }}"
           class="block px-2 py-1 rounded hover:bg-gray-400 {{ $current == 'report.index' ? 'bg-gray-400' : '' }}">
          Ledger
        </a>
      </div>
    </div>
    @endif
  </nav>
</aside>
</div>

@section('script')
<script>
  function toggleMenu(id) {
    const submenu = document.getElementById(id);
    const icon = document.getElementById('icon-' + id);
    submenu.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
  }

   function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
    sidebar.classList.toggle('translate-x-0');
  }
</script>
@endsection
