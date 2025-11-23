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
                <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 text-center w-10%" style="text-align: center">Actions</th>
            </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800">
                @forelse($members as $index => $value)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600" style="text-align: center">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 font-medium text-gray-900 dark:text-gray-100" style="text-align: left">{{ $value->member_id }} - {{ $value->name }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300" style="text-align: center">{{ $value->phone_no }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300" style="text-align: left">{{ $value->email }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 truncate" style="text-align: left">{{ $value->occupation }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 truncate" style="text-align: right">{{ $value->monthly_donate }}</td>
                        <td class="px-6 py-4 border border-gray-200 dark:border-gray-600 space-x-2 text-center">
                        {{-- <a href="{{ route('member.show', $value->id) }}" 
                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded hover:bg-blue-100 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="w-4 h-4 mr-1" 
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

                            Preview
                        </a> --}}
                            <!-- Edit Button -->
                            {{-- <a href="{{ route('member.edit', $value->id) }}" class="inline-flex items-center gap-1 px-3 py-1 text-sm text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900 rounded hover:bg-blue-100 dark:hover:bg-blue-800 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                                </svg>
                                Edit
                            </a> --}}
                            <!-- Delete Button -->
                            {{-- <form action="{{ route('member.destroy', $value->id) }}" method="POST" class="deleteProjectForm inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 text-sm text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900 rounded hover:bg-red-100 dark:hover:bg-red-800 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Delete
                                </button>
                            </form> --}}
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ getStatusLabel($value->status)['class'] }}">
                                {{ getStatusLabel($value->status)['label'] }}
                            </span>
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
    $('#projectTable').DataTable({
        paging: true,
        searching: true,
        responsive: true,
        columnDefs: [
        { orderable: false, targets: [1, 2, 3, 4, 5] } // disable sort on Image & Actions
      ]
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
