@extends('layouts.main')
@section('content')
<style>
/* Smooth fade-in animation */
@keyframes fade-in {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in 0.3s ease-out; }
</style>
<div class="p-4 max-w-6xl mx-auto">
    <!-- Breadcrumb -->
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm text-gray-500 dark:text-gray-400">
            <ol class="list-reset flex">
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="text-blue-600 dark:text-blue-400 hover:underline">
                       Dashboard
                    </a>
                </li>
               <li>
                    <span class="text-gray-400 dark:text-gray-500 mx-1">/</span>
                </li>
                
                <li class="relative">
                    <span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 text-xs font-medium shadow-sm">
                    Pending List </span>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div
          id="success-message"
          class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 
                 px-4 py-2 rounded mb-4 text-center shadow-md"
        >
            {{ session('success') }}
        </div>
    @endif

    <!-- Project Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700">
        <table id="pendinguserTable" class="min-w-full text-sm">
            <thead class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 
                           dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 
                           text-gray-700 dark:text-gray-200 shadow-md">
                <tr>
                    <th class="px-6 py-3 text-left font-bold uppercase">#</th>
                    <th class="px-6 py-3 text-left font-bold uppercase">Date</th>
                    <th class="px-6 py-3 text-left font-bold uppercase">Invoice No</th>
                    <th class="px-6 py-3 text-left font-bold uppercase">Project</th>
                    <th class="px-6 py-3 text-left font-bold uppercase">Details</th>
                    <th class="px-6 py-3 text-left font-bold uppercase">Amount</th>
                    <th class="px-6 py-3 text-left font-bold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($receipts as $index => $value)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($value->payment_date)->format('d-m-Y') }}
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200 truncate max-w-xs">
                            {{ $value->mr_no }}
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200 truncate max-w-xs">
                            {{ $value->project_id ? $value->project_title : '' }}
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200 truncate max-w-xs">
                            {{ $value->donar_name }} <br>  {{ $value->paymentmethod->pay_method_name }} {{ $value->mobile_account_no }} {{ $value->transaction_no }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                            {{ $value->payment_amount }}
                        </td>
                        <td class="px-6 py-4 flex space-x-3">
                            <!-- Approve -->
                            <button onclick="approvemoneyReceipt({{ $value->mr_id }}, this)" 
                                class="p-2 rounded-full bg-green-500 hover:bg-green-600 
                                    text-white shadow-md transition transform hover:scale-110"
                                title="Approve">
                                <!-- Check Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>

                            <!-- Decline -->
                            <button onclick="declineMoneyReceipt({{ $value->mr_id }}, this)" 
                                class="p-2 rounded-full bg-red-500 hover:bg-red-600 
                                    text-white shadow-md transition transform hover:scale-110"
                                title="Decline">
                                <!-- X Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- View -->
                            <button onclick="viewMoneyReceipt({{ $value->mr_id }})"
                                class="p-2 rounded-full bg-blue-500 hover:bg-blue-600 
                                    text-white shadow-md transition transform hover:scale-110"
                                title="View">
                                <!-- Eye Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12s-4.5 7.5-10.5 7.5S1.5 12 1.5 12z" />
                                    <circle cx="12" cy="12" r="3" />
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

<div id="moneyreceiptModal" 
     class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full p-6 relative animate-fade-in">

    <!-- Close Button -->
    <button onclick="closeModal()" 
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" 
           viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>

    <!-- Header -->
    <div class="mb-6">
      <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">💳 Money Receipt</h3>
      <p class="text-sm text-gray-500 dark:text-gray-400">Review details before taking action</p>
    </div>

    <!-- Body -->
    <div id="moneyreceiptDetails" class="space-y-4">
      
      <!-- Project Name -->
      <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
        <span class="text-gray-600 dark:text-gray-400 font-medium">Project</span>
        <span id="projectName" class="text-gray-900 dark:text-gray-400 font-semibold">
          Loading...
        </span>
      </div>

      <!-- Donor Name -->
      <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
        <span class="text-gray-600 dark:text-gray-400 font-medium">Donor</span>
        <span id="donorName" class="text-gray-900 dark:text-gray-400 font-semibold">
          Loading...
        </span>
      </div>

      <!-- Other Receipt Details -->
      <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg shadow-sm">
        <dl class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm">
          <div>
            <dt class="text-gray-500 dark:text-gray-400">Invoice No</dt>
            <dd id="receiptNo" class="text-gray-900 dark:text-gray-200 font-medium">Loading...</dd>
          </div>
          <div>
            <dt class="text-gray-500 dark:text-gray-400">Date</dt>
            <dd id="receiptDate" class="text-gray-900 dark:text-gray-200 font-medium">Loading...</dd>
          </div>
          <div>
            <dt class="text-gray-500 dark:text-gray-400">Amount</dt>
            <dd id="receiptAmount" class="text-green-600 dark:text-green-400 font-bold">Loading...</dd>
          </div>
          <div>
            <dt class="text-gray-500 dark:text-gray-400">Payment Type</dt>
            <dd id="paymentType" class="text-gray-900 dark:text-gray-200 font-medium">Loading...</dd>
          </div>
        </dl>
      </div>
    </div>

    <!-- Footer -->
    <div class="mt-8 flex justify-end space-x-3">
      <button onclick="closeModal()"
              class="p-2.5 rounded-full bg-red-500 hover:bg-red-600 text-white shadow-md transition transform hover:scale-110"
              title="Close">Close
      </button>

     
    </div>
  </div>
</div>

@push('scripts')
<script>
function approvemoneyReceipt(mrId, btn) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to approve this money receipt?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, approve',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
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

function declineMoneyReceipt(mrId, btn) {
    Swal.fire({
        title: 'Decline Money Receipt',
        text: "Please provide a reason for declining:",
        input: 'text',
        inputPlaceholder: 'Enter remarks...',
        inputValidator: (value) => {
            if (!value) {
                return 'Remarks are required!';
            }
        },
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, decline',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('moneyreceipt.moneyreceiptdecline') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ 
                    id: mrId,
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



function viewMoneyReceipt(mrId) {
    fetch("{{ url('admin/moneyreceipt/show') }}/" + mrId)
        .then(res => res.json())
        .then(data => {
            if (data) {
                let html = `
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Money Receipt Details</h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">#${data.mr_no}</span>
                    </div>

                    <div class="p-5 overflow-x-auto">
                        <table class="min-w-full border-collapse text-sm">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300 w-40">Invoice No</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">${data.mr_no}</td>
                                    <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300 w-40">Date</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">${new Date(data.payment_date).toLocaleDateString('en-GB')}</td>
                                </tr>

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Donor</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">${data.member_id ? data.member_name : data.donar_name}</td>
                                    <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Amount</td>
                                    <td class="px-4 py-3 text-gray-emerald-600 dark:text-green-400 font-semibold">${data.payment_amount}</td>
                                </tr>

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Project</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">${data.project_id ? data.project.project_title : ''}</td>
                                    <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">Payment Method</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">${data.pay_method_id ? data.paymentmethod.pay_method_name : ''}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end gap-3 p-5 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <button id="declineBtn" class="px-4 py-2 text-sm font-medium rounded-lg bg-red-600 hover:bg-red-700 text-white transition">Decline</button>
                        <button id="approveBtn" class="px-4 py-2 text-sm font-medium rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white transition">Approve</button>
                    </div>
                </div>
                `;

                document.getElementById('moneyreceiptDetails').innerHTML = html;

                // Approve button
                document.getElementById('approveBtn').onclick = function() {
                    approveReceipt(data.mr_id);
                };

                // Decline button
                document.getElementById('declineBtn').onclick = function() {
                    declineReceipt(data.mr_id);
                };

                // Show modal
                const modal = document.getElementById('moneyreceiptModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        })
        .catch(() => {
            toastr.error("Failed to load money receipt details.");
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
