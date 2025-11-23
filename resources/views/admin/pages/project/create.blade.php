@extends('layouts.main')
@section('content')
<div class="p-5 max-w-7xl mx-auto space-y-6">

    <!-- Breadcrumb & Back Button -->
    <div class="flex justify-between items-center mb-4">
        <nav
            class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-300 
                   bg-gray-50 dark:bg-gray-800 px-4 py-2 rounded-md shadow-sm">
            <a href="{{ route('dashboard') }}"
                class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Dashboard</a>
            <span>/</span>
            <span class="text-gray-700 dark:text-gray-200 font-semibold">Project Form</span>
        </nav>
        <a href="{{ route('project.index') }}"
            class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow">
            <svg xmlns="http://www.w3.org/2000/svg" 
                class="w-4 h-4 mr-2" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor" 
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M4 6h16M4 12h16M4 18h16" />
           </svg>
            Project List
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-8 space-y-6 border border-gray-200 dark:border-gray-700">
        <h2
            class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 border-b pb-2 
                   border-gray-200 dark:border-gray-700">
            Add New Project
        </h2>

        <form id="projectInsertForm" enctype="multipart/form-data" class="space-y-6" autocomplete="off">
            @csrf
            <!-- Category & Subcategory -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="category_id"
                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Category <span class="text-red-600">*</span>
                    </label>
                    <select required id="category_id" name="category_id"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                               focus:outline-none focus:ring-2 focus:ring-blue-500 
                               focus:border-blue-500 text-sm shadow-sm">
                        <option value="">-- Select --</option>
                        @foreach ($categoris as $item)
                            <option value="{{ $item->category_id }}">{{ $item->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="sub_cat_id"
                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Sub Category <span class="text-red-600"></span>
                    </label>
                    <select id="sub_cat_id" name="sub_cat_id"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                               focus:outline-none focus:ring-2 focus:ring-blue-500 
                               focus:border-blue-500 text-sm shadow-sm">
                        <option value="">-- Select --</option>
                    </select>
                </div>
            </div>

       
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Project Title EN -->
                <div>
                    <label for="project_title_en"
                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Project Title EN <span class="text-red-600">*</span>
                    </label>
                    <input type="text" required name="project_title" id="project_title"
                        value="{{ old('project_title') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 
                            dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 
                            focus:border-blue-500 shadow-sm"
                        placeholder="Enter project title">
                </div>

                <!-- Project Title BN -->
                <div>
                    <label for="project_title_bn"
                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Project Title BN <span class="text-red-600">*</span>
                    </label>
                    <input type="text" required name="project_title_bn" id="project_title_bn"
                        value="{{ old('project_title_bn') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 
                            dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                            focus:outline-none focus:ring-2 focus:ring-blue-500 
                            focus:border-blue-500 shadow-sm"
                        placeholder="প্রোজেক্ট শিরোনাম">
                </div>
            </div>


            <!-- Dates & Target -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="project_code"
                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Project Code <span class="text-red-600">*</span>
                    </label>
                    <input type="text" required name="project_code" id="project_code"
                        value="{{ old('project_code') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                               focus:outline-none focus:ring-2 focus:ring-blue-500 
                               focus:border-blue-500 shadow-sm"
                        placeholder="Enter code">
                </div>
                <div>
                    <label for="project_start_date"
                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Start Date <span class="text-red-600">*</span>
                    </label>
                    <input type="text" required name="project_start_date" id="project_start_date"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                               focus:outline-none focus:ring-2 focus:ring-blue-500 
                               focus:border-blue-500 shadow-sm"
                        placeholder="dd/mm/yyyy" autocomplete="off">
                </div>

                <div>
                    <label for="project_end_date"
                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        End Date
                    </label>
                    <input type="text" name="project_end_date" id="project_end_date"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                               focus:outline-none focus:ring-2 focus:ring-blue-500 
                               focus:border-blue-500 shadow-sm"
                        placeholder="dd/mm/yyyy" autocomplete="off">
                </div>

                <div>
                    <label for="target_amount"
                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Target Amount <span class="text-red-600"></span>
                    </label>
                    <input type="text" name="target_amount" id="target_amount"
                        value="{{ old('target_amount') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                               focus:outline-none focus:ring-2 focus:ring-blue-500 
                               focus:border-blue-500 shadow-sm">
                </div>
            </div>

            <!-- Image -->
            <div>
                <label for="image"
                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Project Image <span class="text-red-600"> *</span>
                </label>
                <input type="file" name="image" id="image" required
                    class="w-full border border-gray-300 dark:border-gray-600 
                           dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                           file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 
                           file:bg-blue-600 file:text-white hover:file:bg-blue-700 shadow-sm">
            </div>

            <div>
                <label for="project_details"
                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Short Description
                </label>
                <textarea name="project_details" id="project_details" rows="4"
                    class="w-full border border-gray-300 dark:border-gray-600 
                           dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                           focus:outline-none focus:ring-2 focus:ring-blue-500 
                           focus:border-blue-500 shadow-sm"
                    placeholder="Enter a brief description">{{ old('project_details') }}</textarea>
            </div>

            <div>
                <label for="project_details_bn"
                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Short Description BN
                </label>
                <textarea name="project_details_bn" id="project_details_bn" rows="4"
                    class="w-full border border-gray-300 dark:border-gray-600 
                           dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                           focus:outline-none focus:ring-2 focus:ring-blue-500 
                           focus:border-blue-500 shadow-sm"
                    placeholder="সংক্ষিপ্ত বিস্তারিত">{{ old('project_details_bn') }}</textarea>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 
                           hover:from-blue-700 hover:to-indigo-700 text-white font-semibold 
                           px-6 py-2 rounded-lg shadow-lg transition transform hover:scale-105">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>


@push('scripts')
<script>
flatpickr("#project_start_date", { dateFormat: "d/m/Y", allowInput: true });
flatpickr("#project_end_date", { dateFormat: "d/m/Y", allowInput: true });

document.getElementById('category_id').addEventListener('change', function () {
    const categoryId = this.value;
    const subcategorySelect = document.getElementById('sub_cat_id');
    subcategorySelect.innerHTML = '<option value="">Loading...</option>';

    if (categoryId) {
        fetch(`/get-subcategories/${categoryId}`)
            .then(res => res.json())
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

$("#projectInsertForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('project.store')}}",
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
            setTimeout(() => { location.href = "{{route('project.index')}}"; }, 2000);
        },
        error: function(xhr) {
            let responseText = jQuery.parseJSON(xhr.responseText);
            toastr.error(responseText.message);
        },
        complete: function() {
            thisForm.find('button[type="submit"]')
                .prop("disabled", false)
                .removeClass('opacity-50 cursor-not-allowed')
                .text('Save Project');
        }
    });
});
</script>
@endpush
@endsection
