@extends('layouts.main')
@section('content')
<div class="p-3 max-w-7xl mx-auto font-sans transition-colors duration-300 bg-gray-50 dark:bg-gray-900 min-h-screen">

    <!-- Breadcrumb -->
    <nav class="text-sm mb-6 text-gray-600 dark:text-gray-400">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Dashboard</a>
            </li>
            <li>/</li>
            <li class="text-gray-800 dark:text-gray-200 font-semibold">Gallery Form</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-800/90 backdrop-blur-xl border border-gray-200 dark:border-gray-700 rounded-2xl shadow-lg p-8 transition-all duration-300 hover:shadow-xl">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 7l9 6 9-6-9-6-9 6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
                    Create New Gallery
                </h2>
            </div>
            <a href="{{ route('gallery.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>

        <!-- Form -->
        <form id="galleryCreateForm" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Category <span class="text-red-600">*</span></label>
                <select required id="category_id" name="category_id"
                        class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm transition">
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->category_id }}">{{ $item->category_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Title -->
            <div>
                <label for="title" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Title <span class="text-red-600">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full bg-gray-50 dark:bg-gray-900/60 text-gray-800 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 transition placeholder-gray-400 dark:placeholder-gray-500"
                       placeholder="Enter gallery title">
            </div>
            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Upload Image <span class="text-red-600">*</span></label>
                <input type="file" name="image" id="image" required
                       class="block w-full text-sm text-gray-600 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 
                              file:rounded-md file:border-0 file:bg-blue-600 dark:file:bg-blue-500 file:text-white 
                              hover:file:bg-blue-700 dark:hover:file:bg-blue-600 cursor-pointer border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2.5 bg-gray-50 dark:bg-gray-900/60 transition">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Supported formats: JPG, PNG, GIF, MAX:1MB</p>
            </div>

            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                        class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-2.5 
                               bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 
                               text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7" />
                    </svg>
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$("#galleryCreateForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{ route('gallery.store') }}",
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            thisForm.find('button[type="submit"]')
                .prop("disabled", true)
                .addClass('opacity-50 cursor-not-allowed')
                .html('<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 animate-spin mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="4" stroke="currentColor" class="opacity-25"/><path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="4" class="opacity-75"/></svg> Submitting...');
        },
        success: function (response) {
            toastr.success(response.message);
            setTimeout(function() {
                location.href = "{{ route('gallery.index') }}";
            }, 2000);
        },
        error: function(xhr) {
            let responseText = jQuery.parseJSON(xhr.responseText);
            toastr.error(responseText.message);
        },
        complete: function() {
            thisForm.find('button[type="submit"]')
                .prop("disabled", false)
                .removeClass('opacity-50 cursor-not-allowed')
                .html('<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Create Gallery');
        }
    });
});
</script>
@endpush
@endsection
