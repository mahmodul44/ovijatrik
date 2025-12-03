@extends('layouts.main') 
@section('content')

<div class="p-3 max-w-7xl mx-auto">
    <!-- Breadcrumb & Back Button -->
<div class="flex justify-between items-center mb-4">
        <nav class="text-sm text-gray-600 dark:text-gray-300">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Dashboard</a>
                </li>
                <li>/</li>
                <li class="text-gray-800 dark:text-gray-200 font-medium">Edit Form</li>
            </ol>
        </nav>
        <a href="{{ route('transfer.index') }}"
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            View All
        </a>
    </div>
    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
        @if(!empty($transferEdit->decline_remarks))
        <div class="mb-4">
            <div class="flex items-center p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8
                    3.582-8 8-8 8 3.582 8 8zm-9-3a1 1 0 012 0v3a1 1 
                    0 01-2 0V7zm1 6a1.25 1.25 0 100-2.5A1.25 
                    1.25 0 0010 13z" clip-rule="evenodd" />
                </svg>
                <span class="truncate">
                    <strong>Decline Remark:</strong> {{ $transferEdit->decline_remarks }}
                </span>
            </div>
        </div>
        @endif
        <form id="transferEditForm" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="mr_id" value="{{ $transferEdit->transfer_id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                 <label for="project_id" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        From Project <span class="text-red-600">*</span>
                    </label>
                    <select id="from_project" name="from_project" 
                        class="project-select w-full px-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
                      @foreach ($projects as $value)
                            <option value="{{ $value->project_id }}" 
                                {{ $value->project_id == $transferEdit->from_project ? 'selected' : '' }}>
                                {{ $value->project_title }}
                            </option>
                        @endforeach
                    </select>
            </div>
            <div>
                <label for="to_project" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        To Project <span class="text-red-600">*</span>
                </label>
                    <select id="to_project" name="to_project" 
                         class="toproject-select w-full px-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
                      @foreach ($projects as $value)
                            <option value="{{ $value->project_id }}" 
                                {{ $value->project_id == $transferEdit->to_project ? 'selected' : '' }}>
                                {{ $value->project_title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="transfer_date" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Date <span class="text-red-600">*</span>
                    </label>
                    <input required type="text" name="transfer_date" id="transfer_date"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                        placeholder="dd/mm/yyyy" autocomplete="off" value="{{ old('transfer_date', $transferEdit->transfer_date ? date('d/m/Y', strtotime($transferEdit->transfer_date)) : '') }}">
                </div>
                <div>
                    <label for="transfer_amount" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Amount <span class="text-red-600">*</span>
                    </label>
                    <input type="text" required name="transfer_amount" id="transfer_amount" value="{{ old('transfer_amount', $transferEdit->transfer_amount ?? '') }}" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" autocomplete="off">
                </div>
            </div>

        <div>
       <label for="transfer_remarks" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
         Details
        </label>
        <textarea name="transfer_remarks" id="transfer_remarks" rows="2" 
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('short_description',$transferEdit->transfer_remarks) }}</textarea>
        </div>
        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg shadow transition">
                💾 Update
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

$("#transferEditForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('transfer.update',$transferEdit->transfer_id)}}",
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
