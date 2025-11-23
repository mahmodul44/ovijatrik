@extends('layouts.main')
@section('content')
<div class="p-6 max-w-5xl mx-auto">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-3 md:mb-0" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                        Dashboard
                    </a>
                </li>
                <li>
                    <span class="mx-2 text-gray-400 dark:text-gray-500">/</span>
                </li>
                <li class="text-gray-700 dark:text-gray-200 font-medium">Account Form</li>
            </ol>
        </nav>
       
        <a href="{{ route('account.index') }}"
        class="inline-flex items-center gap-1 bg-blue-600 dark:bg-blue-500 
                text-white text-sm px-3 py-1.5 rounded-full shadow-sm 
                hover:bg-blue-700 dark:hover:bg-blue-600 
                transition-colors duration-300 ease-in-out">
            Account List
        </a>
    </div>

    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-8 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6 border-b border-gray-200 dark:border-gray-700 pb-3">
            Add New 
        </h2>

        <form id="accountInsertForm" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="flex flex-col md:flex-row md:items-end gap-4">
                <div class="w-full">
                    <label for="account_name" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Account Name <span class="text-red-600">*</span>
                    </label>
                    <input type="text" required name="account_name" id="account_name" value="{{ old('account_name') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition"/>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-end gap-4">
                <div class="w-full">
                    <label for="account_no" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                       Account No <span class="text-red-600">*</span>
                    </label>
                    <input type="text" required name="account_no" id="account_no" value="{{ old('account_no') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition"/>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-end gap-4">
                <div class="w-full">
                <label for="account_type" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">
                    Account Type <span class="text-red-600">*</span>
                </label>
                    <select required id="account_type" name="account_type"
                      class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm
                        focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm
                        bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                        <option value=""></option>
                        <option value="2">Bkash</option>
                        <option value="3">Nagad</option>
                        <option value="4">Bank</option>
                        <option value="5">Rocket</option>
                    </select>
               </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-end gap-4">
                <div class="w-full">
                    <label for="bank_name" class="block text-gray-700 dark:text-gray-200 font-medium mb-2">
                        Bank Name <span class="text-red-600"></span>
                    </label>
                    <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition"/>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$("#accountInsertForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    let account_name = $('#account_name').val().trim();
    let account_no = $('#account_no').val().trim();

    if (!account_name || !account_no) {
        toastr.error('Please fill all required fields');
        return;
    }

    $.ajax({
        type: "POST",
        url: "{{route('account.store')}}",
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
                location.href = "{{route('account.index')}}";
            }, 1500);
        },
        error: function(xhr) {
            let responseText = jQuery.parseJSON(xhr.responseText);
            toastr.error(responseText.message);
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
