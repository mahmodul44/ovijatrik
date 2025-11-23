@extends('layouts.main')
@section('content')
<div class="p-5 max-w-7xl mx-auto space-y-6">

    <!-- Breadcrumb & Add Button -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-500 bg-gray-50 dark:bg-gray-800 px-4 py-2 rounded-lg shadow-sm">
            <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Dashboard</a>
            <span>/</span>
            <span class="text-gray-700 dark:text-gray-300 font-semibold">Employee List</span>
        </nav>
        <a href="{{ route('employee.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg shadow-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Employee
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 px-4 py-2 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Project Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-xl border border-gray-200 dark:border-gray-700">
        <table id="employeeTable" class="min-w-full text-sm text-left border-collapse">
           <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
            <tr>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-5%" style="text-align: center">#</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-35%" style="text-align: center">Name</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Emp ID</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Phone no</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Email</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-20%" style="text-align: center">Status</th>
                <th class="px-6 py-3 text-center border border-gray-200 dark:border-gray-600">Actions</th>
            </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800">
                @forelse($employees as $index => $value)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600" style="text-align: center">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 font-medium text-gray-900 dark:text-gray-100" style="text-align: left">{{ $value->name }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 truncate" style="text-align: center">{{ $value->emp_no }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300" style="text-align: center">{{ $value->phone_no }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300" style="text-align: center">{{ $value->email }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 space-x-2 text-center">
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $value->status == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $value->status == 1 ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                         <td class="px-6 py-4 text-center border border-gray-200 dark:border-gray-600">
                            <!-- Edit Button -->
                            <a href="{{ route('employee.edit', $value->id) }}" class="inline-flex items-center gap-1 px-3 py-1 text-sm text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 rounded hover:bg-blue-100 dark:hover:bg-blue-800 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                                </svg>
                                Edit
                            </a>
                            <button 
                                class="toggle-status p-2 rounded-full text-white {{ $value->status == 1 ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}"
                                title="{{ $value->status == 1 ? 'Disable Employee' : 'Enable Employee' }}"
                                data-id="{{ $value->id }}"
                                data-status="{{ $value->status }}">
                                
                                @if($value->status == 1)
                                    <!-- Enabled (On) SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="#fff" viewBox="0 0 24 24">
                                        <path d="M17 4H7a7 7 0 000 14h10a7 7 0 000-14zm0 12H7a5 5 0 010-10h10a5 5 0 010 10z"/>
                                        <circle cx="17" cy="11" r="3" fill="currentColor"/>
                                    </svg>
                                @else
                                    <!-- Disabled (Off) SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="#fff" viewBox="0 0 24 24">
                                        <path d="M17 4H7a7 7 0 000 14h10a7 7 0 000-14zm0 12H7a5 5 0 010-10h10a5 5 0 010 10z"/>
                                        <circle cx="7" cy="11" r="3" fill="currentColor"/>
                                    </svg>
                                @endif
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center px-6 py-4 text-gray-500 dark:text-gray-400">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@push('scripts')
<script>
$(document).ready(function () {
    $('#employeeTable').DataTable({
        paging: true,
        searching: true,
        responsive: true,
        columnDefs: [
        { orderable: false, targets: [1, 2, 3, 4, 5] }
      ]
    });

$(document).on('click', '.toggle-status', function () {
    var btn = $(this);
    var id = btn.data('id');
    var currentStatus = btn.data('status');
    var newStatus = currentStatus == 1 ? 0 : 1;
    var actionText = currentStatus == 1 ? 'Disable' : 'Enable';

    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to ' + actionText.toLowerCase() + ' this employee?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, ' + actionText,
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('employee.toggleStatus') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: newStatus
                },
                success: function (res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1200
                        });
                        setTimeout(() => location.reload(), 1200);
                    } else {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to update status.', 'error');
                }
            });
        }
    });
});

});

// Delete confirmation
$('.deleteProjectForm').on('submit', function (e) {
    e.preventDefault();
    if (!confirm("Are you sure you want to delete this project?")) return;

    const form = $(this);
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
                setTimeout(() => window.location.reload(), 1000);
            }
        },
        error: function () {
            toastr.error('Failed to delete project.');
        }
    });
});
</script>
@endpush
@endsection
