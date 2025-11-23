@extends('layouts.main')

@section('content')
<div class="p-6 max-w-7xl mx-auto transition-colors duration-300">

    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Pending User List</h1>
            <nav class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline dark:text-blue-400">
                            Dashboard
                        </a>
                    </li>
                    <li><span>/</span></li>
                    <li class="text-gray-700 dark:text-gray-300">Pending User List</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div id="success-message"
             class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 px-4 py-3 rounded-md mb-5 text-center font-medium shadow-md transition">
            {{ session('success') }}
        </div>
    @endif

    <!-- User Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-lg rounded-2xl ring-1 ring-gray-200 dark:ring-gray-700">
        <table id="pendinguserTable" class="min-w-full text-sm text-gray-700 dark:text-gray-200">
            <thead class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">#</th>
                    <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Member ID</th>
                    <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Phone No</th>
                    <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Email</th>
                    <th class="px-6 py-3 text-center font-semibold uppercase text-xs tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($users as $index => $value)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-100">{{ $value->name }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $value->member_id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-200">{{ $value->phone_no }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-200">{{ $value->email }}</td>
                        <td class="px-6 py-4 text-center">
                            <button onclick="approveUser({{ $value->id }}, this)"
                                class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105 active:scale-95">
                                Approve
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center px-6 py-6 text-gray-500 dark:text-gray-400">
                            No pending users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@push('scripts')
<script>
function approveUser(userId, btn) {
    Swal.fire({
        title: 'Approve User?',
        text: "Do you want to approve this user?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, approve',
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
        color: document.documentElement.classList.contains('dark') ? '#e5e7eb' : '#111827'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('users.approve') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: userId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.success);
                    const row = btn.closest('tr');
                    row.classList.add('bg-green-50', 'dark:bg-green-900/30');
                    setTimeout(() => row.remove(), 600);
                } else {
                    toastr.error("Something went wrong.");
                }
            })
            .catch(() => {
                toastr.error("Error approving user.");
            });
        }
    });
}
</script>
@endpush
@endsection
