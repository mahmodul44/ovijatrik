@extends('layouts.main')
@section('content')
<div class="p-6 max-w-7xl mx-auto">

    <!-- Breadcrumb & Add Button -->
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm text-gray-500 dark:text-gray-400">
            <ol class="list-reset flex">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                        <!-- Home SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 9.75L12 3l9 6.75M4.5 10.5V21h15V10.5" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700 dark:text-gray-300">Project Category List</li>
            </ol>
        </nav>
        
        <a href="{{ route('category.create') }}"
        class="inline-flex items-center gap-1 bg-blue-600 dark:bg-blue-500 
                text-white text-sm px-3 py-1.5 rounded-full shadow-sm 
                hover:bg-blue-700 dark:hover:bg-blue-600 
                transition-colors duration-300 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add Project Category
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div id="success-message"
             class="bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-2 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Project Table -->
<div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <table id="categoryTable"
        class="min-w-full text-sm border border-gray-300 dark:border-gray-700 border-collapse">
        <thead
            class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-b dark:border-gray-700">
            <tr>
                <th class="px-6 py-3 !text-center font-semibold border dark:border-gray-700">#</th>
                <th class="px-6 py-3 !text-center font-semibold border dark:border-gray-700">Category Name</th>
                <th class="px-6 py-3 !text-center font-semibold border dark:border-gray-700">Category Name BN</th>
                <th class="px-6 py-3 !text-center font-semibold border dark:border-gray-700">Status</th>
                <th class="px-6 py-3 !text-center font-semibold border dark:border-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($categories as $index => $value)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <td
                        class="px-6 py-4 text-center text-gray-600 dark:text-gray-300 border dark:border-gray-700">
                        {{ $index + 1 }}
                    </td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 border dark:border-gray-700">
                        {{ $value->category_name }}
                    </td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-200 border dark:border-gray-700">
                        {{ $value->category_name_bn }}
                    </td>
                    <td
                        class="px-6 py-4 text-center font-medium border dark:border-gray-700">
                        @if($value->status == '1')
                            <span
                                class="px-2 py-1 bg-green-100 dark:bg-green-700 text-green-700 dark:text-green-200 rounded text-xs">Active</span>
                        @else
                            <span
                                class="px-2 py-1 bg-red-100 dark:bg-red-700 text-red-700 dark:text-red-200 rounded text-xs">Inactive</span>
                        @endif
                    </td>
                    <td
                        class="px-6 py-4 flex items-center justify-center gap-3 border dark:border-gray-700">
                        <!-- Edit Button -->
                        <a href="{{ route('category.edit', $value->category_id) }}"
                           class="flex items-center gap-1 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11.5A2.5 2.5 0 006.5 21h11a2.5 2.5 0 002.5-2.5V13m-6-8l6 6m-6-6v6h6" />
                            </svg>
                            Edit
                        </a>
                        <!-- Delete Button -->
                        <form action="{{ route('category.destroy', $value->category_id) }}" method="POST"
                              class="deleteCategoryForm inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="flex items-center gap-1 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5"
                        class="text-center px-6 py-4 text-gray-500 dark:text-gray-400 border dark:border-gray-700">
                        No records found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#categoryTable').DataTable({
            paging: true,
            searching: true,
            responsive: true,
            language: {
                searchPlaceholder: "",
                search: "",
            },
             columnDefs: [
              { orderable: false, targets: [ 1, 2, 3, 4] } 
            ]
        });
    });

   $('.deleteCategoryForm').on('submit', function (e) {
    e.preventDefault();
    
    const form = $(this);
    const url = form.attr('action');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message || 'Failed to delete category.');
                    }
                },
                error: function () {
                    toastr.error('Failed to delete category.');
                }
            });
        }
    });
});

</script>
@endpush
@endsection
