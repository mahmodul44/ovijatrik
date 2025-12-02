@extends('layouts.main')
@section('content')
<div class="p-4 max-w-7xl mx-auto">

    <!-- Breadcrumb & Action Button -->
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
                        Add Member Receipt
                    </span>
                </li>
            </ol>
        </nav>

        <a href="{{ route('memberreceipt.index') }}"
           class="inline-flex items-center gap-1 bg-blue-600 dark:bg-blue-500 text-white text-sm px-3 py-1.5 rounded-full shadow-sm hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-300 ease-in-out">
            View All
        </a>
    </div>

<!-- Form Card -->
<div class="bg-white dark:bg-gray-900 shadow-md rounded-xl p-6 space-y-4 border border-gray-200 dark:border-gray-700">
<form id="memberreceiptInsertForm" enctype="multipart/form-data" class="space-y-4">
@csrf

<div class="flex flex-col md:flex-row gap-4 md:items-end">
    <div class="w-full md:w-2/4">
        <label for="member_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
            Member <span class="text-red-600">*</span>
        </label>
        <select required id="member_id" name="member_id" class="member-select block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
        </select>
    </div>
    <div class="w-full md:w-1/4">
        <label for="payment_date" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">
            Date <span class="text-red-600">*</span>
        </label>
        <input required type="text" name="payment_date" id="payment_date"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200"
                placeholder="dd/mm/yyyy" autocomplete="off">
    </div>
</div>
<div class="w-full" id="monthContainer">
    <label id="fiscalYearLabel" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
        Fiscal Year (...)
    </label>

    <div id="fiscalMonths"
         class="grid grid-cols-3 md:grid-cols-4 gap-2 bg-gray-50 dark:bg-gray-800 p-3 rounded-md border border-gray-300 dark:border-gray-600">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">

        <div class="bg-white dark:bg-gray-900 p-3 rounded-md border border-gray-300 dark:border-gray-700 shadow-sm">
            <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                Monthly Amount:
                <span id="monthlyAmount" class="font-semibold text-blue-600 dark:text-blue-400">0</span>
            </p>
        </div>

        <div class="bg-white dark:bg-gray-900 p-3 rounded-md border border-gray-300 dark:border-gray-700 shadow-sm">
            <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                Donated:
                <span id="donatedAmount" class="font-semibold text-green-600 dark:text-green-400">0</span>
            </p>
        </div>

        <div class="bg-white dark:bg-gray-900 p-3 rounded-md border border-gray-300 dark:border-gray-700 shadow-sm">
            <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                Due:
                <span id="dueAmount" class="font-semibold text-red-600 dark:text-red-400">0</span>
            </p>
        </div>

    </div>
     <div id="paidMonthsContainer" class="flex flex-wrap gap-1 mt-2"></div>
</div>


<div class="flex flex-col md:flex-row gap-4 md:items-end">
    <div class="w-full md:w-1/3">
        <label for="payment_amount" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Amount <span class="text-red-600">*</span></label>
        <input type="text" required name="payment_amount" id="payment_amount" value="{{ old('payment_amount') }}" 
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200" autocomplete="off">
    </div>
    
    <div class="w-full md:w-1/3">
    <label for="account_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Receiving Account <span class="text-red-600">*</span></label>
    <select required id="account_id" name="account_id"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
        <option value="">-- Select --</option>
        @foreach ($accounts as $item)
            <option value="{{ $item->account_id }}">{{ $item->account_name }} ({{ $item->account_no }})</option>
        @endforeach
    </select>
    </div>
    <div class="w-full md:w-1/3">
    <label for="pay_method_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Receiving Method <span class="text-red-600">*</span></label>
    <select required id="pay_method_id" name="pay_method_id"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
        <option value="">-- Select --</option>
        @foreach ($paymentmethod as $item)
            <option value="{{ $item->pay_method_id }}">{{ $item->pay_method_name }}</option>
        @endforeach
    </select>
    <input type="hidden" id="transaction_no" name="transaction_no">
    </div>
</div>

<div id="mobileFields" class="hidden mt-3">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <!-- Mobile Account No -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Account No <span class="text-red-600"></span>
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

        <!-- Bank Name -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Donar Bank <span class="text-red-600"></span>
            </label>
            <input type="text" id="bank_name" name="bank_name"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2
                bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200
                focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- Bank Account No -->
        <div>
            <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                Account No <span class="text-red-600"></span>
            </label>
            <input type="text" id="bank_account_no" name="bank_account_no"
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


<div>
    <label for="payment_remarks" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Details</label>
    <textarea name="payment_remarks" id="payment_remarks" rows="3"
         class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">{{ old('payment_remarks') }}</textarea>
</div>

<div>
    <button type="submit"
            class="bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition-colors duration-300 ease-in-out">
        Save
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
    $('.member-select').select2({
        placeholder: "Search by Name, ID, or Mobile",
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: '{{ route("member.search") }}', 
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

    $('.member-select').on('select2:open', function () {
        setTimeout(() => {
            document.querySelector('.select2-container--open .select2-search__field').focus();
        }, 100);
    });
});  


const fiscalMonths = [
    "July", "August", "September", "October", "November", "December",
    "January", "February", "March", "April", "May", "June"
];

function renderFiscalMonths() {
    const now = new Date();
    let startFY, endFY;

    if (now.getMonth() + 1 >= 7) {
        startFY = now.getFullYear();
        endFY = now.getFullYear() + 1;
    } else {
        startFY = now.getFullYear() - 1;
        endFY = now.getFullYear();
    }

    let html = '';

  fiscalMonths.forEach((m, i) => {
        const year = (i < 6) ? startFY : endFY; 
        const month = (i < 6) ? (i + 7) : (i - 5);
        const value = `${year}-${String(month).padStart(2, '0')}`;

        html += `
            <label class="flex items-center space-x-2 text-sm text-gray-800 dark:text-gray-200">
                <input type="checkbox" name="months[]" value="${value}" class="month-checkbox rounded text-blue-600 focus:ring-blue-500">
                <span>${m}</span>
            </label>
        `;
    });
    $("#fiscalMonths").html(html);
}
renderFiscalMonths();

let monthlyAmount = 0;

$('#member_id').on('change', function () {
    let memberId = $(this).val();
    if (!memberId) return;

    $.ajax({
        url: '/member/fiscal-info/' + memberId,
        type: 'GET',
        dataType: 'json',
        success: function (res) {
              let html = "";
            if (res.paid_months && res.paid_months.length > 0) {
                res.paid_months.forEach(function (m) {

                    // Convert "2024-08" → "Aug 2024"
                    let parts = m.split("-");
                    let year = parts[0];
                    let month = parts[1];

                    let monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                    let formatted = monthNames[parseInt(month) - 1] + " " + year;

                    html += `
                        <span class="px-2 py-1 rounded-md text-xs font-semibold 
                               bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200">
                            ${formatted}
                        </span>
                    `;
                });
            }

            $("#paidMonthsContainer").html(html);
            $('#fiscalYearLabel').text("Fiscal Year (" + res.fiscal_year + ")");
            $('#monthlyAmount').text(res.monthly_amount);
            $('#donatedAmount').text(res.donated_amount);
            $('#dueAmount').text(res.due_amount);
            monthlyAmount = parseFloat(res.monthly_amount);

            $('.month-checkbox').prop('checked', false);
            $('#payment_amount').val('');
        },
        error: function () {
            toastr.error('Unable to fetch fiscal info.');
        }
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


$(document).on('change', '.month-checkbox', function () {
    let checkedCount = $('.month-checkbox:checked').length;
    let total = monthlyAmount * checkedCount;
    $('#payment_amount').val(total);
});

$("#memberreceiptInsertForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('memberreceipt.store')}}",
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
                location.href = "{{route('memberreceipt.index')}}";
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
