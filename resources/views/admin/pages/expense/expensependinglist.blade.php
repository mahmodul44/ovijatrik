@extends('layouts.main')
@section('content')
<div class="p-4 max-w-7xl mx-auto">

    <!-- Breadcrumb & Action -->
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm text-gray-500 dark:text-gray-400">
            <ol class="list-reset flex items-center space-x-2">
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li><span>/</span></li>
                <li class="text-gray-700 dark:text-gray-300 font-semibold">
                    Expense Pending List
                </li>
            </ol>
        </nav>

        <!-- Example Action Button -->
        <a href="{{ route('expense.create') }}"
           class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
           <i class="fas fa-plus"></i> New Expense
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div id="success-message" 
             class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 
                    px-4 py-2 rounded mb-4 text-center shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Expense Table -->
    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <table id="pendinguserTable" class="min-w-full text-sm text-gray-700 dark:text-gray-300">
            <thead class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">#</th>
                    <th class="px-6 py-3 text-left font-semibold">Date</th>
                    <th class="px-6 py-3 text-left font-semibold">Expense No</th>
                    <th class="px-6 py-3 text-left font-semibold">Expense Name</th>
                    <th class="px-6 py-3 text-left font-semibold">Amount</th>
                    <th class="px-6 py-3 text-center font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($expenses as $index => $value)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($value->expense_date)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4">{{ $value->expense_no }}</td>
                        <td class="px-6 py-4">
                            {{ $value->project_id ? $value->project->project_title : $value->expcategory->expense_cat_name }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">
                            {{ number_format($value->expense_amount, 2) }} ৳
                        </td>
                        <td class="px-6 py-4 flex items-center justify-center gap-3">

                            <!-- Approve -->
                            <button onclick="approveExpense({{ $value->expense_id }}, this)" 
                                class="p-2 bg-green-500 hover:bg-green-600 text-white rounded-full shadow transition"
                                title="Approve">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>

                            <!-- Decline -->
                            <button onclick="declineExpense({{ $value->expense_id }}, this)" 
                                class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-full shadow transition"
                                title="Decline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- View -->
                            <button onclick="viewExpense({{ $value->expense_id }})" 
                                class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full shadow transition"
                                title="View">
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
                        <td colspan="6" class="text-center px-6 py-4 text-gray-500 dark:text-gray-400">
                            No pending expenses found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="expenseModal" class="fixed inset-0 bg-gray-700 bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6">

    <!-- Header -->
    <div class="flex justify-between items-center border-b pb-2 border-gray-200 dark:border-gray-700">
      <h3 class="text-lg font-semibold text-gray-800">Expense Details</h3>
      <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl">&times;</button>
    </div>

    <!-- Body -->
    <div id="expenseDetails" class="mt-4 space-y-2 text-gray-700 dark:text-gray-300">
      Loading...
    </div>

    <!-- Footer -->
    <div class="mt-6 flex justify-end gap-3">
      <button id="approveBtn" class="p-2 bg-green-600 hover:bg-green-700 text-white rounded-full shadow" title="Approve">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
      </button>
      <button id="declineBtn" class="p-2 bg-red-600 hover:bg-red-700 text-white rounded-full shadow" title="Decline">
         <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </div>
</div>


@push('scripts')
<script>
function approveExpense(expenseId, btn) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to approve this user?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, approve',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('expense.approveexpense') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: expenseId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    toastr.success(data.message);
                    if (btn && btn.closest('tr')) {
                        btn.closest('tr').remove();
                    }
                } else if (data.status === 'error') {
                    if (data.balance) {
                        toastr.error(`${data.message} (Balance: ${data.balance})`);
                    } else {
                        toastr.error(data.message);
                    }
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

function declineExpense(expenseId, btn) {
    Swal.fire({
        title: 'Decline Expense',
        text: "Please provide remarks for declining this expense.",
        icon: 'warning',
        input: 'textarea',
        inputPlaceholder: 'Enter your remarks here...',
        inputAttributes: {
            'aria-label': 'Remarks'
        },
        showCancelButton: true,
        confirmButtonText: 'Decline',
        cancelButtonText: 'Cancel',
        preConfirm: (remarks) => {
            if (!remarks) {
                Swal.showValidationMessage('Remarks are required!');
                return false;
            }
            return remarks;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('expense.expensedecline') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ 
                    id: expenseId, 
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
                toastr.error("Error declining expense.");
            });
        }
    });
}

function viewExpense(expenseId) {

    fetch("{{ url('admin/expense/show') }}/" + expenseId)
        .then(res => res.json())
        .then(data => {
            if (data) {
                let html = `
                <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 divide-y divide-gray-200 text-sm text-gray-700">
                    <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-2 font-semibold bg-gray-50 w-40">Voucher No</td>
                        <td class="px-4 py-2">${data.expense_no}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-semibold bg-gray-50 w-40">Date</td>
                        <td class="px-4 py-2">${new Date(data.expense_date).toLocaleDateString('en-GB')}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-semibold bg-gray-50">Amount</td>
                        <td class="px-4 py-2">${data.expense_amount}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-semibold bg-gray-50">Category</td>
                        <td class="px-4 py-2">
                            ${data.project_id ? data.project.project_title : data.expcategory.expense_cat_name}
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
                `;
                document.getElementById('expenseDetails').innerHTML = html;

                // Approve
                document.getElementById('approveBtn').onclick = function() {
                    approveExpense(data.expense_id);
                };

                // Decline
                document.getElementById('declineBtn').onclick = function() {
                    declineExpense(data.expense_id);
                };

                // Show Modal
                document.getElementById('expenseModal').classList.remove('hidden');
                document.getElementById('expenseModal').classList.add('flex');
            }
        })
        .catch(() => {
            toastr.error("Failed to load expense details.");
        });
}

function closeModal() {
    document.getElementById('expenseModal').classList.add('hidden');
    document.getElementById('expenseModal').classList.remove('flex');
}

// Approve
function approveExpensemodal(expenseId) {
    fetch("{{ route('expense.approveexpense') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ id: expenseId })
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
function declineExpense(expenseId) {
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
            fetch("{{ route('expense.expensedecline') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: expenseId, remarks: result.value })
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
