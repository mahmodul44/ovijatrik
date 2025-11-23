@extends('layouts.main')
@section('content')
<div class="p-3 max-w-7xl mx-auto">

    <!-- Breadcrumb -->
    <nav class="text-sm mb-6 text-gray-500">
        <ol class="list-reset flex">
            <li><a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-700">Mission Vision</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="bg-white shadow-md rounded-xl p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">Update Mission Vision</h2>

        <form id="missionvissionForm" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $about->id }}">

            <div>
                <label for="mission" class="block text-gray-700 font-medium mb-1">Mission</label>
                <textarea name="mission" id="mission" rows="4" required
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('mission',$about->mission) }}</textarea>
            </div>
             <div>
                <label for="mission_bn" class="block text-gray-700 font-medium mb-1">Mission (Bangla)</label>
                <textarea name="mission_bn" id="mission_bn" rows="4" required
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('mission_bn',$about->mission_bn) }}</textarea>
            </div>

            <div>
                <label for="vision" class="block text-gray-700 font-medium mb-1">Vision</label>
                <textarea name="vision" id="vision" rows="6" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('vision',$about->vision) }}</textarea>
            </div>
              <div>
                <label for="vision_bn" class="block text-gray-700 font-medium mb-1">Vision (Bangla)</label>
                <textarea name="vision_bn" id="vision_bn" rows="6" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('vision_bn',$about->vision_bn) }}</textarea>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow">
                   Update
                </button>
            </div>

        </form>
    </div>
</div>


@push('scripts')
<script>
    $("#missionvissionForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('about.missionvissionstore',$about->id)}}",
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
                location.href = "{{route('about.missionvission')}}";
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
