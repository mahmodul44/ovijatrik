@extends('layouts.main')
@section('content')
<div class="p-5 max-w-7xl mx-auto space-y-6">

    <!-- Breadcrumb & Back Button -->
    <div class="flex justify-between items-center mb-4">
        <nav
            class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 px-4 py-2 rounded-md shadow-sm">
            <a href="{{ route('dashboard') }}"
                class="text-blue-600 dark:text-blue-400 hover:underline font-medium">Dashboard</a>
            <span>/</span>
            <span class="text-gray-700 dark:text-gray-200 font-semibold">Member Form</span>
        </nav>
        <a href="{{ route('member.index') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition">
            Member List
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-4 space-y-6 border border-gray-200 dark:border-gray-700">
        <h2
            class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
            Add New Member
        </h2>

        <form id="memberInsertForm" method="POST"
            class="mx-auto bg-white/70 dark:bg-gray-800/70 backdrop-blur-lg rounded-2xl p-4 border border-gray-200 dark:border-gray-700">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Name -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-gray-700 dark:text-gray-200 font-medium" />
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <x-text-input id="name" type="text" name="name" :value="old('name')"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                            required autofocus autocomplete="name" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                 <div>
                        <x-input-label for="member_id" :value="__('Member ID')"
                            class="text-gray-700 dark:text-gray-200 font-medium" />
                        <x-text-input id="member_id" type="text" name="member_id" :value="old('member_id')"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                            required autocomplete="off" />
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Format: OBM1234, OBBM5678, OBBBM91011</p>
                        <x-input-error :messages="$errors->get('member_id')" class="mt-2" />
                    </div>
                </div>
                <!-- Member ID & Phone No in same row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                    <x-input-label for="occupation" :value="__('Occupation')" class="text-gray-700 dark:text-gray-200 font-medium" />
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <x-text-input id="occupation" type="text" name="occupation" :value="old('occupation')"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                            required autofocus autocomplete="occupation" />
                    </div>
                       <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone_no" :value="__('Phone No')"
                            class="text-gray-700 dark:text-gray-200 font-medium" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                            <x-text-input id="phone_no" type="text" name="phone_no" :value="old('phone_no')"
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                                required autocomplete="off" />
                        </div>
                        <x-input-error :messages="$errors->get('phone_no')" class="mt-2" />
                    </div>
                </div>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')"
                        class="text-gray-700 dark:text-gray-200 font-medium" />
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <x-text-input id="email" type="email" name="email" :value="old('email')"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                            required autocomplete="off" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                 <div>
                    <x-input-label for="monthly_donate" :value="__('Monthly Amount')"
                            class="text-gray-700 dark:text-gray-200 font-medium" />
                    <x-text-input id="monthly_donate" type="text" name="monthly_donate" :value="old('monthly_donate')"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                            required autocomplete="off" />
                        <x-input-error :messages="$errors->get('monthly_donate')" class="mt-2" />
                    </div>
                </div>
                <!-- Passwords -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="password" :value="__('Password')"
                            class="text-gray-700 dark:text-gray-200 font-medium" />
                        <x-text-input id="password" type="password" name="password"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                            required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                            class="text-gray-700 dark:text-gray-200 font-medium" />
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                            required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-between mt-8">
                <a href="{{ route('member.index') }}"
                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    Back to List
                </a>

                <button type="submit"
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-6 py-2 rounded-lg shadow-lg transition transform hover:scale-105">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$("#memberInsertForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('member.store')}}",
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
            toastr.success(response.message ?? "Member saved successfully!");
            setTimeout(() => { location.href = "{{route('member.index')}}"; }, 2000);
        },
        error: function(xhr) {
            let responseText = xhr.responseJSON ?? {message: "Something went wrong"};
            toastr.error(responseText.message);
        },
        complete: function() {
            thisForm.find('button[type="submit"]')
                .prop("disabled", false)
                .removeClass('opacity-50 cursor-not-allowed')
                .text('Save Member');
        }
    });
});
</script>
@endpush
@endsection
