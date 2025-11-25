@extends('layouts.main')
@section('content')
<div class="p-3 max-w-7xl mx-auto">

   <!-- Breadcrumb & Back Button -->
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm text-gray-500 dark:text-gray-400">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="text-blue-600 dark:text-blue-400 hover:underline">
                        Dashboard
                    </a>
                </li>
                <li>/</li>
                <li class="text-gray-700 dark:text-gray-300">Project Wise Expense Form</li>
            </ol>
        </nav>

        <a href="{{ route('projectexpense.index') }}"
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 
                  text-white text-sm font-medium px-4 py-2 rounded-lg shadow-md 
                  transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-4 h-4 mr-2" fill="none" 
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h10a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z" />
            </svg>
            Project Expense List
        </a>
    </div>
    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 p-6">
        
<form id="expenseInsertForm" enctype="multipart/form-data" class="space-y-6">
@csrf

    <div class="flex flex-col md:flex-row md:items-end gap-6">

    <div class="w-full md:w-2/4" id="projectSection">
        <label for="project_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
        Project <span class="text-red-600">*</span>
        </label>
        <select required id="project_id" name="project_id" class="project-select block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-sm">
        </select>
    </div>

    <div>
        <label for="expense_date" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
        Date <span class="text-red-600">*</span>
        </label>
        <input type="text" required name="expense_date" id="expense_date"
        class="w-full px-4 py-2 border rounded-lg shadow-sm 
            bg-white dark:bg-gray-800 
            text-gray-700 dark:text-gray-200 
            border-gray-300 dark:border-gray-600 
            focus:ring-2 focus:ring-blue-500 text-sm"
            placeholder="dd/mm/yyyy" autocomplete="off">
        </div>
        <div class="w-full md:w-1/4">
            <label for="account_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Account <span class="text-red-600">*</span></label>
            <select required id="account_id" name="account_id"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                <option value="">-- Select --</option>
                @foreach ($accounts as $item)
                <option value="{{ $item->account_id }}">{{ $item->account_name }} - {{ $item->account_no }}</option>
                @endforeach
            </select>
        </div>
    </div>
 <div class="w-full md:w-1/4" id="ledgerInfo" style="display:none;">
    <span id="ledger_balance"
        class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
    </span>
</div>
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="expense_amount" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
                Amount <span class="text-red-600">*</span>
            </label>
            <input type="text" required name="expense_amount" id="expense_amount"
                value="{{ old('expense_amount') }}"
                class="w-full px-4 py-2 border rounded-lg shadow-sm 
                    bg-white dark:bg-gray-800 
                    text-gray-700 dark:text-gray-200 
                    border-gray-300 dark:border-gray-600 
                    focus:ring-2 focus:ring-blue-500 text-sm"
                autocomplete="off">
        </div>

        <!-- Payment Method -->
        <div>
            <label for="pay_method_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Payment Method <span class="text-red-600">*</span>
            </label>
            <select required id="pay_method_id" name="pay_method_id"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm 
                    bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                <option value="">-- Select --</option>
                @foreach ($paymentmethod as $item)
                    <option value="{{ $item->pay_method_id }}">{{ $item->pay_method_name }}</option>
                @endforeach
            </select>
            <input type="hidden" id="transaction_no" name="transaction_no">
        </div>
    </div>

    <div>
        <label for="receiver_name" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
            Receiver Name <span class="text-red-600">*</span>
        </label>
        <input name="receiver_name" id="receiver_name" rows="3"
            class="w-full px-4 py-2 border rounded-lg shadow-sm 
                bg-white dark:bg-gray-800 
                text-gray-700 dark:text-gray-200 
                border-gray-300 dark:border-gray-600 
                focus:ring-2 focus:ring-blue-500 text-sm" value="{{ old('receiver_name') }}" autocomplete="off">
    </div>
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
                focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
        </div>

        <!-- Mobile Transaction No -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Transaction No
            </label>
            <input type="text" id="mobile_transaction_no"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2
                bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200
                focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
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
                focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
        </div>

        <!-- Bank Name -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Bank Name <span class="text-red-600">*</span>
            </label>
            <input type="text" id="bank_name" name="bank_name"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2
                bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200
                focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
        </div>

        <!-- Bank Transaction No -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Transaction No
            </label>
            <input type="text" id="bank_transaction_no"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2
                bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200
                focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
        </div>

    </div>
</div>


<div>
        <label for="expense_remarks" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
            Remarks
        </label>
        <textarea name="expense_remarks" id="expense_remarks" rows="3"
            class="w-full px-4 py-2 border rounded-lg shadow-sm 
                bg-white dark:bg-gray-800 
                text-gray-700 dark:text-gray-200 
                border-gray-300 dark:border-gray-600 
                focus:ring-2 focus:ring-blue-500 text-sm">{{ old('expense_remarks') }}</textarea>
    </div>
<!-- Submit -->
<div class="flex justify-end">
    <button type="submit" 
            class="inline-flex items-center px-6 py-2 
                    bg-blue-600 hover:bg-blue-700 
                    text-white font-medium rounded-lg shadow-md 
                    transition transform hover:scale-105">
        <svg xmlns="http://www.w3.org/2000/svg" 
                class="w-5 h-5 mr-2" fill="none" 
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        Save Expense
    </button>
</div>

</form>
</div>
</div>

@push('scripts')
<script>

flatpickr("#expense_date", {
    dateFormat: "d/m/Y",
    allowInput: true
});

$(document).ready(function () {
    $('.project-select').select2({
        placeholder: "Search by Name Or Code",
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: '{{ route("project.search") }}', 
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term 
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('.project-select').on('select2:open', function () {
        setTimeout(() => {
            document.querySelector('.select2-container--open .select2-search__field').focus();
        }, 100);
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


$("#expenseInsertForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('projectexpense.store')}}",
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            thisForm.find('button[type="submit"]')
                .prop("disabled", true)
                .addClass('opacity-50 cursor-not-allowed')
                .text('Submitting...');
        },
        success: function (response) {
            toastr.success(response.message);
            setTimeout(function() {
                location.href = "{{route('projectexpense.index')}}";
            }, 2000)
        },
         error: function(xhr) {
            let responseText = jQuery.parseJSON(xhr.responseText);
            toastr.error(responseText.message);
            $.each(responseText.errors, function(key, val) {
                thisForm.find("." + key + "-error").text(val[0]);
            });
        },

         complete: function() {
            thisForm.find('button[type="submit"]')
                .prop("disabled", false)
                .removeClass('opacity-50 cursor-not-allowed')
                .text('Save');
        }
    });
});

</script>
@endpush
@endsection
