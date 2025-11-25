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
                <li class="text-gray-700 dark:text-gray-300">Edit Project Expense</li>
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
         @if(!empty($expense->decline_remarks))
        <div class="mb-4">
            <div class="flex items-center p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8
                    3.582-8 8-8 8 3.582 8 8zm-9-3a1 1 0 012 0v3a1 1 
                    0 01-2 0V7zm1 6a1.25 1.25 0 100-2.5A1.25 
                    1.25 0 0010 13z" clip-rule="evenodd" />
                </svg>
                <span class="truncate">
                    <strong>Decline Remark:</strong> {{ $expense->decline_remarks }}
                </span>
            </div>
        </div>
        @endif
<form id="expenseEditForm" enctype="multipart/form-data" class="space-y-6">
@csrf
@method('PUT') 

<div class="flex flex-col md:flex-row md:items-end gap-6">

<div class="w-full md:w-3/4" id="projectSection">
    <label for="project_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
    Project <span class="text-red-600">*</span>
    </label>
    <select id="project_id" name="project_id" class="project-select block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-sm">
        @if($expense->project)
            <option value="{{ $expense->project_id }}" selected>{{ $expense->project->project_title }}</option>
        @endif
    </select>
    <input type="hidden" name="expense_type" value="1"/>
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
        value="{{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}"
        placeholder="dd/mm/yyyy" autocomplete="off">
</div>
<!-- Payment Account -->
    <div>
        <label for="account_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
            Payment Account <span class="text-red-600">*</span>
        </label>
        <select required id="account_id" name="account_id"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 
                   rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 text-sm 
                   bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            <option value="">-- Select --</option>
            @foreach ($accounts as $item)
                <option value="{{ $item->account_id }}" 
                    {{ $expense->account_id == $item->account_id ? 'selected' : '' }}>
                    {{ $item->account_name }} ({{ $item->account_no }})
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
<!-- Amount, Payment Method & Remarks -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <!-- Amount -->
    <div>
        <label for="expense_amount" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
            Amount <span class="text-red-600">*</span>
        </label>
        <input type="text" required name="expense_amount" id="expense_amount"
            value="{{ $expense->expense_amount }}"
            class="w-full px-4 py-2 border rounded-lg shadow-sm 
                bg-white dark:bg-gray-800 
                text-gray-700 dark:text-gray-200 
                border-gray-300 dark:border-gray-600 
                focus:ring-2 focus:ring-blue-500 text-sm"
            autocomplete="off">
    </div>

    <!-- Payment Method -->
    <div>
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
                    {{ $expense->pay_method_id == $item->pay_method_id ? 'selected' : '' }}>
                    {{ $item->pay_method_name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Remarks (2-column width on large screens) -->
    <div class="md:col-span-2">
        <label for="expense_remarks" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
            Remarks
        </label>
        <textarea name="expense_remarks" id="expense_remarks" rows="3"
            class="w-full px-4 py-2 border rounded-lg shadow-sm 
                bg-white dark:bg-gray-800 
                text-gray-700 dark:text-gray-200 
                border-gray-300 dark:border-gray-600 
                focus:ring-2 focus:ring-blue-500 text-sm">{{ $expense->expense_remarks }}</textarea>
    </div>
</div>


<input type="hidden" id="transaction_no" name="transaction_no" value="{{ $expense->transaction_no ?? '' }}">

<!-- Mobile Banking Fields -->
<div id="mobileFields" class="hidden mt-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Account No <span class="text-red-600">*</span>
            </label>
            <input type="text" id="mobile_account_no" name="mobile_account_no"
                   value="{{ old('mobile_account_no', $expense->mobile_account_no ?? '') }}"
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
                   value="{{ old('transaction_no', $expense->transaction_no ?? '') }}"
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
                   value="{{ old('bank_account_no', $expense->bank_account_no ?? '') }}"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 
                          bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 
                          focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Bank Name <span class="text-red-600">*</span>
            </label>
            <input type="text" id="bank_name" name="bank_name"
                   value="{{ old('bank_name', $expense->bank_name ?? '') }}"
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
                   value="{{ old('transaction_no', $expense->transaction_no ?? '') }}"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 
                          bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 
                          focus:ring-2 focus:ring-blue-500">
        </div>

    </div>
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
        Update Expense
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
            return { q: params.term };
        },
        processResults: function (data) {
            return { results: data };
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

$("#expenseEditForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{ route('projectexpense.update', $expense->expense_id) }}",
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
                location.href = "{{ route('projectexpense.index') }}";
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
                .text('Update Expense');
        }
    });
});

</script>
@endpush
@endsection
