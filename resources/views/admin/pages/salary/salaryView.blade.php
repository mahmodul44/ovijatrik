@extends('layouts.main')
@section('content')

<section class="pt-4">
    <div class="max-w-7xl mx-auto px-4">

        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Salary List</h2>

                <a href="{{ route('salary.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                    Add New
                </a>
            </div>
        </div>

        <!-- Alerts -->
        <div class="space-y-4 mb-4">
            <div class="alert-danger hidden p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
                <strong>Error!</strong>
                <p class="alert-message">Something went wrong. Please try again...</p>
            </div>

            <div class="alert-success hidden p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
                <strong>Success!</strong>
                <p class="alert-message"><i class="fa fa-spinner fa-spin"></i> Redirecting...</p>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <th class="py-3 px-4 text-center w-12 border">#</th>
                            <th class="py-3 px-4 border">Salary No</th>
                            <th class="py-3 px-4 text-center border">Year</th>
                            <th class="py-3 px-4 text-center border">Month</th>
                            <th class="py-3 px-4 text-center border">Date</th>
                            <th class="py-3 px-4 text-right border">Total Salary</th>
                            <th class="py-3 px-4 text-center border">Status</th>
                            <th class="py-3 px-4 text-center border w-40">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $months = [
                                1 => 'January',
                                2 => 'February',
                                3 => 'March',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'August',
                                9 => 'September',
                                10 => 'October',
                                11 => 'November',
                                12 => 'December',
                            ];
                        @endphp

                        @foreach ($salary as $key => $value)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="py-3 px-4 text-center">{{ $key + 1 }}</td>

                                <td class="py-3 px-4 text-gray-800 dark:text-gray-100">{{ $value->salary_no }}</td>

                                <td class="py-3 px-4 text-center">
                                    {{ $value->salary_year }}
                                </td>

                                <td class="py-3 px-4 text-center">
                                    {{ $months[$value->salary_month] ?? 'N/A' }}
                                </td>

                                <td class="py-3 px-4 text-center">
                                    {{ \Carbon\Carbon::parse($value->salary_date)->format('d/m/Y') }}
                                </td>

                                <td class="py-3 px-4 text-right">
                                    {{ number_format($value->total_salary, 2) }}
                                </td>

                                <td class="py-3 px-4 text-center">
                                    @if ($value->status == 2)
                                        <span class="px-3 py-1 bg-red-500 text-white text-xs rounded-full">
                                            Draft
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-green-600 text-white text-xs rounded-full">
                                            Final
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 text-center space-x-2">
                                    <a href="{{ route('salary.show', $value->salary_id) }}"
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    @if ($value->status == 1 && Auth::user()->role_id == 1)
                                        <form class="deleteSalaryForm inline-block" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <input type="hidden" name="url" class="deleteUrl"
                                                value="{{ route('salary.destroy', $value->salary_id) }}">

                                            <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

@push('scripts')

<script>
$(document).on('submit', '.deleteSalaryForm', function(e) {
    e.preventDefault();
    let deleteUrl = $(this).find('.deleteUrl').val();
    let thisForm = $(".alert-success, .alert-danger");

    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#DC2626',
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {

        if (result.value) {

            $.ajax({
                type: "POST",
                url: deleteUrl,
                data: $(this).serialize(),

                beforeSend: function() {
                    $('.alert-success, .alert-danger').addClass('hidden');
                },

                success: function(response) {
                    $('.alert-success').removeClass('hidden');
                    toastr.success(response.message);

                    setTimeout(() => location.reload(), 1500);
                },

                error: function(xhr) {
                    $('.alert-danger').removeClass('hidden');
                    toastr.error("Unable to delete.");
                }
            });

        }

    });
});
</script>
@endpush
@endsection
