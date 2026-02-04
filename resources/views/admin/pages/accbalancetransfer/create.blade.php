@extends('layouts.main')
@section('content')
<div class="p-3 max-w-7xl mx-auto">

    <!-- Breadcrumb & Add Button -->
    <div class="flex justify-between items-center mb-4">
        <nav class="text-sm text-gray-600 dark:text-gray-300">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Dashboard</a>
                </li>
                <li>/</li>
                <li class="text-gray-800 dark:text-gray-200 font-medium">Add New</li>
            </ol>
        </nav>
        <a href="{{ route('accbalancetransfer.index') }}"
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            View All
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-2xl p-8 border border-gray-200 dark:border-gray-700">

        <form id="accbalancetransferInsertForm" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="from_account" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        From Account <span class="text-red-600">*</span>
                    </label>
                    <select required id="from_account" name="from_account"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                
                <option value="">-- Select Account --</option>

                @foreach ($accounts->groupBy('account_type') as $type => $items)
                    <optgroup label="{{ strtoupper($type == 1 ? 'MEMBERSHIP ACCOUNTS' : 'OTHER ACCOUNTS') }}" class="bg-gray-100 dark:bg-gray-700 font-bold text-blue-400">
                        @foreach ($items as $item)
                            <option data-account-no="{{ $item->account_no }}" data-bank-name="{{ $item->bank_name }}" value="{{ $item->account_id }}" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                                {{ $item->bank_name }} - {{ $item->account_no }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            <p class="mt-2 text-sm text-white">
                        Current Balance: <span id="from_balance">--</span>
                    </p>
                    
                <div id="from_reference_wrap" class="hidden mt-3">
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                    From Account Reference
                </label>
                <input type="text" name="from_reference"
                    class="block w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 text-sm">
            </div>

     
                </div>
                <div>
                    <label for="to_account" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        To Account <span class="text-red-600">*</span>
                    </label>
                    <select required id="to_account" name="to_account"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                
                <option value="">-- Select Account --</option>

                @foreach ($accounts->groupBy('account_type') as $type => $items)
                    <optgroup label="{{ strtoupper($type == 1 ? 'MEMBERSHIP ACCOUNTS' : 'OTHER ACCOUNTS') }}" class="bg-gray-100 dark:bg-gray-700 font-bold text-blue-400">
                        @foreach ($items as $item)
                            <option data-account-no="{{ $item->account_no }}" data-bank-name="{{ $item->bank_name }}" value="{{ $item->account_id }}" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                                {{ $item->bank_name }} - {{ $item->account_no }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
             <p class="mt-2 text-sm text-white">
                        Current Balance: <span id="to_balance">--</span>
                    </p>
                <div id="to_reference_wrap" class="hidden mt-3">
                <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                    To Account Reference
                </label>
                <input type="text" name="to_reference"
                    class="block w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 text-sm">
                </div>

                   
                </div>
            </div>

            <!-- Date & Amount -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="transfer_date" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Date <span class="text-red-600">*</span>
                    </label>
                    <input required type="text" name="transfer_date" id="transfer_date"
                           placeholder="dd/mm/yyyy" autocomplete="off"
                           class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm 
                                  bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="transfer_amount" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Amount <span class="text-red-600">*</span>
                    </label>
                    <input type="text" required name="transfer_amount" id="transfer_amount" value="{{ old('transfer_amount') }}"
                           autocomplete="off"
                           class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm 
                                  bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="transfer_fee" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Fee <span class="text-red-600"></span>
                    </label>
                    <input type="text" name="transfer_fee" id="transfer_fee" value="{{ old('transfer_fee') }}"
                           autocomplete="off"
                           class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm 
                                  bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Remarks -->
            <div>
                <label for="transfer_remarks" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                    Details
                </label>
                <textarea name="transfer_remarks" id="transfer_remarks" rows="3"
                          class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm 
                                 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('short_description') }}</textarea>
            </div>

            <!-- Button -->
            <div class="pt-2">
                <button type="submit"
                        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                    Save Transfer
                </button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>

flatpickr("#transfer_date", {
    dateFormat: "d/m/Y",
    allowInput: true
});

function toggleReference(selectId, wrapperId) {
    let selected = $(selectId + ' option:selected');
    let accountNo = selected.data('account-no');
    let accountType = selected.data('bank-name');

    if (accountType != 0 && accountNo) {
        $(wrapperId).removeClass('hidden');
    } else {
        $(wrapperId).addClass('hidden')
            .find('input').val('');
    }
}

$('#from_account').on('change', function () {
    toggleReference('#from_account', '#from_reference_wrap');
});

$('#to_account').on('change', function () {
    toggleReference('#to_account', '#to_reference_wrap');
});

$("#accbalancetransferInsertForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    let fromAccount = $('#from_account').val();
    let toAccount = $('#to_account').val();

    if(fromAccount && toAccount && fromAccount === toAccount){
        toastr.error('From Account and To Account cannot be the same.');
        return; 
    }

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to transfer this balance?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, transfer it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "{{route('accbalancetransfer.store')}}",
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
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.href = "{{route('accbalancetransfer.index')}}";
                    }, 2000)
                },
                error: function(xhr) {
                    let responseText = jQuery.parseJSON(xhr.responseText);
                    toastr.error(responseText.message);
                    
                    thisForm.find('.text-danger').text(''); 
                    
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
        }
    });
});

$(document).ready(function () {

    $('#from_account').on('change', function () {
        let accountId = $(this).val();

        if (accountId === '') {
            $('#from_balance').text('--');
            return;
        }

        $.ajax({
            url: "{{ route('account.balance') }}",
            type: "GET",
            data: { account_id: accountId },
            success: function (res) {
                if (res.status) {
                    $('#from_balance').text(res.balance);
                } else {
                    $('#from_balance').text('0');
                }
            }
        });
    });

});

$(document).ready(function () {

    $('#to_account').on('change', function () {
        let accountId = $(this).val();

        if (accountId === '') {
            $('#to_balance').text('--');
            return;
        }

        $.ajax({
            url: "{{ route('account.balance') }}",
            type: "GET",
            data: { account_id: accountId },
            success: function (res) {
                if (res.status) {
                    $('#to_balance').text(res.balance);
                } else {
                    $('#to_balance').text('0');
                }
            }
        });
    });

});

</script>
@endpush
@endsection
