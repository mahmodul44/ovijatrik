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
     @if(!empty($loandataInfo->decline_remarks))
        <div class="mb-4">
            <div class="flex items-center p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8
                    3.582-8 8-8 8 3.582 8 8zm-9-3a1 1 0 012 0v3a1 1 
                    0 01-2 0V7zm1 6a1.25 1.25 0 100-2.5A1.25 
                    1.25 0 0010 13z" clip-rule="evenodd" />
                </svg>
                <span class="truncate">
                    <strong>Decline Remark:</strong> {{ $loandataInfo->decline_remarks }}
                </span>
            </div>
        </div>
        @endif
        <form id="loanUpdateForm" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="loan_transactions_id" value="{{ $loandataInfo->loan_transactions_id }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="project_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Project <span class="text-red-600">*</span>
                    </label>
                    <select required id="project_id" name="project_id"
                        class="project-select w-full px-4 py-2 border rounded-lg shadow-sm
                         focus:ring-2 focus:ring-blue-500 text-sm bg-white dark:bg-gray-800
                         dark:border-gray-600 dark:text-gray-200">
                        @foreach ($projects as $value)
                            <option value="{{ $value->project_id }}" 
                                {{ $value->project_id == $loandataInfo->loan_project ? 'selected' : '' }}>
                                {{ $value->project_title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="loan_account" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Loan Account <span class="text-red-600">*</span>
                    </label>
                    <select id="loan_account" name="loan_account" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none text-sm">
                        <option value=""></option>
                        @foreach ($loanaccounts as $item)
                              <option {{ $loandataInfo->loan_account_id == $item->loan_account_id ? 'selected' : '' }} value="{{ $item->loan_account_id }}">{{ $item->account_name }} - {{ $item->account_no }}</option> 
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
                    <label for="loan_date" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Date <span class="text-red-600">*</span>
                    </label>
                    <input required type="text" name="loan_date" id="loan_date"
                           placeholder="dd/mm/yyyy" autocomplete="off" value="{{ old('loan_date', $loandataInfo->loan_date ? date('d/m/Y', strtotime($loandataInfo->loan_date)) : '') }}"
                           class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm 
                                  bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="loan_amount" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Amount <span class="text-red-600">*</span>
                    </label>
                    <input type="text" required name="loan_amount" id="loan_amount" value="{{ old('loan_amount',$loandataInfo->loan_amount) }}"
                           autocomplete="off"
                           class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm 
                                  bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Remarks -->
            <div>
                <label for="loan_remarks" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                    Details
                </label>
                <textarea name="loan_remarks" id="loan_remarks" rows="3"
                        class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm 
                        bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('loan_remarks',$loandataInfo->loan_remarks) }}</textarea>
            </div>

            <!-- Button -->
            <div class="pt-2">
                <button type="submit"
                        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                    Save
                </button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>

flatpickr("#loan_date", {
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

    function loadProjectLedger(projectId) {
        if (!projectId) {
            $('#projectledgerInfo').hide();
            $('#ledgerInfo').hide();
            return;
        }

        $.ajax({
            url: '/project-total/' + projectId,
            type: 'GET',
            success: function (response) {
                $('#projectledgerInfo').show();
                $('#ledgerInfo').show();

                $('#project_ledger_balance').text(
                    "Project Ledger: " + response.project_total + " BDT"
                );

                let accountHtml = '';
                response.account_wise.forEach(function(item) {
                    accountHtml += `${item.account_name} : ${item.account_total} BDT | `;
                });

                accountHtml = accountHtml.slice(0, -2); // শেষ "| " বাদ
                $('#ledger_balance').html(accountHtml);
            }
        });
    }

    // 🔹 change event
    $('#project_id').on('change', function () {
        let projectId = $(this).val();
        loadProjectLedger(projectId);
    });

    // 🔹 page load এ already selected project থাকলে balance দেখাও
    let initialProjectId = $('#project_id').val();
    if (initialProjectId) {
        loadProjectLedger(initialProjectId);
    }

});


$(document).ready(function () {
    function loadLoanBalance(accountId) {
        if (!accountId) {
            $('#loanInfo').hide();
            return;
        }

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
    }

    // 🔹 change event
    $('#loan_account').on('change', function () {
        let accountId = $(this).val();
        loadLoanBalance(accountId);
    });

    // 🔹 page load এর সময় select এ already selected account থাকলে balance দেখাও
    let initialAccountId = $('#loan_account').val();
    if (initialAccountId) {
        loadLoanBalance(initialAccountId);
    }
});


$("#loanUpdateForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('loan.loanupdate',$loandataInfo->loan_transactions_id)}}",
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
                location.href = "{{route('loan.loanapply')}}";
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
