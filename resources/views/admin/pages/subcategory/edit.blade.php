@extends('layouts.main')
@section('content')
<div class="p-6 max-w-5xl mx-auto">

    <!-- Breadcrumb & Back Button -->
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm flex items-center text-gray-600 dark:text-gray-300">
            <ol class="inline-flex items-center space-x-1">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center hover:text-blue-600">
                        <!-- Home Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             class="w-4 h-4 mr-1" 
                             fill="none" 
                             viewBox="0 0 24 24" 
                             stroke="currentColor" 
                             stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m-4 0h8" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>/</li>
                <li class="text-gray-700 dark:text-gray-400">Sub Category Form</li>
            </ol>
        </nav>

        <a href="{{ route('subcategory.index') }}" 
           class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow">
           <!-- List Icon -->
           <svg xmlns="http://www.w3.org/2000/svg" 
                class="w-4 h-4 mr-2" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor" 
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M4 6h16M4 12h16M4 18h16" />
           </svg>
           Sub Category List
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-8 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6 border-b pb-2">Add Sub Category</h2>

        <form id="subcatUpdateForm" class="space-y-6" autocomplete="off">
            @csrf
            @method('PUT')
            <!-- Category Select -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Category <span class="text-red-600">*</span>
                </label>
                <select required id="category_id" name="category_id" 
                        class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg 
                               bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow-sm 
                               focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select --</option>
                    @foreach ($categoris as $item)
                        <option {{ $subcategories->category_id == $item->category_id ? 'selected' : '' }} value="{{ $item->category_id }}">{{ $item->category_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Sub Category Name -->
            <div>
                <label for="sub_cat_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Sub Category <span class="text-red-600">*</span>
                </label>
                <input type="text" required name="sub_cat_name" id="sub_cat_name" 
                       value="{{ old('sub_cat_name',$subcategories->sub_cat_name) }}"
                       class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 
                              bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 
                              focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Sub Category Name BN -->
            <div>
                <label for="sub_cat_name_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Sub Category (BN) <span class="text-red-600">*</span>
                </label>
                <input type="text" required name="sub_cat_name_bn" id="sub_cat_name_bn" 
                       value="{{ old('sub_cat_name_bn',$subcategories->sub_cat_name_bn) }}"
                       class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 
                              bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 
                              focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 
                               text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                    <!-- Save Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         class="w-4 h-4 mr-2" 
                         fill="none" 
                         viewBox="0 0 24 24" 
                         stroke="currentColor" 
                         stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M5 13l4 4L19 7" />
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$("#subcatUpdateForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('subcategory.update',$subcategories->sub_cat_id)}}",
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
                location.href = "{{route('subcategory.index')}}";
            }, 2000)
        },
        error: function(xhr) {
            let responseText = jQuery.parseJSON(xhr.responseText);
            toastr.error(responseText.message);
        },
        complete: function() {
            thisForm.find('button[type="submit"]')
                .prop("disabled", false)
                .removeClass('opacity-50 cursor-not-allowed')
                .text('Save Changes');
        }
    });
});
</script>
@endpush
@endsection
