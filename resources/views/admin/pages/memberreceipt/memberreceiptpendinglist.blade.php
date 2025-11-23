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
                    <th class="px-6 py-3 text-left font-bold uppercase">Date & Invoice No</th>
                    <th class="px-6 py-3 text-left font-bold uppercase">Member</th>
                    <th class="px-6 py-3 text-left font-bold uppercase">Amount</th>
                    <th class="px-6 py-3 text-left font-bold uppercase">Details</th>
                    <th class="px-6 py-3 text-left font-bold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($receipts as $index => $value)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($value->payment_date)->format('d-m-Y') }} <br> {{ $value->mr_no }}
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200 truncate max-w-xs">
                            {{ $value->member_name }} ({{ $value->memberID }}) <br> {{ $value->member_phone }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                            {{ $value->payment_amount }}
                        </td>
                       <td class="px-6 py-4 text-gray-700 dark:text-gray-200 leading-relaxed">
                        @php
                            $months = json_decode($value->selected_months, true);
                        @endphp

                        {{-- Months --}}
                        @if($months)
                            <div>
                                {{-- <span class="font-semibold text-gray-800 dark:text-gray-100">Months:</span> --}}

                                <div class="flex flex-wrap gap-1">
                                    @foreach($months as $m)
                                        @php
                                            $formatted = \Carbon\Carbon::createFromFormat('Y-m', $m)->format('M Y');
                                        @endphp
                                        
                                        <span class="px-2 py-0.5 rounded-md text-xs font-semibold 
                                                    bg-blue-100 text-blue-700
                                                    dark:bg-blue-900 dark:text-blue-200 shadow-sm">
                                            {{ $formatted }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Account --}}
                        @if($value->account_name)
                            <div>
                                <span class="font-semibold text-gray-800 dark:text-gray-100">Account:</span>
                                <span class="text-gray-600 dark:text-gray-300">
                                    {{ $value->account_name }}
                                    {{ $value->account_no ? '('.$value->account_no.')' : '' }}
                                    {{ $value->transaction_no ? '('.$value->transaction_no.')' : '' }}
                                </span>
                            </div>
                        @endif

                        {{-- Remarks --}}
                        @if($value->payment_remarks)
                            <div>
                                <span class="font-semibold text-gray-800 dark:text-gray-100">Remarks:</span>
                                <span class="italic text-gray-600 dark:text-gray-300">
                                    {{ $value->payment_remarks }}
                                </span>
                            </div>
                        @endif

                    </td>


                        <td class="px-6 py-4 flex space-x-3">
                              <!-- Edit -->
                                <a href="{{ route('memberreceipt.edit', $value->mr_id) }}"
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

@push('scripts')
<script>
function approvemoneyReceipt(mrId, btn) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to approve this member receipt?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, approve',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('memberreceipt.memberreceiptapprove') }}", {
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
        title: 'Decline Member Receipt',
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

</script>
@endpush
@endsection
