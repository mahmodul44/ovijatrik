@extends('layouts.main')
@section('content')

<div class="max-w-7xl mx-auto p-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
            Add Salary
        </h2>

        <a href="{{ route('salary.index') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            View All
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-200 dark:border-gray-700">

        <form id="salaryInsertForm" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            
            <!-- Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                
                <!-- Year -->
                <div>
                    <label for="salary_year" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">
                        Salary Year
                    </label>
                    <select name="salary_year" id="salary_year" required
                        class="w-full px-4 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        <option value="{{ date('Y') + 1 }}">{{ date('Y') + 1 }}</option>
                    </select>
                </div>

                <!-- Month -->
                <div>
                    <label for="salary_month" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">
                        Salary Month
                    </label>
                    <select name="salary_month" id="salary_month" required
                        class="w-full px-4 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-800 dark:text-gray-200">
                        <option value="">Select</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label for="salary_date" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">
                        Salary Date
                    </label>
                     <input type="text" required name="salary_date" id="salary_date"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                               focus:outline-none focus:ring-2 focus:ring-blue-500 
                               focus:border-blue-500 shadow-sm"
                        placeholder="dd/mm/yyyy" autocomplete="off">
                </div>

            </div>

<div class="flex flex-col md:flex-row gap-4 md:items-end">    
    <div class="w-full md:w-1/3">
    <label for="account_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Account <span class="text-red-600">*</span></label>
    <input type="hidden" value="10000001" id="project_id" name="project_id">
    <select required id="account_id" name="account_id"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
        <option value="">-- Select --</option>
        @foreach ($accounts as $item)
            <option value="{{ $item->account_id }}">{{ $item->account_name }} ({{ $item->account_no }})</option>
        @endforeach
    </select>
    </div>

    <div class="w-full md:w-1/3">
      <label for="posting_type" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Posting Type <span class="text-red-600">*</span></label>
        <select required id="posting_type" name="posting_type"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            <option value="">-- Select --</option>
            <option value="0">Draft</option>
            <option value="1">Final</option>
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
            @foreach ($paymentmethod as $item)
                <option value="{{ $item->pay_method_id }}">{{ $item->pay_method_name }}</option>
            @endforeach
        </select>
           <input type="hidden" id="transaction_no" name="transaction_no">
    </div>
    </div>

 <div class="w-full md:w-1/4" id="ledgerInfo" style="display:none;">
    <span id="ledger_balance"
        class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
    </span>
</div>


<div id="mobileFields" class="hidden mt-3">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <!-- Mobile Account No -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Account No <span class="text-red-600">*</span>
            </label>
            <input type="text" id="mobile_account_no" name="mobile_account_no"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2
                bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200
                focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Mobile Transaction No -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Transaction No
            </label>
            <input type="text" id="mobile_transaction_no"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2
                bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200
                focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

    </div>
</div>

<div id="bankFields" class="hidden mt-3">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <!-- Bank Account No -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Bank Account No <span class="text-red-600">*</span>
            </label>
            <input type="text" id="bank_account_no" name="bank_account_no"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2
                bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200
                focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Bank Name -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Bank Name <span class="text-red-600">*</span>
            </label>
            <input type="text" id="bank_name" name="bank_name"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2
                bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200
                focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Bank Transaction No -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Transaction No
            </label>
            <input type="text" id="bank_transaction_no"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2
                bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200
                focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

    </div>
</div>

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
            @foreach($employees as $key => $value)
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <!-- Number -->
                    <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-200">
                        {{ $key + 1 }}
                    </td>

                    <!-- Name -->
                    <td class="py-3 px-4 font-medium text-gray-900 dark:text-gray-100">
                        {{ $value->name }}
                    </td>

                    <!-- Position -->
                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                        {{ $value->designation }}
                    </td>

                    <!-- Phone -->
                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                        {{ $value->phone_no }}
                    </td>

                    <!-- Salary Input -->
                    <td class="py-3 px-4">
                        <input type="hidden" name="employees[{{ $value->id }}][id]" value="{{ $value->id }}">

                        <input type="number"
                            name="employees[{{ $value->id }}][salary]"
                            value="{{ $value->salary ?? 0 }}"
                            required
                            class="w-full px-3 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 
                                   border-gray-300 dark:border-gray-600 
                                   text-gray-900 dark:text-gray-100 
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
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


            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2">
                    <span class="esc-loading-button hidden">
                        <i class="fa fa-spinner fa-spin"></i>
                    </span>
                    <span class="submit-btn">Submit</span>
                </button>
            </div>

        </form>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#salary_date", {
        dateFormat: "d/m/Y",
        allowInput: true
    });
});


$('#pay_method_id').on('change', function () {

    let selected = $(this).val();

    $('#mobileFields').addClass('hidden');
    $('#bankFields').addClass('hidden');

    // Clear fields
    $('#mobile_account_no').val('');
    $('#bank_account_no').val('');
    $('#bank_name').val('');
    $('#mobile_transaction_no').val('');
    $('#bank_transaction_no').val('');
    $('#transaction_no').val('');

    // Mobile banking methods
    if (selected === '102' || selected === '103' || selected === '104') {
        $('#mobileFields').removeClass('hidden');
    }

    // Bank
    if (selected === '105') {
        $('#bankFields').removeClass('hidden');
    }
});

// Sync to hidden field (common)
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
                alert(res.message);
                $('#ledgerInfo').hide();
            } else {
                $('#ledger_balance').text("Ledger Balance : " + res.balance + " BDT");
                $('#ledgerInfo').show();
            }
        }
    });
});



function calculateTotalSalary() {
    let total = 0;

    $('input[name*="[salary]"]').each(function () {
        let val = parseFloat($(this).val()) || 0;
        total += val;
    });

    $('#total_salary').text(total.toFixed(2));
}

$(document).ready(function () {
    calculateTotalSalary();

    $(document).on("input", 'input[name*="[salary]"]', function () {
        calculateTotalSalary();
    });
});

$(document).ready(function () {
    $('#salaryInsertForm').on('submit', function (e) {
        e.preventDefault();
        let thisForm = $(this);
        var formData = new FormData(thisForm[0]);

        $.ajax({
            type: "POST",
            url: "{{ route('salary.store') }}",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,

            beforeSend: function () {
                thisForm.find(".esc-loading-button").removeClass('hidden');
                thisForm.find('button[type="submit"]').addClass('opacity-50 cursor-not-allowed');
                thisForm.find('.submit-btn').text('Submitting...');
            },

            success: function (response) {
                toastr.success(response.message);

                setTimeout(function () {
                    location.href = "{{ route('salary.index') }}";
                }, 1000);
            },

            error: function (xhr) {
                var response = $.parseJSON(xhr.responseText);
                toastr.error(response.message);
            }
        });
    });
});
</script>
@endpush
@endsection
