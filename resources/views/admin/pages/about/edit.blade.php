@extends('layouts.main')
@section('content')
<div class="p-6 max-w-5xl mx-auto">

    <!-- Breadcrumb -->
    <nav class="text-sm mb-6 text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">About Form</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="bg-white shadow-md rounded-xl p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">Update About Section</h2>

        <form id="aboutInsertForm" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-gray-700 font-medium mb-1">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Sub-title -->
            <div>
                <label for="subtitle" class="block text-gray-700 font-medium mb-1">Sub-title</label>
                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Short Description -->
            <div>
                <label for="short_description" class="block text-gray-700 font-medium mb-1">Short Description</label>
                <textarea name="short_description" id="short_description" rows="4" 
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('short_description') }}</textarea>
            </div>

            <!-- Long Description -->
            <div>
                <label for="long_description" class="block text-gray-700 font-medium mb-1">Long Description</label>
                <textarea name="long_description" id="long_description" rows="6" 
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('long_description') }}</textarea>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-gray-700 font-medium mb-1">Upload Image</label>
                <input type="file" name="image" id="image" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow">
                    Save Changes
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function(){
$("#aboutInsertForm").on('submit', function(e){
e.preventDefault();
let thisForm = $(this);

$.ajax({
type: "POST",
url: "{{route('about.store')}}",
data:new FormData(this),
dataType: "json",
contentType:false,
cache:false,
processData:false,
beforeSend: function() {
thisForm.find(".esc-loading-button").removeClass('d-none');
thisForm.find(".slider-submit-btn").html('Submitting...');
thisForm.find('button[type="submit"]').prop("disabled",true);
thisForm.find(".alert-success").removeClass('d-none');
thisForm.find(".alert-danger").removeClass('d-none');
thisForm.find(".alert-success").addClass('d-none');
thisForm.find(".alert-danger").addClass('d-none');
thisForm.find('.error').text('');
},
success: function (response) {
thisForm.find(".esc-loading-button").addClass('d-none');
thisForm.find(".slider-submit-btn").html('Submited');
thisForm.find('button[type="submit"]').prop("disabled",false);
thisForm.find(".alert-success").removeClass('d-none');
toastr.success(response.message);

setTimeout(function() {
    location.href = "{{route('about.create')}}";
}, 2000)
},

error: function(xhr, status, error) {
thisForm.find(".esc-loading-button").addClass('d-none');
thisForm.find(".slider-submit-btn").html('Submit');
thisForm.find('button[type="submit"]').prop("disabled",false);
thisForm.find(".alert-danger").removeClass('d-none');

var responseText = jQuery.parseJSON(xhr.responseText);
toastr.error(responseText.message);

$.each(responseText.errors, function(key, val) {
    thisForm.find("." + key + "-error").text(val[0]);
});
}
});
})
})
</script>

@endsection
