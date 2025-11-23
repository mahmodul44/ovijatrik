@extends('layouts.main')
@section('content')
<div class="p-5 max-w-7xl mx-auto space-y-6">

    <!-- Breadcrumb & Add Button -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-500 bg-gray-50 dark:bg-gray-800 px-4 py-2 rounded-lg shadow-sm">
            <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Dashboard</a>
            <span>/</span>
            <span class="text-gray-700 dark:text-gray-300 font-semibold">Ongoing Project List</span>
        </nav>
        <a href="{{ route('project.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg shadow-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Project
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 px-4 py-2 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Project Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-xl border border-gray-200 dark:border-gray-700">
        <table id="projectTable" class="min-w-full text-sm text-left border-collapse">
           <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
            <tr>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-5%" style="text-align: center">#</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-35%" style="text-align: center">Title</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Start Date</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Target Amount</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Collection Amount</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Status</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Actions</th>
            </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800">
                @if($projects)
                @foreach($projects as $index => $project)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600" style="text-align: center">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 font-medium text-gray-900 dark:text-gray-100" style="text-align: left">{{ $project->project_code }} - {{ $project->project_title }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-100" style="text-align: center">{{ \Carbon\Carbon::parse($project->project_start_date)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-100 truncate" style="text-align: right">{{ number_format($project->target_amount,2) }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-100 truncate" style="text-align: right">{{ number_format($project->collection_amount,2) }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-100 truncate" style="text-align: center">
                             @if($project->status == '1')
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-700 text-green-700 dark:text-green-200 rounded text-xs">Active</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 dark:bg-red-700 text-red-700 dark:text-red-200 rounded text-xs">Inactive</span>
                            @endif
                        </td>
                        <td style="text-align: center!important" class="px-6 py-4 border border-r flex gap-3 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 text-sm">
                                <!-- Preview -->
                                <a href="{{ route('project.show', $project->project_id) }}"
                                    title="Preview"
                                    class="inline-flex items-center justify-center w-7 h-7 text-blue-600 bg-blue-50 rounded hover:bg-blue-100 mr-1">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="w-4 h-4" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke="currentColor" 
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 
                                            4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                                    <!-- Edit -->
                                <a href="{{ route('project.edit', $project->project_id) }}"
                                    title="Edit"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded 
                                            bg-indigo-50 hover:bg-indigo-100 text-indigo-600 
                                            dark:bg-indigo-900 dark:hover:bg-indigo-800 
                                            dark:text-indigo-400 dark:hover:text-indigo-300 mr-1">
                                        
                                        <!-- Pencil / Edit Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="w-4 h-4" 
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke="currentColor" 
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                                d="M16.862 3.487a2.25 2.25 0 113.182 3.182l-10.95 10.95a4.5 4.5 0 01-1.897 1.13l-3.39.97a.75.75 0 01-.927-.927l.97-3.39a4.5 4.5 0 011.13-1.897l10.95-10.95z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                                d="M19.5 7.5l-3-3" />
                                        </svg>
                                    </a>

                                <!-- Delete -->
                                <form action="{{ route('project.destroy', $project->project_id) }}" 
                                    method="POST" 
                                    class="deleteProjectForm inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        title="Delete"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-900 dark:hover:bg-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="w-4 h-4"
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke="currentColor" 
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                        </svg>
                                    </button>
                                </form>
                               <!-- Complete -->
                                <form action="{{ route('project.complete', $project->project_id) }}" 
                                    method="POST" 
                                    class="inline-block completeProjectForm">
                                    @csrf
                                    @method('PUT')
                                    <button type="button"
                                        title="Mark as Complete"
                                        class="completeBtn inline-flex items-center justify-center w-7 h-7 rounded 
                                            bg-green-50 hover:bg-green-100 text-green-600 
                                            dark:bg-green-900 dark:hover:bg-green-800 
                                            dark:text-green-400 dark:hover:text-green-300 mr-1">
                                        <!-- Check Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="w-4 h-4" 
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke="currentColor" 
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </form>


                            </td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center px-6 py-4 text-gray-500 dark:text-gray-400">No records found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>

@push('scripts')
<script>
$(document).ready(function () {
    $('#projectTable').DataTable({
        paging: true,
        searching: true,
        responsive: true,
        columnDefs: [
        { orderable: false, targets: [1, 2, 3, 4, 5, 6] } 
      ]
    });
});

$('.deleteProjectForm').on('submit', function (e) {
    e.preventDefault();
    const form = $(this);

    Swal.fire({
        title: 'Are you sure?',
        text: "This project will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        );
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to delete project.', 'error');
                }
            });
        }
    });
});

$('.completeBtn').on('click', function () {
    const form = $(this).closest('.completeProjectForm');

    Swal.fire({
        title: 'Mark Project as Complete',
        html: `
            <label>Select Project End Date:</label>
            <input type="text" id="end_date" class="swal2-input" placeholder="dd/mm/yyyy" style="width:auto;">
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16A34A',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Complete',
        cancelButtonText: 'Cancel',

        // 👇 Initialize Flatpickr when Swal is opened
        didOpen: () => {
            flatpickr("#end_date", {
                dateFormat: "d/m/Y", // shows as dd/mm/yyyy
                allowInput: true,
                defaultDate: new Date()
            });
        },

        preConfirm: () => {
            const endDate = document.getElementById('end_date').value;
            if (!endDate) {
                Swal.showValidationMessage('Please select an end date.');
            }
            return endDate;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const end_date = result.value;

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize() + '&end_date=' + end_date,
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            'Completed!',
                            response.message,
                            'success'
                        );
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to complete project.', 'error');
                }
            });
        }
    });
});
</script>
@endpush
@endsection
