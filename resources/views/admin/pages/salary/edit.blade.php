@extends('layouts.main')
@section('content')

<div class="max-w-7xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Edit Salary</h2>
        <a href="{{ route('salary.index') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            View All
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <form id="salaryUpdateForm" method="POST" autocomplete="off">
            @csrf
            @method('PUT')

            <!-- Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="salary_year" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Salary Year</label>
                    <select name="salary_year" id="salary_year" required
                        class="w-full px-4 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="{{ date('Y') }}" {{ $salaries->salary_year == date('Y') ? 'selected' : '' }}>{{ date('Y') }}</option>
                        <option value="{{ date('Y')+1 }}" {{ $salaries->salary_year == date('Y')+1 ? 'selected' : '' }}>{{ date('Y')+1 }}</option>
                    </select>
                </div>

                <div>
                    <label for="salary_month" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Salary Month</label>
                    <select name="salary_month" id="salary_month" required
                        class="w-full px-4 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-800 dark:text-gray-200">
                        @php
                        $months = [
                            1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',
                            7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'
                        ];
                        @endphp
                        <option value="">Select</option>
                        @foreach($months as $key => $month)
                        <option value="{{ $key }}" {{ $salaries->salary_month == $key ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="salary_date" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">Salary Date</label>
                    <input type="text" name="salary_date" id="salary_date" required
                        class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="dd/mm/yyyy" value="{{ \Carbon\Carbon::parse($salaries->salary_date)->format('d/m/Y') }}">
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4 md:items-end">    
    <div class="w-full md:w-1/3">
    <label for="account_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Account <span class="text-red-600">*</span></label>
    <select required id="account_id" name="account_id"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
        <option value="">-- Select --</option>
        @foreach ($accounts as $item)
            <option value="{{ $item->account_id }}" {{ $salaries->account_id == $item->account_id ? 'selected' : '' }}>{{ $item->account_name }} ({{ $item->account_no }})</option>
        @endforeach
    </select>
    </div>

    <div class="w-full md:w-1/3">
      <label for="posting_type" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Posting Type <span class="text-red-600">*</span></label>
        <select required id="posting_type" name="posting_type"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            <option value="">-- Select --</option>
            <option value="0" {{ $salaries->posting_type == '0' ? 'selected' : '' }}>Draft</option>
            <option value="1" {{ $salaries->posting_type == '1' ? 'selected' : '' }}>Final</option>
       </select>
     </div>
    </div>
            <!-- Employees Table -->
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 mt-4">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <th class="py-3 px-4 border dark:border-gray-600">#</th>
                            <th class="py-3 px-4 border dark:border-gray-600">Employee Name</th>
                            <th class="py-3 px-4 border dark:border-gray-600">Position</th>
                            <th class="py-3 px-4 border dark:border-gray-600">Phone No</th>
                            <th class="py-3 px-4 border dark:border-gray-600">Salary Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($employees as $key => $emp)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-200">{{ $key+1 }}</td>
                            <td class="py-3 px-4 font-medium text-gray-900 dark:text-gray-100">{{ $emp->name }}</td>
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $emp->designation }}</td>
                            <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $emp->phone_no }}</td>
                            <td class="py-3 px-4">
                                <input type="hidden" name="employees[{{ $emp->id }}][id]" value="{{ $emp->id }}">
                                <input type="number" name="employees[{{ $emp->id }}][salary]" value="{{ $emp->salary ?? 0 }}" required
                                    class="w-full px-3 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Submit -->
            <div class="mt-6">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2">
                    <span class="esc-loading-button hidden">
                        <i class="fa fa-spinner fa-spin"></i>
                    </span>
                    <span class="submit-btn">Update</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#salary_date", { dateFormat: "d/m/Y", allowInput: true });
});

$('#salaryUpdateForm').on('submit', function(e) {
    e.preventDefault();
    let form = $(this);
    var formData = new FormData(this);

    $.ajax({
        type: "POST",
        url: "{{ route('salary.update', $salaries->salary_id) }}",
        data: formData,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            form.find(".esc-loading-button").removeClass('hidden');
            form.find('.submit-btn').text('Updating...');
        },
        success: function(res) {
            toastr.success(res.message);
            setTimeout(function() { window.location.href = "{{ route('salary.index') }}"; }, 1000);
        },
        error: function(xhr) {
            var res = $.parseJSON(xhr.responseText);
            toastr.error(res.message);
        }
    });
});
</script>
@endpush

@endsection
