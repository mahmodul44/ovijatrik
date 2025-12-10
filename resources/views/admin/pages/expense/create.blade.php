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
                <li class="text-gray-700 dark:text-gray-300">Expense Form</li>
            </ol>
        </nav>

        <a href="{{ route('expense.index') }}"
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 
                  text-white text-sm font-medium px-4 py-2 rounded-lg shadow-md 
                  transition transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-4 h-4 mr-2" fill="none" 
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h10a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z" />
            </svg>
            Expense List
        </a>
    </div>
    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 p-6">
        
<form id="expenseInsertForm" enctype="multipart/form-data" class="space-y-6">
@csrf
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Expense Category -->
    <div class="w-full">
        <label for="expense_cat_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
            Expense Category <span class="text-red-600">*</span>
        </label>

        <div x-data="{
                open: false,
                search: '',
                selected: '',
                options: {{ Js::from($expenseCat) }},
                get filtered() {
                    if (this.search === '') return this.options;
                    return this.options.filter(o =>
                        o.expense_cat_name.toLowerCase().includes(this.search.toLowerCase())
                    );
                },
                selectOption(opt) {
                    this.selected = opt.expense_cat_id;
                    this.search = opt.expense_cat_name;
                    this.open = false;
                },
                clearIfInvalid() {
                    const match = this.options.find(o => o.expense_cat_name === this.search);
                    if (!match) {
                        this.search = '';
                        this.selected = '';
                    }
                }
            }"
            class="relative">

            <!-- Input -->
            <div class="relative">
                <input type="text"
                    x-model="search"
                    @focus="open = true"
                    @click.away="open = false; clearIfInvalid()"
                    placeholder="Search or select category..."
                    class="w-full px-4 py-2 border rounded-lg shadow-sm
                           bg-white dark:bg-gray-800
                           text-gray-800 dark:text-gray-200
                           border-gray-300 dark:border-gray-600
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           transition duration-200 text-sm pr-8"
                    autocomplete="off">

                <!-- Icon -->
                <svg class="absolute right-2 top-2.5 w-4 h-4 text-gray-500 pointer-events-none"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Dropdown -->
            <div x-show="open"
                class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                       rounded-lg shadow-lg max-h-52 overflow-y-auto"
                x-transition>
                <template x-for="option in filtered" :key="option.expense_cat_id">
                    <div @click="selectOption(option)"
                        class="px-4 py-2 cursor-pointer hover:bg-blue-600 hover:text-white
                               text-gray-700 dark:text-gray-200 text-sm">
                        <span x-text="option.expense_cat_name"></span>
                    </div>
                </template>
                <div x-show="filtered.length === 0"
                    class="px-4 py-2 text-gray-400 dark:text-gray-500 text-sm">
                    No results found
                </div>
            </div>

            <input type="hidden" name="expense_cat_id" x-model="selected">
        </div>
    </div>

    <!-- Date -->
    <div class="w-full">
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

    <!-- Account -->
    <div class="w-full">
        <label for="account_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
            Account <span class="text-red-600"></span>
        </label>

        <input type="hidden" value="10000001" id="project_id" name="project_id">

        <select required id="account_id" name="account_id"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            <option value="">-- Select --</option>
            @foreach ($accounts as $item)
                <option value="{{ $item->account_id }}">
                    {{ $item->account_name }} - {{ $item->account_no }}
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
 <!-- Amount -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
    <label for="expense_amount" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
            Amount <span class="text-red-600">*</span>
    </label>
    <input type="text" required name="expense_amount" id="expense_amount"
        value="{{ old('expense_amount') }}" class="w-full px-4 py-2 border rounded-lg shadow-sm 
            bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-600 
            focus:ring-2 focus:ring-blue-500 text-sm" autocomplete="off">
</div>
  <!-- Payment Method -->
    <div class="md:col-span-1">
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

<!-- Remarks -->
<div>
    <label for="expense_remarks" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
        Remarks
    </label>
    <textarea name="expense_remarks" id="expense_remarks" rows="3"
        class="w-full px-4 py-2 border rounded-lg shadow-sm 
        bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-600 
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
        Save 
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

    // SweetAlert2 confirmation before submission
    Swal.fire({
        title: 'Confirm Submission',
        text: "Are you sure you want to add this expense? This will auto-approve and deduct the account balance.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Submit',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if(result.isConfirmed){

            $.ajax({
                type: "POST",
                url: "{{route('expense.store')}}",
                data: new FormData(thisForm[0]),
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
                    if(response.status){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            location.href = "{{route('expense.index')}}";
                        }, 2000);
                    } else {
                        // Backend returned insufficient balance or other error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: response.message +
                                  (response.balance ? "<br><strong>Current Balance:</strong> "+response.balance : "")
                        });
                    }
                },
                error: function(xhr) {
                    let responseText = jQuery.parseJSON(xhr.responseText);
                    let errorHtml = responseText.message || "Something went wrong!";
                    if(responseText.errors){
                        $.each(responseText.errors, function(key, val){
                            errorHtml += "<br>" + val[0];
                        });
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorHtml
                    });
                },
                complete: function() {
                    thisForm.find('button[type="submit"]')
                        .prop("disabled", false)
                        .removeClass('opacity-50 cursor-not-allowed')
                        .text('Save');
                }
            });

        } else {
            // User cancelled submission
            Swal.fire({
                icon: 'info',
                title: 'Cancelled',
                text: 'Expense submission cancelled.',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });

});


</script>
@endpush
@endsection
