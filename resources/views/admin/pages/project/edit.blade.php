@extends('layouts.main')
@section('content')
<div class="p-5 max-w-7xl mx-auto">

    <!-- Breadcrumb & Project List Button -->
    <div class="flex justify-between items-center mb-6">
        <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 px-4 py-2 rounded-md shadow-sm">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Dashboard</a></li>
                <li>/</li>
                <li class="text-gray-700 dark:text-gray-200 font-medium">Project Form</li>
            </ol>
        </nav>
        <a href="{{ route('project.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-3 py-2 rounded-lg shadow transition">
            Project List
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Update Project</h2>
            </div>
            <a href="{{ route('project.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                ← Back
            </a>
        </div>

        <form id="projectUpdateForm" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Category & Subcategory -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="category_id" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Category <span class="text-red-600">*</span></label>
                    <select required id="category_id" name="category_id" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-200">
                        <option value="">-- Select --</option>
                        @foreach ($categoris as $item)
                            <option {{ $projects->category_id == $item->category_id ? 'selected' : '' }} value="{{ $item->category_id }}">{{ $item->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="sub_cat_id" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Sub Category <span class="text-red-600"></span></label>
                    <select id="sub_cat_id" name="sub_cat_id" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-200">
                        <option value="">-- Select --</option>
                    </select>
                </div>
            </div>

            <!-- Title & Code -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="project_title" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Title <span class="text-red-600">*</span></label>
                    <input type="text" required name="project_title" id="project_title" value="{{ $projects->project_title }}" placeholder="Enter project title" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <!-- Project Title BN -->
                <div>
                    <label for="project_title_bn"
                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Project Title BN <span class="text-red-600">*</span>
                    </label>
                    <input type="text" required name="project_title_bn" id="project_title_bn"
                        value="{{ old('project_title_bn',$projects->project_title_bn ) }}"
                        class="w-full border border-gray-300 dark:border-gray-600 
                            dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 
                            focus:border-blue-500 shadow-sm"
                        placeholder="প্রোজেক্ট শিরোনাম">
                </div>
            </div>

            <!-- Dates & Amount -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                 <div>
                    <label for="project_code" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Code <span class="text-red-600">*</span></label>
                    <input type="text" required name="project_code" id="project_code" value="{{ $projects->project_code }}" placeholder="Enter code" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="project_start_date" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Start Date <span class="text-red-600">*</span></label>
                    <input required type="text" name="project_start_date" id="project_start_date" value="{{ date('d/m/Y', strtotime($projects->project_start_date)) }}" placeholder="dd/mm/yyyy" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="project_end_date" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">End Date</label>
                    <input type="text" name="project_end_date" id="project_end_date" value="{{ $projects->project_end_date ? date('d/m/Y', strtotime($projects->project_end_date)) : '' }}" placeholder="dd/mm/yyyy" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="target_amount" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Target Amount </label>
                    <input type="text" name="target_amount" id="target_amount" value="{{ $projects->target_amount }}" placeholder="Enter amount" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                    Project Image <span class="text-red-600"> *</span>
                </label>
                <input type="file" name="image" id="image"
                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-600 hover:file:bg-blue-700 file:text-white transition">

                @if ($projects->image)
                    <div class="mt-3">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Current Image:</p>
                        <img src="{{ asset($projects->image) }}" 
                            alt="Project Image" 
                            class="w-40 h-28 object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                    </div>
                @endif
            </div>


            <!-- Description -->
            <div>
                <label for="project_details" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Short Description</label>
                <textarea name="project_details" id="project_details" rows="4" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $projects->project_details }}</textarea>
            </div>
             <div>
                <label for="project_details_bn" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Short Description BN</label>
                <textarea name="project_details_bn" id="project_details_bn" rows="4" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $projects->project_details_bn }}</textarea>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="flex items-center justify-center px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 text-white font-semibold rounded-lg shadow-lg hover:scale-105 transition transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save
                </button>
            </div>
        </form>
    </div>
</div>


@push('scripts')
<script>

flatpickr("#project_start_date", {
    dateFormat: "d/m/Y",
    allowInput: true
});

flatpickr("#project_end_date", {
    dateFormat: "d/m/Y",
    allowInput: true
});

document.getElementById('category_id').addEventListener('change', function () {
    const categoryId = this.value;
    const subcategorySelect = document.getElementById('sub_cat_id');
    subcategorySelect.innerHTML = '<option value="">Loading...</option>';

    if (categoryId) {
        fetch(`/get-subcategories/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                subcategorySelect.innerHTML = '<option value="">-- Select --</option>';
                data.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.sub_cat_id;
                    option.text = sub.sub_cat_name;
                    subcategorySelect.appendChild(option);
                });
            });
    } else {
        subcategorySelect.innerHTML = '<option value="">-- Select --</option>';
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let selectedCategory = "{{ $projects->category_id }}";
    let selectedSubCategory = "{{ $projects->sub_cat_id }}";

    if (selectedCategory) {
        fetch(`/get-subcategories/${selectedCategory}`)
            .then(response => response.json())
            .then(data => {
                const subcategorySelect = document.getElementById('sub_cat_id');
                subcategorySelect.innerHTML = '<option value="">-- Select --</option>';
                data.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.sub_cat_id;
                    option.text = sub.sub_cat_name;
                    if (selectedSubCategory == sub.sub_cat_id) {
                        option.selected = true;
                    }
                    subcategorySelect.appendChild(option);
                });
            });
    }
});


$("#projectUpdateForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    let project_title = $('#project_title').val().trim();
    let project_details = $('#project_details').val().trim();
    let image = $('#image').val();

    $.ajax({
        type: "POST",
        url: "{{route('project.update',$projects->project_id)}}",
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
                location.href = "{{route('project.index')}}";
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
