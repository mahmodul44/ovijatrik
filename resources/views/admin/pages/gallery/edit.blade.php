@extends('layouts.main')
@section('content')
<div class="p-3 max-w-7xl mx-auto font-sans transition-all duration-300 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <!-- Breadcrumb -->
    <nav class="text-sm mb-6 text-gray-500 dark:text-gray-400">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Dashboard</a>
            </li>
            <li>/</li>
            <li class="text-gray-700 dark:text-gray-300 font-medium">Gallery Update</li>
        </ol>
    </nav>

    <!-- Form Container -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-8 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-700 dark:to-indigo-700">
            <div class="flex items-center space-x-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 7l9 6 9-6-9-6-9 6z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M21 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7" />
                </svg>
                <h2 class="text-xl font-semibold tracking-tight">Update Gallery Section</h2>
            </div>

            <a href="{{ route('gallery.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition">
                ← Back
            </a>
        </div>

        <!-- Form -->
        <div class="p-8">
            <form id="galleryUpdateForm" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                 <!-- Category -->
                <div>
                    <label for="category_id" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Category <span class="text-red-600">*</span></label>
                    <select required id="category_id" name="category_id"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm 
                               focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:text-gray-100">
                        <option value="">-- Select --</option>
                        @foreach ($categories as $item)
                            <option {{ $galleries->category_id == $item->category_id ? 'selected' : '' }} value="{{ $item->category_id }}">
                                {{ $item->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Title -->
                <div>
                    <label for="title" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ $galleries->caption }}" required
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                                  focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-150 shadow-sm">
                </div>

                <!-- Current Image -->
                @if($galleries->image)
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Current Image</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset($galleries->image) }}" 
                             alt="Current Image" 
                             class="w-40 h-32 object-cover rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    </div>
                </div>
                @endif

                <!-- Upload New Image -->
                <div>
                    <label for="image" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Upload New Image</label>
                    <input type="file" name="image" id="image"
                           class="block w-full text-sm text-gray-700 dark:text-gray-200 
                                  border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer 
                                  focus:outline-none file:mr-4 file:py-2 file:px-4 
                                  file:rounded-md file:border-0 
                                  file:bg-gradient-to-r file:from-blue-600 file:to-indigo-600 
                                  file:text-white hover:file:opacity-90 
                                  dark:file:from-blue-500 dark:file:to-indigo-500 transition-all duration-150">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Accepted formats: JPG, PNG, JPEG. Max 1MB.</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" 
                            class="flex items-center justify-center w-full md:w-auto px-6 py-2 
                                   bg-gradient-to-r from-blue-600 to-indigo-600 
                                   hover:from-blue-700 hover:to-indigo-700 
                                   text-white font-semibold rounded-lg shadow-lg 
                                   transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$("#galleryUpdateForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{ route('gallery.update', $galleries->id) }}",
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            thisForm.find('button[type="submit"]')
                .prop("disabled", true)
                .addClass('opacity-50 cursor-not-allowed')
                .html('<svg xmlns="http://www.w3.org/2000/svg" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle class="opacity-25" cx="12" cy="12" r="10"/><path class="opacity-75" d="M4 12a8 8 0 018-8"/></svg> Saving...');
        },
        success: function (response) {
            toastr.success(response.message);
            setTimeout(() => window.location.href = "{{ route('gallery.index') }}", 1500);
        },
        error: function(xhr) {
            let responseText = jQuery.parseJSON(xhr.responseText);
            toastr.error(responseText.message || "Something went wrong.");
            if (responseText.errors) {
                $.each(responseText.errors, function(key, val) {
                    thisForm.find("." + key + "-error").text(val[0]);
                });
            }
        },
        complete: function() {
            thisForm.find('button[type="submit"]')
                .prop("disabled", false)
                .removeClass('opacity-50 cursor-not-allowed')
                .html('<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Save Changes');
        }
    });
});
</script>
@endpush
@endsection
