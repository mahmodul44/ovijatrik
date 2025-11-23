@extends('layouts.main')
@section('content')
<div class="p-4 max-w-6xl mx-auto">

    <!-- Breadcrumb & Add Button -->
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Pending User List</li>
            </ol>
        </nav>
        
    </div>
    @if(session('success'))
        <div
          id="success-message"
          class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center"
        >
            {{ session('success') }}
        </div>
    @endif
    <!-- Project Table -->
    <div class="card-body overflow-x-auto bg-white rounded-lg shadow-xl ring-1 ring-gray-200">
    <table id="pendinguserTable" class="min-w-full text-sm text-gray-700">
        <thead class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 text-gray-700 shadow-md">
            <tr>
                <th class="px-6 py-3 text-left font-bold uppercase">#</th>
                <th class="px-6 py-3 text-left font-bold uppercase">Name</th>
                <th class="px-6 py-3 text-left font-bold uppercase">Member ID</th>
                <th class="px-6 py-3 text-left font-bold uppercase">Phone No</th>
                <th class="px-6 py-3 text-left font-bold uppercase">Email</th>
                <th class="px-6 py-3 text-left font-bold uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $index => $value)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $value->name }}</td>
                        <td class="px-6 py-4 text-gray-700 truncate max-w-xs">{{ $value->member_id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $value->phone_no }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $value->email }}</td>
                        <td class="px-6 py-4 space-x-2">
                        <button onclick="approveUser({{ $value->id }}, this)" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow-md transition transform hover:scale-105">
                            Approve
                        </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-6 py-4 text-gray-500">No records found.</td>
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
        title: 'Are you sure?',
        text: "Do you want to approve this user?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, approve',
        cancelButtonText: 'Cancel'
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
                    row.remove();
                } else {
                    toastr.error("Something went wrong");
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
