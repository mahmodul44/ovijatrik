@extends('layouts.main')
@section('content')

<div class="max-w-6xl mx-auto py-6 px-4">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Salary Preview</h2>
        <a href="{{ route('salary.index') }}"
           class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm">
            Back to List
        </a>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
            <p class="text-gray-600 dark:text-gray-300 text-sm">Salary Year</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">
                {{ $salary->salary_year }}
            </p>
        </div>

        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
            <p class="text-gray-600 dark:text-gray-300 text-sm">Salary Month</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">
                {{ $months[$salary->salary_month] ?? 'N/A' }}
            </p>
        </div>

        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
            <p class="text-gray-600 dark:text-gray-300 text-sm">Date</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($salary->salary_date)->format('d/m/Y') }}
            </p>
        </div>

         <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
            <p class="text-gray-600 dark:text-gray-300 text-sm">Salary Account</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">
                {{ $salary->account->account_name }}
            </p>
        </div>

    </div>

    <!-- Salary Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full border border-gray-300 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                <tr class="text-center">
                    <th class="py-2 px-3 border">#</th>
                    <th class="py-2 px-3 border">Employee</th>
                    <th class="py-2 px-3 border">Phone</th>
                    <th class="py-2 px-3 border">Pay Amount</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 0;
                    $total = 0;
                @endphp

                @foreach($salary->salaryDetails as $detail)
                    @if($detail->salary_amount > 0)
                        @php
                            $i++;
                            $total += $detail->salary_amount;
                        @endphp

                        <tr class="text-center border-b dark:border-gray-700 dark:text-gray-200">
                            <td class="py-2 px-3">{{ $i }}</td>
                            <td class="py-2 px-3">{{ $detail->employee->name }}</td>
                            <td class="py-2 px-3">{{ $detail->employee->phone_no }}</td>
                            <td class="py-2 px-3 text-right pr-5">
                                {{ number_format($detail->salary_amount,2) }}
                            </td>
                        </tr>

                    @endif
                @endforeach
            </tbody>

            <tfoot>
                <tr class="bg-gray-100 dark:bg-gray-700 font-bold dark:text-gray-200">
                    <td colspan="3" class="py-2 px-3 text-right">Total</td>
                    <td class="py-2 px-3 text-right pr-5">{{ number_format($total,2) }}</td>
                </tr>
            </tfoot>

        </table>
    </div>

@if ($salary->posting_type == 1)
<div class="mt-6 flex gap-4">
    
    <!-- Approve -->
        <button onclick="approveSalary({{ $salary->salary_id }}, this)" 
            class="px-6 py-2 rounded-lg bg-green-600 text-white hover:bg-red-700"
            title="Approve">
           Approve
        </button>

    <!-- Decline Button (SweetAlert) -->
    <button onclick="openDeclineModal()"
        class="px-6 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
        Decline
    </button>

</div>
@endif


</div>
@push('scripts')
<script>
function openDeclineModal() {

    Swal.fire({
        title: "Decline Salary",
        html: `
            <textarea id="declineRemark" class="swal2-textarea" placeholder="Enter decline reason"></textarea>
        `,
        showCancelButton: true,
        confirmButtonText: "Submit Decline",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#d33",
        preConfirm: () => {
            const remark = document.getElementById('declineRemark').value;
            if (!remark) {
                Swal.showValidationMessage("Remark is required!");
                return false;
            }
            return remark;
        }
    }).then((result) => {
        if (result.isConfirmed) {

            let remark = result.value;

            // Submit using POST
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('salary.salarydecline', $salary->salary_id) }}";

            let token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = "{{ csrf_token() }}";

            let remarkInput = document.createElement('input');
            remarkInput.type = 'hidden';
            remarkInput.name = 'remark';
            remarkInput.value = remark;

            form.appendChild(token);
            form.appendChild(remarkInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function approveSalary(salaryId, btn) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to approve this user?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, approve',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('salary.salaryapprove') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: salaryId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    toastr.success(data.message);
                     setTimeout(() => {
                        window.location.href = "{{ route('salary.index') }}";
                    }, 800);
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
</script>
@endpush
@endsection
