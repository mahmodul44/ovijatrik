@extends('layouts.main')
@section('content')
<div class="p-5 max-w-7xl mx-auto space-y-6">

    <!-- Breadcrumb & Add Button -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-500 bg-gray-50 dark:bg-gray-800 px-4 py-2 rounded-lg shadow-sm">
            <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Dashboard</a>
            <span>/</span>
            <span class="text-gray-700 dark:text-gray-300 font-semibold">Complete Project List</span>
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
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">End Date</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Target Amount</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Collection</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Expense</th>
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
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400" style="text-align: center">{{ \Carbon\Carbon::parse($project->project_start_date)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400" style="text-align: center">{{ \Carbon\Carbon::parse($project->project_end_date)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 truncate" style="text-align: right">{{ number_format($project->target_amount,2) }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 truncate" style="text-align: right">{{ number_format($project->collection_amount,2) }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 truncate" style="text-align: right">{{ number_format($project->expense_amount,2) }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 truncate" style="text-align: center">
                             @if($project->status == '2')
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-700 text-green-700 dark:text-green-200 rounded text-xs">Complete</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 dark:bg-red-700 text-red-700 dark:text-red-200 rounded text-xs"></span>
                            @endif
                        </td>
                        <td style="text-align: center!important" class="px-6 py-4 border border-r flex gap-3 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 text-sm">
                           
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
                            <!-- Reverse -->
                        <form action="{{ route('project.reverse', $project->project_id) }}" 
                            method="POST" 
                            class="inline-block reverseProjectForm">
                            @csrf
                            @method('PUT')
                            <button type="button"
                                title="Reverse Project Completion"
                                class="reverseBtn inline-flex items-center justify-center w-7 h-7 rounded 
                                    bg-yellow-50 hover:bg-yellow-100 text-yellow-600 
                                    dark:bg-yellow-900 dark:hover:bg-yellow-800 
                                    dark:text-yellow-400 dark:hover:text-yellow-300 mr-1">
                                <!-- Undo / Reverse Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="w-4 h-4" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke="currentColor" 
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M3 10h10a4 4 0 110 8H5m-2-8l4-4m-4 4l4 4" />
                                </svg>
                            </button>
                        </form>
                        <button type="button"
                            class="addLinkBtn inline-flex items-center justify-center w-7 h-7 rounded 
                            bg-purple-50 hover:bg-purple-100 text-purple-600 mr-1"
                            data-id="{{ $project->project_id }}"
                            data-link="{{ $project->project_link }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.414-1.414m1.414-11.314a4 4 0 015.656 0l3 3a4 4 0 11-5.656 5.656l-1.414-1.414" />
                            </svg>
                        </button>
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

<div id="addLinkModal" 
     class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-96 shadow-xl">
        <h2 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200">
            Add Project Link
        </h2>

        <input type="hidden" id="project_id">

        <label class="text-sm text-gray-600 dark:text-gray-300">Project URL</label>
        <input type="text" id="project_link" 
               placeholder="https://drive.google.com/..."
               class="w-full mt-2 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:text-gray-100">

        <div class="flex justify-end gap-3 mt-4">
            <button id="closeModal" 
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded">Close</button>

            <button id="saveProjectLink"
                    class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
        </div>
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
        { orderable: false, targets: [1, 2, 4, 5, 6] } 
      ]
    });
});

$('.reverseBtn').on('click', function () {
    const form = $(this).closest('.reverseProjectForm');

    Swal.fire({
        title: 'Reverse Project Completion?',
        text: "This will mark the project as active again and remove its end date.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EAB308', 
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Reverse it!',
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
                            'Reversed!',
                            response.message,
                            'success'
                        );
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to reverse project.', 'error');
                }
            });
        }
    });
});

// 🟣 Show Modal & Load Existing Link
$(document).on('click', '.addLinkBtn', function () {
    $('#project_id').val($(this).data('id'));
    $('#project_link').val($(this).data('link') ?? '');
    $('#addLinkModal').removeClass('hidden');
});

// 🔴 Close Modal
$('#closeModal').on('click', function () {
    $('#addLinkModal').addClass('hidden');
});

// 🟢 Save Link via AJAX
$('#saveProjectLink').on('click', function () {
    let id = $('#project_id').val();
    let link = $('#project_link').val();

    $.ajax({
        url: "/project/save-link/" + id,
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            link: link
        },
        success: function (response) {
            if (response.success) {
                Swal.fire("Saved!", response.message, "success");
                $('#addLinkModal').addClass('hidden');
                setTimeout(() => location.reload(), 1000);
            } else {
                Swal.fire("Error!", "Something went wrong!", "error");
            }
        }
    });
});

</script>
@endpush
@endsection
