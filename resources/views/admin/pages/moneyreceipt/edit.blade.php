@extends('layouts.main') 
@section('content')
<div class="p-4 max-w-7xl mx-auto">
    <!-- Breadcrumb & Back Button -->
    <div class="flex justify-between items-center mb-4">
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-reset flex items-center gap-2">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-1 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 9.75L12 3l9 6.75M4.5 10.5V21h15V10.5" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li><span class="text-gray-400 dark:text-gray-500 mx-1">/</span></li>
                <li>
                    <span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 text-xs font-medium shadow-sm">
                         Money Receipt Edit
                    </span>
                </li>
            </ol>
        </nav>

        <a href="{{ route('moneyreceipt.index') }}"
           class="inline-flex items-center gap-1 bg-blue-600 dark:bg-blue-500 text-white text-sm px-3 py-1.5 rounded-full shadow-sm hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-300 ease-in-out">
            View All
        </a>
    </div>
    <!-- Smart Form Card -->
    <div class="bg-white dark:bg-gray-900 shadow-md rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        @if(!empty($invoiceInfo->decline_remarks))
        <div class="mb-4">
            <div class="flex items-center p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8
                    3.582-8 8-8 8 3.582 8 8zm-9-3a1 1 0 012 0v3a1 1 
                    0 01-2 0V7zm1 6a1.25 1.25 0 100-2.5A1.25 
                    1.25 0 0010 13z" clip-rule="evenodd" />
                </svg>
                <span class="truncate">
                    <strong>Decline Remark:</strong> {{ $invoiceInfo->decline_remarks }}
                </span>
            </div>
        </div>
        @endif
        <form id="moneyreciptInsertForm" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="mr_id" value="{{ $invoiceInfo->mr_id }}">

            <!-- Project & Date -->
            <!-- Row 1: Project + Date + Payment Account -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Project -->
    <div>
        <label for="project_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
            Project <span class="text-red-600">*</span>
        </label>
        <select required id="project_id" name="project_id"
            class="project-select w-full px-4 py-2 border rounded-lg shadow-sm
                   focus:ring-2 focus:ring-blue-500 text-sm bg-white dark:bg-gray-800
                   dark:border-gray-600 dark:text-gray-200">
            @foreach ($projects as $value)
                <option value="{{ $value->project_id }}" 
                    {{ $value->project_id == $invoiceInfo->project_id ? 'selected' : '' }}>
                    {{ $value->project_title }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Date -->
    <div>
        <label for="payment_date" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
            Date <span class="text-red-600">*</span>
        </label>
        <input type="text" required name="payment_date" id="payment_date"
               value="{{ old('payment_date', $invoiceInfo->payment_date ? date('d/m/Y', strtotime($invoiceInfo->payment_date)) : '') }}"
               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500
                      text-sm bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200"
               placeholder="dd/mm/yyyy" autocomplete="off">
    </div>

    <!-- Payment Account -->
    <div>
        <label for="account_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
           Receiving Account <span class="text-red-600">*</span>
        </label>
        <select required id="account_id" name="account_id"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 
                   rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 text-sm 
                   bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            <option value="">-- Select --</option>
            @foreach ($accounts as $item)
                <option value="{{ $item->account_id }}" 
                    {{ $invoiceInfo->account_id == $item->account_id ? 'selected' : '' }}>
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

<!-- Amount & Payment Method -->
<div class="flex flex-col md:flex-row gap-4 md:items-end">
    <div class="w-full md:w-2/4">
        <label for="donar_name" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Donor Name/Ref <span class="text-red-600"></span></label>
        <input type="text" id="donar_name" name="donar_name" 
                value="{{ old('donar_name', $invoiceInfo->donar_name ?? '') }}"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 text-sm bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
    </div>
    <div class="w-full md:w-1/4">
        <label for="payment_amount" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Amount <span class="text-red-600">*</span></label>
        <input type="text" required name="payment_amount" id="payment_amount" 
                value="{{ old('payment_amount', $invoiceInfo->payment_amount ?? '') }}"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 text-sm bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
    </div>
    <div class="w-full md:w-1/4">
        <label for="pay_method_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Receiving Method <span class="text-red-600">*</span></label>
        <select id="pay_method_id" name="pay_method_id"
            class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 text-sm bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
            <option value="">-- Select --</option>
            @foreach ($paymentmethod as $item)
                <option value="{{ $item->pay_method_id }}" 
                    {{ $invoiceInfo->pay_method_id == $item->pay_method_id ? 'selected' : '' }}>
                    {{ $item->pay_method_name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

 <!-- Hidden common field (backend will read transaction_no) -->
<input type="hidden" id="transaction_no" name="transaction_no" value="{{ $invoiceInfo->transaction_no ?? '' }}">

<!-- Mobile Banking Fields -->
<div id="mobileFields" class="hidden mt-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Account No <span class="text-red-600"></span>
            </label>
            <input type="text" id="mobile_account_no" name="mobile_account_no"
                   value="{{ old('mobile_account_no', $invoiceInfo->mobile_account_no ?? '') }}"
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
                   value="{{ old('transaction_no', $invoiceInfo->transaction_no ?? '') }}"
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
               Donar Bank  <span class="text-red-600"></span>
            </label>
            <input type="text" id="bank_name" name="bank_name"
                   value="{{ old('bank_name', $invoiceInfo->bank_name ?? '') }}"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 
                          bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 
                          focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                 Account No <span class="text-red-600"></span>
            </label>
            <input type="text" id="bank_account_no" name="bank_account_no"
                   value="{{ old('bank_account_no', $invoiceInfo->bank_account_no ?? '') }}"
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
                   value="{{ old('transaction_no', $invoiceInfo->transaction_no ?? '') }}"
                   class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 
                          bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 
                          focus:ring-2 focus:ring-blue-500">
        </div>

    </div>
</div>

<!-- Remarks -->
<div>
    <label for="payment_remarks" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Details</label>
    <textarea name="payment_remarks" id="payment_remarks" rows="3"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 text-sm bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">{{ old('payment_remarks', $invoiceInfo->payment_remarks ?? '') }}</textarea>
</div>

<!-- Submit Button -->
<div class="flex justify-end">
    <button type="submit" 
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg shadow transition">
        💾 Update Receipt
    </button>
</div>
</form>
</div>
</div>


@push('scripts')
<script>

flatpickr("#payment_date", {
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

// ✔ When page loads (autofill selected account/project)
$(document).ready(function () {
    loadLedger();
});

// ✔ When account changes
$('#account_id').on('change', function () {
    loadLedger();
});

// ✔ When project changes (reload ledger)
$('#project_id').on('change', function () {
    $('#account_id').val("");   
    $('#ledgerInfo').hide();
});

$("#moneyreciptInsertForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('moneyreceipt.update',$invoiceInfo->mr_id)}}",
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
                location.href = "{{route('moneyreceipt.index')}}";
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
