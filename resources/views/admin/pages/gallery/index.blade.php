@extends('layouts.main')
@section('content')
<div class="p-5 max-w-7xl mx-auto font-sans transition-all duration-300 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <!-- Title -->
        <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" 
                class="w-7 h-7 text-blue-600 dark:text-blue-400" 
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 7l9 6 9-6-9-6-9 6z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M21 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7" />
            </svg>
            <h2 class="text-2xl font-bold tracking-tight">Gallery List</h2>
        </div>

        <!-- Add Button -->
        <a href="{{ route('gallery.create') }}" 
           class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-lg shadow-md 
                  bg-gradient-to-r from-blue-600 to-indigo-600 text-white 
                  hover:from-blue-700 hover:to-indigo-700 
                  focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 4v16m8-8H4" />
            </svg>
            Add New
        </a>
    </div>

    <!-- Breadcrumb -->
    <nav class="text-sm mb-4 text-gray-500 dark:text-gray-400">
        <ol class="flex space-x-2">
            <li><a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Dashboard</a></li>
            <li>/</li>
            <li class="text-gray-700 dark:text-gray-300">Gallery List</li>
        </ol>
    </nav>

    <!-- Gallery Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-x-auto border border-gray-200 dark:border-gray-700">
        <table id="galleryTable" class="min-w-full table-auto text-sm">
            <thead>
                <tr class="bg-blue-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-xs tracking-wider">
                    <th class="px-6 py-3 !text-center border border-gray-200 dark:border-gray-700 text-center w-12">#</th>
                    <th class="px-6 py-3 !text-center border border-gray-200 dark:border-gray-700 text-center w-1/4">Category</th>
                    <th class="px-6 py-3 !text-center border border-gray-200 dark:border-gray-700 text-center w-1/4">Title</th>
                    <th class="px-6 py-3 !text-center border border-gray-200 dark:border-gray-700 text-center w-1/5">Image</th>
                    <th class="px-6 py-3 !text-center border border-gray-200 dark:border-gray-700 text-center w-1/5">Created At</th>
                    <th class="px-6 py-3 !text-center border border-gray-200 dark:border-gray-700 text-center w-1/5">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-900">
                @forelse($galleries as $index => $gallery)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-150">
                        <td class="px-6 py-4 text-center border border-gray-200 dark:border-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-900 font-medium">{{ $gallery->category->category_name }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-900 font-medium">{{ $gallery->caption }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-900 text-center">
                            <img src="{{ asset($gallery->image) }}" 
                                 class="w-20 h-14 rounded-lg object-cover shadow-sm border border-gray-200 dark:border-gray-900 mx-auto" 
                                 alt="Gallery Image">
                        </td>   
                        <td class="px-6 py-4 text-center border border-gray-200 dark:border-gray-900">
                            {{ $gallery->created_at->format('d M, Y') }}
                        </td>
                        <td class="px-6 py-4 text-center border border-gray-200 dark:border-gray-900">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('gallery.edit', $gallery->id) }}" 
                                   class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 bg-blue-50 dark:bg-blue-900/30 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15.232 5.232l3.536 3.536M9 11l6-6 3.536 3.536-6 6H9v-3.536zM4 20h16" />
                                    </svg>
                                    Edit
                                </a>

                                <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" class="deleteGalleryForm inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-600 bg-red-50 dark:bg-red-900/30 dark:text-red-400 rounded-lg hover:bg-red-100 dark:hover:bg-red-800 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v2H9V4a1 1 0 011-1z"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            🚫 No records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Scripts -->
<script>
  $(document).ready(function () {
    $('#galleryTable').DataTable({
      paging: true,
      searching: true,
      responsive: true,
      ordering: true,
      columnDefs: [
        { orderable: false, targets: [1, 2, 3, 4, 5 ] }
      ]
    });
  });

  $('.deleteGalleryForm').on('submit', function (e) {
    e.preventDefault();
    const form = $(this);
    const url = form.attr('action');

    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the record!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        form.closest('tr').fadeOut(500, function(){ $(this).remove(); });
                    } else {
                        toastr.error('Failed to delete gallery.');
                    }
                },
                error: function () {
                    toastr.error('Error occurred while deleting.');
                }
            });
        }
    });
});
</script>
@endsection
