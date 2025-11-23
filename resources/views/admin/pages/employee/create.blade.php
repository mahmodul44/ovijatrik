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
            <span class="text-gray-700 dark:text-gray-200 font-semibold">Employee Form</span>
        </nav>
        <a href="{{ route('employee.index') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition">
            Employee List
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-4 space-y-6 border border-gray-200 dark:border-gray-700">
        <h2
            class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
            New Employee
        </h2>

        <form id="employeeInsertForm" method="POST"
            class="mx-auto bg-white/70 dark:bg-gray-800/70 backdrop-blur-lg rounded-2xl p-4 border border-gray-200 dark:border-gray-700">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Name -->
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

                <!-- Department & Designation in same row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="designation" :value="__('Designation')"
                            class="text-gray-700 dark:text-gray-200 font-medium" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                            <x-text-input id="designation" type="text" name="designation" :value="old('designation')"
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                                required autocomplete="off" />
                        </div>
                        <x-input-error :messages="$errors->get('designation')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="department" :value="__('Department')"
                            class="text-gray-700 dark:text-gray-200 font-medium" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                            <x-text-input id="department" type="text" name="department" :value="old('department')"
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                                required autocomplete="off" />
                        </div>
                        <x-input-error :messages="$errors->get('department')" class="mt-2" />
                    </div>
                </div>

                <!-- Phone No & Email No in same row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                 <x-input-label for="phone_no" :value="__('Phone No')" class="text-gray-700 dark:text-gray-200 font-medium" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <x-text-input id="phone_no" 
                        type="text" 
                        name="phone_no" 
                        pattern="[0-9]{11}" 
                        maxlength="11" 
                        minlength="11"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                        :value="old('phone_no')"
                        class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                        required autocomplete="off" />
                    </div>
                    <x-input-error :messages="$errors->get('phone_no')" class="mt-2" />
                </div>

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
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="address" :value="__('Address')"
                        class="text-gray-700 dark:text-gray-200 font-medium" />
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <x-text-input id="address" type="text" name="address" :value="old('address')"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                            required autocomplete="off" />
                    </div>
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- Salary & Joining Date in same row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                       <x-input-label for="join_date" :value="__('Join Date')"
                        class="text-gray-700 dark:text-gray-200 font-medium" />
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <x-text-input id="join_date" type="date" name="join_date" :value="old('join_date')"
                            class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                            required autocomplete="off" />
                    </div>
                    <x-input-error :messages="$errors->get('join_date')" class="mt-2" />
                    </div>

                    <div>
                       <x-input-label for="salary" :value="__('Salary')"
                            class="text-gray-700 dark:text-gray-200 font-medium" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                            <x-text-input id="salary" type="text" name="salary" :value="old('salary')"
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                                required autocomplete="off" />
                        </div>
                        <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                    </div>
                </div>

                <!-- Bank Name & Bank Account in same row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                       <x-input-label for="bank_name" :value="__('Bank_Name')"
                            class="text-gray-700 dark:text-gray-200 font-medium" />
                        <div class="relative">
                            <x-text-input id="bank_name" type="text" name="bank_name" :value="old('bank_name')"
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                                 autocomplete="off" />
                        </div>
                        <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                    </div>
                    
                    <div>
                       <x-input-label for="bank_account" :value="__('Bank_Account')"
                            class="text-gray-700 dark:text-gray-200 font-medium" />
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                            <x-text-input id="bank_account" type="text" name="bank_account" :value="old('bank_account')"
                                class="block w-full rounded-xl border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100"
                                 autocomplete="off" />
                        </div>
                        <x-input-error :messages="$errors->get('bank_account')" class="mt-2" />
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
                <a href="{{ route('employee.index') }}"
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
$("#employeeInsertForm").on('submit', function(e){
    e.preventDefault();
    let thisForm = $(this);

    $.ajax({
        type: "POST",
        url: "{{route('employee.store')}}",
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
            toastr.success(response.message ?? "Employee saved successfully!");
            setTimeout(() => { location.href = "{{route('employee.index')}}"; }, 2000);
        },
        error: function(xhr) {
            let responseText = xhr.responseJSON ?? {message: "Something went wrong"};
            toastr.error(responseText.message);
        },
        complete: function() {
            thisForm.find('button[type="submit"]')
                .prop("disabled", false)
                .removeClass('opacity-50 cursor-not-allowed')
                .text('Save Employee');
        }
    });
});
</script>
@endpush
@endsection
