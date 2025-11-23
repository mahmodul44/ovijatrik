@extends('layouts.main')
@section('content')
<div class="p-3 max-w-7xl mx-auto">

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
           
            <input type="hidden" name="id" value="{{ $about->id }}">
            <div>
                <label for="about" class="block text-gray-700 font-medium mb-1">About</label>
                <textarea name="about" id="about" rows="4" 
                    required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('about',$about->about) }}</textarea>
            </div>

            <div>
                <label for="about_bn" class="block text-gray-700 font-medium mb-1">About (BN)</label>
                <textarea name="about_bn" id="about_bn" rows="4" 
                    required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('about_bn',$about->about_bn) }}</textarea>
            </div>

            <div>
                <label for="message" class="block text-gray-700 font-medium mb-1">Founder Message</label>
                <textarea name="message" id="message" rows="6" 
                   required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('message',$about->message) }}</textarea>
            </div>

             <div>
                <label for="message_bn" class="block text-gray-700 font-medium mb-1">Founder Message (BN)</label>
                <textarea name="message_bn" id="message_bn" rows="6" 
                   required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('message_bn',$about->message_bn) }}</textarea>
            </div>
            <div>
                <label for="message_img" class="block text-gray-700 font-medium mb-1">Founder Image</label>
                <input type="file" name="message_img" id="message_img" 
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

@push('scripts')
<script>
$("#aboutInsertForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('about.store')}}",
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
                location.href = "{{route('about.create')}}";
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
                .text('Save Changes');
        }
    });
});
</script>
@endpush
@endsection
