@extends('layouts.main')
@section('content')
<div class="p-5 max-w-7xl mx-auto space-y-6">

    <!-- Breadcrumb & Add Button -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-500 bg-gray-50 dark:bg-gray-800 px-4 py-2 rounded-lg shadow-sm">
            <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Dashboard</a>
            <span>/</span>
            <span class="text-gray-700 dark:text-gray-300 font-semibold">Member List</span>
        </nav>
        <a href="{{ route('member.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg shadow-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Member
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
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-35%" style="text-align: center">Name</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-10%" style="text-align: center">Phone no</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-15%" style="text-align: center">Email</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-15%" style="text-align: center">Occupation</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-10%" style="text-align: center">Monthly Amount</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-10%" style="text-align: center">Status</th>
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-10%" style="text-align: center">Actions</th>
            </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800">
                @foreach($members as $index => $value)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600" style="text-align: center">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 font-medium text-gray-900 dark:text-gray-100" style="text-align: left">{{ $value->member_id }} - {{ $value->name }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300" style="text-align: center">{{ $value->phone_no }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300" style="text-align: left">{{ $value->email }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 truncate" style="text-align: left">{{ $value->occupation }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 truncate" style="text-align: right">{{ $value->monthly_donate }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 space-x-2 text-center">
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ getStatusLabel($value->status)['class'] }}">
                                {{ getStatusLabel($value->status)['label'] }}
                            </span>
                        </td>
                       <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-center flex items-center justify-center gap-3">
                        <!-- Preview -->
                        <a href="{{ route('member.show', $value->id) }}"
                        class="p-2 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300
                                hover:bg-blue-200 dark:hover:bg-blue-800 transition shadow-sm hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12 18 19.5 12 19.5 1.5 12 1.5 12z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('member.edit', $value->id) }}"
                        class="p-2 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300
                                hover:bg-yellow-200 dark:hover:bg-yellow-800 transition shadow-sm hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.232 5.232l3.536 3.536M14.121 4.121a3 3 0 014.243 4.243L7.5 19.207H3v-4.5z" />
                            </svg>
                        </a>

                        <!-- Delete -->
                        <form action="{{ route('member.destroy', $value->id) }}" method="POST" class="inline-block deleteMember">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300
                                    hover:bg-red-200 dark:hover:bg-red-800 transition shadow-sm hover:shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </td>

                    </tr>
             
                @endforeach
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
        { orderable: false, targets: [1, 2, 3, 4, 5, 6, 7] } 
      ]
    });
});

$('.deleteMember').on('submit', function (e) {
    e.preventDefault(); 

    let form = $(this);

    Swal.fire({
        title: "Are you sure?",
        text: "This member will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: form.attr('action'),
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
                    }
                },
                error: function () {
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to delete member.",
                        icon: "error"
                    });
                }
            });
        }
    });
});

</script>
@endpush
@endsection
