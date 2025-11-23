@extends('layouts.main')
@section('content')
<div class="p-5 max-w-7xl mx-auto">

    <!-- Breadcrumb & Back Button -->
    <div class="flex justify-between items-center mb-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-500 bg-gray-100 dark:bg-gray-800 px-4 py-2 rounded-md shadow-sm">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Dashboard</a>
                </li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-700 dark:text-gray-300 font-medium">Project Preview</li>
            </ol>
        </nav>

        <a href="{{ route('project.index') }}" 
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md shadow transition">
            📋 Project List
        </a>
    </div>

    <!-- Project Card -->
    <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 
                             2.943 9.542 7-1.274 4.057-5.065 
                             7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 tracking-tight">Project Preview</h2>
            </div>
            <a href="{{ route('project.index') }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                ← Back
            </a>
        </div>

        <!-- Project Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Category Name</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $projectPreview->category->category_name }} <br> {{ $projectPreview->category->category_name_bn }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Sub Category</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $projectPreview->sub_cat_id ? $projectPreview->subcategory->sub_cat_name : '' }} <br> {{ $projectPreview->sub_cat_id ? $projectPreview->subcategory->sub_cat_name_bn : '' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Project Name</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $projectPreview->project_title }} <br> {{ $projectPreview->project_title_bn }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Project Code</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $projectPreview->project_code }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Start Date</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                    {{ \Carbon\Carbon::parse($projectPreview->project_start_date)->format('d M, Y') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">End Date</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                    {{ \Carbon\Carbon::parse($projectPreview->project_end_date)->format('d M, Y') }}
                </p>
            </div>
           
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Target Amount</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                    {{ number_format($projectPreview->target_amount,2) }} BDT
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Collection Amount</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                    {{ number_format($projectPreview->collection_amount,2) }} BDT
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Expense Amount</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                    {{ number_format($projectPreview->total_expense,2) }} BDT
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Image</p>
                <img src="{{ asset($projectPreview->image) }}" 
                    alt="Current Image" class="w-48 h-36 object-cover rounded-lg border dark:border-gray-700 shadow-md">
            </div>
        </div>

        <!-- Description -->
        <div class="mt-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                {{ $projectPreview->project_details }} <br>   {{ $projectPreview->project_details_bn }}
            </div>
        </div>
            @if($projectPreview->additional_link)
            <div class="mt-8">
                <p class="text-sm text-gray-500 dark:text-gray-400">Additional Link</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                    <a href="{{ $projectPreview->additional_link }}">Click Here</a>
                </p>
            </div>
            @endif

        <!-- Gallery Grid Section -->
<div class="mt-8">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Project Images</h3>

    <!-- Images Grid -->
    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700"> 
        <table class="w-full text-left border-collapse"> <thead class="bg-gray-100 dark:bg-gray-800"> 
            <tr class="text-gray-700 dark:text-gray-300"> 
                <th class="p-3 border">#</th> 
                <th class="p-3 border">Image</th>
                 <th class="p-3 border">Description</th> 
                 <th class="p-3 border">Actions</th> 
                </tr> 
            </thead> 
            <tbody id="galleryBody"> 
                    @foreach($projectPreview->images as $index => $img) 
                    <tr id="row-{{ $img->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-800 transition"> 
                        <td class="p-3 border text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                        <td class="p-3 border"> <img src="{{ asset($img->image) }}" class="w-20 h-16 object-cover rounded shadow"> </td> 
                        <td class="p-3 border text-gray-700 dark:text-gray-300">{{ $img->short_description ?? '-' }}</td>
                        <td class="p-3 border !text-center"> <button class="delete-btn text-red-600 hover:text-red-800 dark:hover:text-red-400 transition" data-id="{{ $img->id }}"> Delete </button> </td>
                     </tr>
                      @endforeach 
                    </tbody> 
                </table> 
    </div>

    <!-- Add New Image Form -->
    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-200 dark:border-gray-700 mt-6">
        <form id="addImageForm" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-4 items-end">
            @csrf
            <div class="w-full md:w-1/3">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Image</label>
                <input type="file" name="image" id="imageInput" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 p-2 rounded" required>
            </div>
            <div class="w-full md:w-1/3">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Short Description</label>
                <input type="text" name="short_description" id="descInput" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 p-2 rounded" placeholder="Optional">
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow transition">
                ➕ Add Image
            </button>
        </form>
    </div>
</div>
    </div>
</div>

@push('scripts')
<script>
 $(document).ready(function() {

    // Add Image via AJAX
   $('#addImageForm').on('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('projectimages.store', $projectPreview->project_id) }}",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            if(data.success) {
                let index = $('#galleryBody tr').length + 1; // auto increment row number
                let row = `
                    <tr id="row-${data.image.id}" class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="p-3 border text-center text-gray-700 dark:text-gray-300">${index}</td>
                        <td class="p-3 border">
                           <img src="{{ url('/') }}/${data.image.image}" class="w-20 h-16 object-cover rounded shadow">
                        </td>
                        <td class="p-3 border text-gray-700 dark:text-gray-300">
                            ${data.image.short_description ?? '-'}
                        </td>
                        <td class="p-3 border !text-center">
                            <button class="delete-btn text-red-600 hover:text-red-800 dark:hover:text-red-400 transition" 
                                    data-id="${data.image.id}">
                                Delete
                            </button>
                        </td>
                    </tr>
                `;

                $('#galleryBody').append(row);

                Swal.fire({
                    icon: 'success',
                    title: 'Image Added!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                $('#addImageForm')[0].reset();
            }
        },
        error: function(err) {
            Swal.fire('Error', 'Something went wrong while uploading.', 'error');
            console.error(err);
        }
    });
});

    // Delete Image via AJAX
   $('#galleryBody').on('click', '.delete-btn', function() {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This image will be deleted permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('project.images.ajaxDelete', '') }}/" + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(data) {
                    if (data.success) {
                        $(`#row-${id}`).remove();

                        $(`#card-${id}`).remove();

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(err) {
                    Swal.fire('Error', 'Failed to delete image.', 'error');
                    console.error(err);
                }
            });
        }
    });
});


});
</script>
@endpush
@endsection
