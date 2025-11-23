@extends('layouts.main')
@section('content')

<!-- Content Header -->
<section class="bg-gray-50 py-4 border-b border-gray-200">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">About</h1>
        <ol class="flex space-x-2 text-gray-500">
            <li><a href="{{route('dashboard')}}" class="hover:text-gray-800">Dashboard</a></li>
            <li>/</li>
            <li class="text-gray-700 font-semibold">About View</li>
        </ol>
    </div>
</section>

<!-- Main content -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="flex flex-col">
            <!-- Card -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">View About</h3>
                    <div>
                        @if ($about)
                            <a href="{{route('about.edit',$about->id)}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Edit About</a>
                        @else
                            <a href="{{route('about.create')}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Create New</a>
                        @endif
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6 space-y-6">
                    <!-- About & Image -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">About</label>
                            <div class="bg-gray-50 p-3 rounded border border-gray-200">
                                @if ($about)
                                    <p class="text-gray-800">{!! $about->about !!}</p>
                                @else
                                    <p></p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">About Image</label>
                            @if (isset($about->about_img))
                                <img src="{{asset('/')}}{{$about->about_img}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @else
                                <img src="{{asset('public/No_Image_Available.jpg')}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @endif
                        </div>
                    </div>

                    <!-- CEO Message & Image -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Message of CEO</label>
                            <div class="bg-gray-50 p-3 rounded border border-gray-200">
                                @if ($about)
                                    {!! $about->message !!}
                                @else
                                    <p></p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">CEO Image</label>
                            @if (isset($about->message_img))
                                <img src="{{asset('/')}}{{$about->message_img}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @else
                                <img src="{{asset('public/no_image_found.jpg')}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @endif
                        </div>
                    </div>

                    <!-- Why Choose Us & Image -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Why Choose Us</label>
                            <div class="bg-gray-50 p-3 rounded border border-gray-200">
                                @if ($about)
                                    {!! $about->why_choose !!}
                                @else
                                    <p></p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Why Choose Us Image</label>
                            @if (isset($about->why_choose_img))
                                <img src="{{asset('/')}}{{$about->why_choose_img}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @else
                                <img src="{{asset('public/no_image_found.jpg')}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @endif
                        </div>
                    </div>

                    <!-- Why We Best & Image -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Why We Best?</label>
                            <div class="bg-gray-50 p-3 rounded border border-gray-200">
                                @if ($about)
                                    {!! $about->why_best !!}
                                @else
                                    <p></p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Why We Best Image</label>
                            @if (isset($about->why_best_img))
                                <img src="{{asset('/')}}{{$about->why_best_img}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @else
                                <img src="{{asset('public/no_image_found.jpg')}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @endif
                        </div>
                    </div>

                    <!-- History & Image -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">History</label>
                            <div class="bg-gray-50 p-3 rounded border border-gray-200">
                                @if ($about)
                                    {!! $about->history !!}
                                @else
                                    <p></p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">History Image</label>
                            @if (isset($about->history_img))
                                <img src="{{asset('/')}}{{$about->history_img}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @else
                                <img src="{{asset('public/no_image_found.jpg')}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @endif
                        </div>
                    </div>

                    <!-- Contact Info & Logo -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 font-semibold">Email</label>
                                <p>{{$about? $about->email : ''}}</p>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold">Mobile</label>
                                <p>{{$about? $about->mobile : ''}}</p>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold">Address</label>
                                <p>{{$about? $about->address : ''}}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Logo</label><br>
                            @if (isset($about->logo))
                                <img src="{{asset('/')}}{{$about->logo}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @else
                                <img src="{{asset('public/no_image_found.jpg')}}" alt="Preview" class="h-24 w-24 object-cover rounded">
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="p-4 border-t border-gray-200">
                    @if ($about)
                        <a href="{{route('about.edit',$about->id)}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Edit About</a>
                    @else
                        <a href="{{route('about.create')}}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Create New</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        console.log("Jquery Getting");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#newsInsertForm").on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{url('/about')}}",
                data:new FormData(this),
                dataType: "json",
                contentType:false,
                cache:false,
                processData:false,
                success: function (response) {
                    toastr.success('Successful');
                    location.reload();
                },
            });
        })
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#previewImg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#inputImg").change(function(){
        readURL(this);
    });
</script>
@endpush
