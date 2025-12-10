@extends('layouts.main')
@section('content')

<div class="max-w-7xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Edit Salary</h2>
        <a href="{{ route('salary.index') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            View All
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <form id="salaryUpdateForm" method="POST" autocomplete="off">
            @csrf
            @method('PUT')

            <!-- Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="salary_year" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Salary Year</label>
                    <select name="salary_year" id="salary_year" required
                        class="w-full px-4 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="{{ date('Y') - 1 }}" {{ $salaries->salary_year == date('Y') - 1 ? 'selected' : '' }}>{{ date('Y') - 1 }}</option>
                        <option value="{{ date('Y') }}" {{ $salaries->salary_year == date('Y') ? 'selected' : '' }}>{{ date('Y') }}</option>
                        <option value="{{ date('Y') + 1 }}" {{ $salaries->salary_year == date('Y') + 1 ? 'selected' : '' }}>{{ date('Y') + 1 }}</option>
                    </select>
                </div>

                <div>
                    <label for="salary_month" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Salary Month</label>
                    <select name="salary_month" id="salary_month" required
                        class="w-full px-4 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-800 dark:text-gray-200">
                        @php
                        $months = [
                            1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',
                            7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'
                        ];
                        @endphp
                        <option value="">Select</option>
                        @foreach($months as $key => $month)
                        <option value="{{ $key }}" {{ $salaries->salary_month == $key ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="salary_date" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Salary Date</label>
                    <input type="text" name="salary_date" id="salary_date" required
                        class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="dd/mm/yyyy" value="{{ \Carbon\Carbon::parse($salaries->salary_date)->format('d/m/Y') }}">
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4 md:items-end">    
    <div class="w-full md:w-1/3">
    <label for="account_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Account <span class="text-red-600">*</span></label>
    <input type="hidden" value="{{  $salaries->project_id }}" id="project_id" name="project_id">
    <select required id="account_id" name="account_id"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
        <option value="">-- Select --</option>
        @foreach ($accounts as $item)
            <option value="{{ $item->account_id }}" {{ $salaries->account_id == $item->account_id ? 'selected' : '' }}>{{ $item->account_name }} ({{ $item->account_no }})</option>
        @endforeach
    </select>
    </div>

    <div class="w-full md:w-1/3">
      <label for="posting_type" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Posting Type <span class="text-red-600">*</span></label>
        <select required id="posting_type" name="posting_type"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            <option value="">-- Select --</option>
            <option value="0" {{ $salaries->posting_type == '0' ? 'selected' : '' }}>Draft</option>
            <option value="1" {{ $salaries->posting_type == '1' ? 'selected' : '' }}>Final</option>
       </select>
     </div>

     <!-- Payment Method -->
    <div class="w-full md:w-1/3">
        <label for="pay_method_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
            Payment Method <span class="text-red-600">*</span>
        </label>
        <select required id="pay_method_id" name="pay_method_id"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm 
                focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm 
                bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            <option value="">-- Select --</option>
            @foreach ($paymentmethod as $item)
                <option value="{{ $item->pay_method_id }}" 
                    {{ $salaries->pay_method_id == $item->pay_method_id ? 'selected' : '' }}>
                    {{ $item->pay_method_name }}
                </option>
            @endforeach
        </select>
    </div>

    </div>

<div class="w-full md:w-1/4" id="ledgerInfo" style="display:none;">
    <span id="ledger_balance"
       class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
    </span>
</div>
     <!-- Hidden common field (backend will read transaction_no) -->
<input type="hidden" id="transaction_no" name="transaction_no" value="{{ $salaries->transaction_no ?? '' }}">

<!-- Mobile Banking Fields -->
<div id="mobileFields" class="hidden mt-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Account No <span class="text-red-600">*</span>
            </label>
            <input type="text" id="mobile_account_no" name="mobile_account_no"
                   value="{{ old('mobile_account_no', $salaries->mobile_account_no ?? '') }}"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 
                          bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 
                          focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Transaction No
            </label>
            <!-- visible mobile transaction field -->
            <input type="text" id="mobile_transaction_no"
                   value="{{ old('transaction_no', $salaries->transaction_no ?? '') }}"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 
                          bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 
                          focus:ring-2 focus:ring-blue-500">
        </div>

    </div>
</div>

<!-- Bank Payment Fields -->
<div id="bankFields" class="hidden mt-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Bank Account No <span class="text-red-600">*</span>
            </label>
            <input type="text" id="bank_account_no" name="bank_account_no"
                   value="{{ old('bank_account_no', $salaries->bank_account_no ?? '') }}"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 
                          bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 
                          focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Bank Name <span class="text-red-600">*</span>
            </label>
            <input type="text" id="bank_name" name="bank_name"
                   value="{{ old('bank_name', $salaries->bank_name ?? '') }}"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 
                          bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 
                          focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Transaction No
            </label>
            <!-- visible bank transaction field -->
            <input type="text" id="bank_transaction_no"
                   value="{{ old('transaction_no', $salaries->transaction_no ?? '') }}"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 
                          bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 
                          focus:ring-2 focus:ring-blue-500">
        </div>

    </div>
</div>
            <!-- Employees Table -->
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 mt-4">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <th class="py-3 px-4 border dark:border-gray-600">#</th>
                            <th class="py-3 px-4 border dark:border-gray-600">Employee Name</th>
                            <th class="py-3 px-4 border dark:border-gray-600">Position</th>
                            <th class="py-3 px-4 border dark:border-gray-600">Phone No</th>
                            <th class="py-3 px-4 border dark:border-gray-600">Salary Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
    @foreach($employees as $key => $emp)
    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
        <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-200">{{ $key+1 }}</td>
        <td class="py-3 px-4 font-medium text-gray-900 dark:text-gray-100">{{ $emp->name }}</td>
        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $emp->designation }}</td>
        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $emp->phone_no }}</td>

        <td class="py-3 px-4">

            @php
                $detail = $salaries->salaryDetails->firstWhere('employee_id', $emp->id);
                $salary_amount = $detail->salary_amount ?? 0;
            @endphp

            <input type="hidden" name="employees[{{ $emp->id }}][id]" value="{{ $emp->id }}">

            <input type="number"
                name="employees[{{ $emp->id }}][salary]"
                value="{{ $salary_amount }}"
                required
                class="w-full px-3 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
        </td>
    </tr>
    @endforeach
</tbody>
   <tfoot>
    <tr class="bg-gray-200 dark:bg-gray-700 font-semibold text-gray-900 dark:text-gray-100">
        <td colspan="4" class="py-3 px-4 text-right border dark:border-gray-600">
            Total Salary:
        </td>
        <td class="py-3 px-4 border dark:border-gray-600">
            <span id="total_salary">0</span>
        </td>
    </tr>
</tfoot>

                </table>
            </div>

            <!-- Submit -->
            <div class="mt-6">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2">
                    <span class="esc-loading-button hidden">
                        <i class="fa fa-spinner fa-spin"></i>
                    </span>
                    <span class="submit-btn">Update</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#salary_date", { dateFormat: "d/m/Y", allowInput: true });
});


$(document).ready(function () {
    $('#mobileFields').addClass('hidden');
    $('#bankFields').addClass('hidden');

    let selected = $('#pay_method_id').val();
    if (selected === '102' || selected === '103' || selected === '104') {
        $('#mobileFields').removeClass('hidden');
    } else if (selected === '105') {
        $('#bankFields').removeClass('hidden');
    }

    let existingTx = $('#transaction_no').val() || '';
    if (existingTx) {
        $('#mobile_transaction_no').val(existingTx);
        $('#bank_transaction_no').val(existingTx);
    }
});


$('#pay_method_id').on('change', function () {
    let selected = $(this).val();

    $('#mobileFields').addClass('hidden');
    $('#bankFields').addClass('hidden');

    if (selected === '102' || selected === '103' || selected === '104') {
        $('#mobileFields').removeClass('hidden');
    } else if (selected === '105') {
        $('#bankFields').removeClass('hidden');
    }
});

$('#mobile_transaction_no').on('input', function () {
    $('#transaction_no').val($(this).val());
});

$('#bank_transaction_no').on('input', function () {
    $('#transaction_no').val($(this).val());
});


$('#account_id').on('change', function () {
    let accountId = $(this).val();
    let projectId = $('#project_id').val();

    if (!projectId) {
        toastr.error("Please select Project first!");
        $('#account_id').val('');    
        return;
    }

    $.ajax({
        url: '/get-project-ledger',
        type: 'POST',
        data: {
            account_id: accountId,
            project_id: projectId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            if (res.status === 'no_project') {
                toastr.error(res.message);
                $('#ledgerInfo').hide();
            } else {
                $('#ledger_balance').text("Ledger Balance : " + res.balance + " BDT");
                $('#ledgerInfo').show();
            }
        }
    });
});

function loadLedger() {
    let accountId = $('#account_id').val();
    let projectId = $('#project_id').val();

    if (!accountId || !projectId) {
        $('#ledgerInfo').hide();
        return;
    }

    $.ajax({
        url: '/get-project-ledger',
        type: 'POST',
        data: {
            account_id: accountId,
            project_id: projectId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            if (res.status === 'no_project') {
                toastr.error(res.message);
                $('#ledgerInfo').hide();
            } else {
                $('#ledger_balance').text("Ledger Balance : " + res.balance + " BDT");
                $('#ledgerInfo').removeClass('hidden').show();
            }
        }
    });
}

$(document).ready(function () {
    loadLedger();
});

$('#account_id').on('change', function () {
    loadLedger();
});

$('#project_id').on('change', function () {
    $('#account_id').val("");   
    $('#ledgerInfo').hide();
});

function calculateTotalSalary() {
    let total = 0;

    $('input[name*="[salary]"]').each(function () {
        let val = parseFloat($(this).val()) || 0;
        total += val;
    });

    $('#total_salary').text(total.toFixed(2));
}

// Auto calculate on page load
$(document).ready(function () {
    calculateTotalSalary();

    // Auto calculate whenever salary changes
    $(document).on("input", 'input[name*="[salary]"]', function () {
        calculateTotalSalary();
    });
});

$('#salaryUpdateForm').on('submit', function(e) {
    e.preventDefault();
    let form = $(this);
    var formData = new FormData(this);

    $.ajax({
        type: "POST",
        url: "{{ route('salary.update', $salaries->salary_id) }}",
        data: formData,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            form.find(".esc-loading-button").removeClass('hidden');
            form.find('.submit-btn').text('Updating...');
        },
        success: function(res) {
            toastr.success(res.message);
            setTimeout(function() { window.location.href = "{{ route('salary.index') }}"; }, 1000);
        },
        error: function(xhr) {
            var res = $.parseJSON(xhr.responseText);
            toastr.error(res.message);
        }
    });
});
</script>
@endpush

@endsection
