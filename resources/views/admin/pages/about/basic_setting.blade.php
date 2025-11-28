@extends('layouts.main')
@section('content')

<section class="py-8">
    <div class="max-w-7xl mx-auto px-4">

        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden transition">

            <div class="p-6 space-y-8">
 <form id="projectUpdateForm" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
                <!-- Title -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-1">Title</label>
                    <input type="text" id="title" name="title" value="{{ $about->title ?? '' }}" required
                        class="w-full px-4 py-2 rounded-lg
                   border border-gray-300 dark:border-gray-600
                   bg-white dark:bg-gray-800
                   text-gray-800 dark:text-gray-200
                   placeholder-gray-400 dark:placeholder-gray-500
                   shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600">
                </div>

               <!-- Contact Inputs -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Phone -->
    <div>
        <label class="font-semibold text-gray-700 dark:text-gray-300">Phone</label>
        <input type="text" id="mobile" name="mobile" value="{{ $about->mobile ?? '' }}" required
            class="w-full mt-1 px-4 py-2 rounded-lg
                   border border-gray-300 dark:border-gray-600
                   bg-white dark:bg-gray-800
                   text-gray-800 dark:text-gray-200
                   placeholder-gray-400 dark:placeholder-gray-500
                   shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600">
    </div>

    <!-- Email -->
    <div>
        <label class="font-semibold text-gray-700 dark:text-gray-300">Email</label>
        <input type="email" id="email" name="email" value="{{ $about->email ?? '' }}"
            class="w-full mt-1 px-4 py-2 rounded-lg
                   border border-gray-300 dark:border-gray-600
                   bg-white dark:bg-gray-800
                   text-gray-800 dark:text-gray-200
                   placeholder-gray-400 dark:placeholder-gray-500
                   shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600">
    </div>

    <!-- Facebook -->
    <div>
        <label class="font-semibold text-gray-700 dark:text-gray-300">Facebook</label>
        <input type="text" id="facebook" name="facebook" value="{{ $about->facebook ?? '' }}"
            class="w-full mt-1 px-4 py-2 rounded-lg
                   border border-gray-300 dark:border-gray-600
                   bg-white dark:bg-gray-800
                   text-gray-800 dark:text-gray-200
                   placeholder-gray-400 dark:placeholder-gray-500
                   shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600">
    </div>

    <!-- LinkedIn -->
    <div>
        <label class="font-semibold text-gray-700 dark:text-gray-300">LinkedIn</label>
        <input type="text" id="linkedin" name="linkedin" value="{{ $about->linkedin ?? '' }}"
            class="w-full mt-1 px-4 py-2 rounded-lg
                   border border-gray-300 dark:border-gray-600
                   bg-white dark:bg-gray-800
                   text-gray-800 dark:text-gray-200
                   placeholder-gray-400 dark:placeholder-gray-500
                   shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600">
    </div>

    <!-- Address -->
    <div class="md:col-span-2">
        <label class="font-semibold text-gray-700 dark:text-gray-300">Address</label>
        <textarea id="address" name="address" rows="2"
    class="w-full mt-1 px-4 py-2 rounded-lg
           border border-gray-300 dark:border-gray-600
           bg-white dark:bg-gray-800
           text-gray-800 dark:text-gray-200
           placeholder-gray-400 dark:placeholder-gray-500
           shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600">{{ strip_tags($about->address ?? '') }}</textarea>
    </div>

</div>


                <!-- Logos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Dark Logo -->
                   <div>
    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-2">
        Dark Logo
    </label>

    <input 
        type="file" 
        id="logo_dark" name="logo_dark"
        class="file-input w-full border border-gray-300 dark:border-gray-600 rounded-lg 
               px-3 py-2 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200
               file:mr-4 file:py-2 file:px-4 file:rounded-md 
               file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700"
    >

    <div class="mt-3">
        <img 
            id="dark_preview"
            src="{{ $about->logo_dark ? asset($about->logo_dark) : asset('No_Image_Available.jpg') }}"
            class="h-28 w-28 rounded-lg shadow-md 
                   object-contain
                   bg-white dark:bg-gray-800 
                   border border-gray-300 dark:border-gray-600 p-1"
        >
    </div>
</div>


<div>
    <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-2">
        Light Logo
    </label>

    <input 
        type="file" 
        id="logo_light" name="logo_light"
        class="file-input w-full border border-gray-300 dark:border-gray-600 rounded-lg 
               px-3 py-2 bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-200
               file:mr-4 file:py-2 file:px-4 file:rounded-md 
               file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700"
    >

    <div class="mt-3">
        <img 
            id="light_preview"
            src="{{ $about->logo ? asset($about->logo) : asset('No_Image_Available.jpg') }}"
            class="h-28 w-28 rounded-lg shadow-md 
                   object-contain
                   bg-white dark:bg-gray-800
                   border border-gray-300 dark:border-gray-600 p-1"
        >
    </div>
</div>


                </div>

                <!-- Update Button -->
                <div class="text-right">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow">
                        Update
                    </button>
                </div>
 </form>
            </div>
        </div>

    </div>
</section>

@endsection


@push('scripts')
<script>

// Image Preview Functions
$('#logo_dark').on('change', function(e){
    let reader = new FileReader();
    reader.onload = e => $('#dark_preview').attr('src', e.target.result);
    reader.readAsDataURL(e.target.files[0]);
});

$('#logo_light').on('change', function(e){
    let reader = new FileReader();
    reader.onload = e => $('#light_preview').attr('src', e.target.result);
    reader.readAsDataURL(e.target.files[0]);
});


$("#projectUpdateForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('about.basicsettingupdate',$about->id)}}",
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
                location.href = "{{route('about.basicsetting')}}";
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
