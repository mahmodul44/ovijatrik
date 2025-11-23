@extends('layouts.main')
@section('content')
<div class="p-6 max-w-7xl mx-auto">

    <!-- Breadcrumb & Add Button -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
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
                <li class="text-gray-700 dark:text-gray-300">Project Sub Category List</li>
            </ol>
        </nav>

        <a href="{{ route('subcategory.create') }}"
        class="inline-flex items-center gap-1 bg-blue-600 dark:bg-blue-500 
                text-white text-sm px-3 py-1.5 rounded-full shadow-sm 
                hover:bg-blue-700 dark:hover:bg-blue-600 
                transition-colors duration-300 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add Project Sub Category
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div id="success-message" class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-4 py-2 rounded mb-4 text-center shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg overflow-x-auto border border-gray-200 dark:border-gray-700">
        <table id="subcatTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-6 py-3 !text-center font-semibold border-r dark:border-gray-700 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">#</th>
                    <th class="px-6 py-3 !text-center font-semibold border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">Category Name</th>
                    <th class="px-6 py-3 !text-center font-semibold border-r dark:border-gray-700 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">Sub Category Name</th>
                    <th class="px-6 py-3 !text-center font-semibold border-r dark:border-gray-700 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">Status</th>
                    <th class="px-6 py-3 !text-center font-semibold border-r dark:border-gray-700 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($subcategories as $index => $value)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 text-center border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-200 text-left border-r dark:border-gray-700 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $value->category->category_name }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 truncate max-w-xs text-left border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $value->sub_cat_name }} - {{ $value->sub_cat_name_bn }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100 text-center border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                            @if($value->status == '1')
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-700 text-green-700 dark:text-green-200 rounded text-xs">Active</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 dark:bg-red-700 text-red-700 dark:text-red-200 rounded text-xs">Inactive</span>
                            @endif
                        </td>
                       <td class="px-6 py-4 space-x-4 text-center border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">

                    <!-- Edit Button with Pencil Icon -->
                    <a href="{{ route('subcategory.edit', $value->sub_cat_id) }}"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:hover:text-indigo-400 hover:underline">
                        <!-- Pencil Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182l-10.95 10.95a4.5 4.5 0 01-1.897 1.13l-3.39.97a.75.75 0 01-.927-.927l.97-3.39a4.5 4.5 0 011.13-1.897l10.95-10.95z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.5l-3-3" />
                        </svg>
                        Edit
                    </a>

            <!-- Delete Button with Trash Icon -->
            <form action="{{ route('subcategory.destroy', $value->sub_cat_id) }}" method="POST" class="deleteSubCategoryForm inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800 dark:hover:text-red-400 hover:underline">
                    <!-- Trash Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3" />
                    </svg>
                    Delete
                </button>
            </form>
        </td>

        </tr>
            @empty
        <tr>
                <td colspan="5" class="text-center px-6 py-4 text-gray-500 dark:text-gray-400">No records found.</td>
        </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    $('#subcatTable').DataTable({
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

$('.deleteSubCategoryForm').on('submit', function (e) {
    e.preventDefault();

    const form = $(this);
    const url = form.attr('action');

    Swal.fire({
        title: "Are you sure?",
        text: "This subcategory will be deleted permanently!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        toastr.error("Something went wrong!");
                    }
                },
                error: function () {
                    toastr.error("Failed to delete subcategory.");
                }
            });
        }
    });
});

</script>
@endpush
@endsection
