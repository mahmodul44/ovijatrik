@extends('layouts.main')
@section('content')
<div class="p-4 max-w-7xl mx-auto">

    <!-- Breadcrumb -->
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm text-gray-600 dark:text-gray-300">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Dashboard</a>
                </li>
                <li>/</li>
                <li class="text-gray-800 dark:text-gray-200 font-medium">Pending List</li>
            </ol>
        </nav>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div id="success-message"
             class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-4 py-2 rounded-lg mb-4 text-center shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700">
        <table id="pendinguserTable" class="min-w-full text-sm text-gray-700 dark:text-gray-300">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Receipt No</th>
                    <th class="px-6 py-3 text-left">From Project</th>
                    <th class="px-6 py-3 text-left">To Project</th>
                    <th class="px-6 py-3 text-left">Amount</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($transfers as $index => $value)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($value->transfer_date)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4 truncate max-w-xs">{{ $value->transfer_no }}</td>
                        <td class="px-6 py-4 truncate max-w-xs">{{ $value->fromProject->project_title }}</td>
                        <td class="px-6 py-4 truncate max-w-xs">{{ $value->toProject->project_title }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">{{ $value->transfer_amount }}</td>
                        <td class="px-6 py-4 text-center space-x-2 flex justify-center">

                            <!-- Approve -->
                            <button onclick="approveTransfer({{ $value->transfer_id }}, this)"
                                class="p-2 bg-green-500 hover:bg-green-600 text-white rounded-full shadow transition"
                                title="Approve">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>

                            <!-- Decline -->
                            <button onclick="declineTransfer({{ $value->transfer_id }}, this)"
                                class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-full shadow transition"
                                title="Decline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>

                            <!-- Preview -->
                            <button onclick="openPreviewWindow('{{ route('transfer.transferPreview', $value->transfer_id) }}')"
                                class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full shadow transition"
                                title="Preview">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 
                                             0 8.268 2.943 9.542 7-1.274 4.057-5.065 
                                             7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center px-6 py-4 text-gray-500 dark:text-gray-400">
                            No records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Overlay Modal -->
<div id="moneyreceiptModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-lg w-full p-6">
        
        <!-- Header -->
        <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Money Receipt Details</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl">&times;</button>
        </div>

        <!-- Body -->
        <div id="moneyreceiptDetails" class="mt-4 space-y-2 text-gray-700 dark:text-gray-300">
            Loading...
        </div>

        <!-- Footer -->
        <div class="mt-6 flex justify-end space-x-3">
            <button id="approveBtn" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">Approve</button>
            <button id="declineBtn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow">Decline</button>
        </div>
    </div>
</div>


@push('scripts')
<script>
function approveTransfer(transferId, btn) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to approve this transfer?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, approve',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('transfer.transferapprove') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: transferId })
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
                toastr.error("Error approving receipt.");
            });
        }
    });
}

function declineTransfer(transferId, btn) {
    Swal.fire({
        title: 'Decline Transfer',
        text: "Please provide remarks for declining this transfer:",
        icon: 'warning',
        input: 'textarea',
        inputPlaceholder: 'Enter remarks here...',
        inputAttributes: {
            'aria-label': 'Decline remarks'
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        preConfirm: (remarks) => {
            if (!remarks || remarks.trim() === '') {
                Swal.showValidationMessage('Remarks are required!');
                return false;
            }
            return remarks;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('transfer.transferdecline') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ 
                    id: transferId, 
                    remarks: result.value   
                })
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
                toastr.error("Error declining receipt.");
            });
        }
    });
}

function openPreviewWindow(url) {
        let width = 800;
        let height = 600;
        let left = (screen.width / 2) - (width / 2);
        let top = (screen.height / 2) - (height / 2);

        window.open(
            url,
            'previewWindow',
            `width=${width},height=${height},top=${top},left=${left},scrollbars=yes,resizable=no`
        );
    }

function viewTransfer(mrId) {

    fetch("{{ url('admin/trnsfer/show') }}/" + mrId)
        .then(res => res.json())
        .then(data => {
            if (data) {
                let html = `
                <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 divide-y divide-gray-200 text-sm text-gray-700">
                    <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-2 font-semibold bg-gray-50 w-40">Inv No</td>
                        <td class="px-4 py-2">${data.mr_no}</td>
                        <td class="px-4 py-2 font-semibold bg-gray-50 w-40">Date</td>
                        <td class="px-4 py-2">${data.payment_date}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-semibold bg-gray-50">Donar Name</td>
                        <td class="px-4 py-2">${data.member_id ? data.member_name : data.donar_name}</td>
                        <td class="px-4 py-2 font-semibold bg-gray-50">Amount</td>
                        <td class="px-4 py-2">${data.payment_amount}</td>
                    </tr>
                    </tbody>
                </table>
                </div>
                `;
                document.getElementById('moneyreceiptDetails').innerHTML = html;

                // Approve
                document.getElementById('approveBtn').onclick = function() {
                    approveReceipt(data.mr_id);
                };

                // Decline
                document.getElementById('declineBtn').onclick = function() {
                    declineReceipt(data.mr_id);
                };

                // Show Modal
                document.getElementById('moneyreceiptModal').classList.remove('hidden');
                document.getElementById('moneyreceiptModal').classList.add('flex');
            }
        })
        .catch(() => {
            toastr.error("Failed to load expense details.");
        });
}

function closeModal() {
    document.getElementById('moneyreceiptModal').classList.add('hidden');
    document.getElementById('moneyreceiptModal').classList.remove('flex');
}

function approveReceipt(mrId) {
    fetch("{{ route('moneyreceipt.moneyreceiptapprove') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ id: mrId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            toastr.success(data.success);
            closeModal();
            location.reload();
        } else {
            toastr.error("Something went wrong");
        }
    });
}

// Decline with Remarks
function declineReceipt(mrId) {
    Swal.fire({
        title: 'Decline Expense',
        input: 'textarea',
        inputPlaceholder: 'Enter remarks...',
        showCancelButton: true,
        confirmButtonText: 'Decline',
        cancelButtonText: 'Cancel',
        preConfirm: (remarks) => {
            if (!remarks) {
                Swal.showValidationMessage('Remarks required!');
                return false;
            }
            return remarks;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('moneyreceipt.moneyreceiptdecline') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: mrId, remarks: result.value })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.success);
                    closeModal();
                    location.reload();
                } else {
                    toastr.error("Something went wrong");
                }
            });
        }
    });
}

</script>
@endpush
@endsection
