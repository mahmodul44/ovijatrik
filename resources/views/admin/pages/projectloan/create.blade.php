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
        <a href="{{ route('transfer.index') }}"
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            View All
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-2xl p-8 border border-gray-200 dark:border-gray-700">

        <form id="loanInsertForm" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Project Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="project_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Project <span class="text-red-600">*</span>
                    </label>
                    <select id="project_id" name="project_id" class="project-select block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-sm"> 

                    </select>
                </div>
                <div>
                    <label for="loan_account" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Loan Account <span class="text-red-600">*</span>
                    </label>
                    <select id="loan_account" name="loan_account" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-sm">
                        <option value=""></option>
                        @foreach ($loanaccounts as $item)
                              <option value="{{ $item->loan_account_id }}">{{ $item->account_name }} - {{ $item->account_no }}</option> 
                        @endforeach
                     
                    </select>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 md:items-end">
            <div class="w-full md:w-1/4" id="projectledgerInfo" style="display:none;">
                <span id="project_ledger_balance"
                class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
                </span>
            </div>
            <div class="w-full md:w-2/4" id="ledgerInfo" style="display:none;">
              <span id="ledger_balance"
                class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
              </span>
            </div>
            <div class="w-full md:w-1/4" id="loanInfo" style="display:none;">
              <span id="loan_balance"
                class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
              </span>
            </div>
            </div>

            <!-- Date & Amount -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
    $('.toproject-select').select2({
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

    $('.toproject-select').on('select2:open', function () {
        setTimeout(() => {
            document.querySelector('.select2-container--open .select2-search__field').focus();
        }, 100);
    });
});

$(document).ready(function () {
    $('#project_id').on('change', function () {
        let projectId = $(this).val();

        if (projectId) {
            $.ajax({
                url: '/project-total/' + projectId,
                type: 'GET',
                success: function (response) {
                    $('#projectledgerInfo').show();
                    $('#ledgerInfo').show();

                    // ✅ Project Total
                    $('#project_ledger_balance').text(
                        "Project Ledger: " + response.project_total + " BDT"
                    );

                    // ✅ Account Wise Show
                    let accountHtml = '';
                    response.account_wise.forEach(function(item) {
                        accountHtml += `${item.account_name} : ${item.account_total} BDT | `;
                    });

                    // শেষের | কেটে ফেলতে চাইলে
                    accountHtml = accountHtml.slice(0, -2);

                    $('#ledger_balance').html(accountHtml);
                }
            });
        }
    });
});


$('#loan_account').on('change', function () {
    let accountId = $(this).val();

    $.ajax({
        url: '/get-loanaccount-ledger',
        type: 'POST',
        data: {
            account_id: accountId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            if (res.status === 'no_account') {
                toastr.error(res.message);
                $('#loanInfo').hide();
            } else {
                $('#loan_balance').text("Loan Account : " + res.balance + " BDT");
                $('#loanInfo').show();
            }
        }
    });
});

$("#loanInsertForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    let fromProject = $('#project_id').val();
    let toProject = $('#to_project').val();

    // Check if From Project and To Project are the same
    if(fromProject && toProject && fromProject === toProject){
        toastr.error('From Project and To Project cannot be the same.');
        return; 
    }

    $.ajax({
        type: "POST",
        url: "{{route('transfer.store')}}",
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
                location.href = "{{route('transfer.index')}}";
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
