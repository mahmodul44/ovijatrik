@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-black py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Account Settings</h1>
                <p class="text-gray-500 dark:text-gray-400">Manage your public profile and security settings.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">Back to Dashboard</a>
        </div>

        <form id="profileupdateForm" class="space-y-8">
            @csrf
            @method('patch')

            <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Profile Media</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="flex flex-col items-center">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Profile Picture</label>
                        <div class="relative group">
                            <img id="profile_preview" 
                                 src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                            <label for="profile_photo" class="absolute bottom-0 right-0 bg-blue-600 p-2 rounded-full text-white cursor-pointer hover:bg-blue-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"></path></svg>
                                <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*" onchange="previewImage(this, 'profile_preview')">
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">JPG, PNG up to 2MB</p>
                    </div>

                    <div class="flex flex-col items-center">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Member ID Card (Optional)</label>
                        <div class="relative w-full h-32 bg-gray-100 dark:bg-gray-800 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700 flex items-center justify-center overflow-hidden">
                            <img id="id_card_preview" src="{{ $user->id_card_photo ? asset('storage/'.$user->id_card_photo) : '' }}" class="absolute inset-0 w-full h-full object-cover {{ $user->id_card_photo ? '' : 'hidden' }}">
                            <div id="id_placeholder" class="text-center {{ $user->id_card_photo ? 'hidden' : '' }}">
                                <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                <span class="mt-2 block text-xs font-medium text-gray-600 dark:text-gray-400">Upload ID</span>
                            </div>
                            <input type="file" id="id_card_photo" name="id_card_photo" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(this, 'id_card_preview', 'id_placeholder')">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Personal Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                        <input type="text" name="phone_no" value="{{ $user->phone_no }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Occupation</label>
                        <input type="text" name="occupation" value="{{ $user->occupation }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Change Password</h3>
                <p class="text-sm text-gray-500 mb-6">Leave blank if you don't want to change it.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                        <input type="password" name="password" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" id="submitBtn" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:bg-blue-700 transition-all active:scale-95">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Image Preview Logic
function previewImage(input, previewId, placeholderId = null) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $(`#${previewId}`).attr('src', e.target.result).removeClass('hidden');
            if (placeholderId) $(`#${placeholderId}`).addClass('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// AJAX Submission
$("#profileupdateForm").on('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);
    let btn = $("#submitBtn");

    $.ajax({
        type: "POST",
        url: "{{ route('profile.update') }}",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
            btn.prop('disabled', true).text('Updating...');
        },
        success: function (response) {
            toastr.success(response.message);
            setTimeout(() => location.reload(), 1000);
        },
        error: function(xhr) {
            btn.prop('disabled', false).text('Save Changes');
            let errors = xhr.responseJSON.errors;
            if (errors) {
                Object.values(errors).forEach(err => toastr.error(err[0]));
            } else {
                toastr.error('Something went wrong.');
            }
        }
    });
});
</script>
@endpush
@endsection