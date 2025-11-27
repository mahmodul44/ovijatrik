@extends('layouts.main')
@section('content')

<div class="max-w-7xl mx-auto p-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
            Add Salary
        </h2>

        <a href="{{ route('salary.index') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            View All
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-200 dark:border-gray-700">

        <form id="salaryInsertForm" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            
            <!-- Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                
                <!-- Year -->
                <div>
                    <label for="salary_year" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">
                        Salary Year
                    </label>
                    <select name="salary_year" id="salary_year" required
                        class="w-full px-4 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select</option>
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                        <option value="{{ date('Y') + 1 }}">{{ date('Y') + 1 }}</option>
                    </select>
                </div>

                <!-- Month -->
                <div>
                    <label for="salary_month" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">
                        Salary Month
                    </label>
                    <select name="salary_month" id="salary_month" required
                        class="w-full px-4 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 text-gray-800 dark:text-gray-200">
                        <option value="">Select</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label for="salary_date" class="block text-gray-700 dark:text-gray-300 mb-1 font-medium">
                        Salary Date
                    </label>
                     <input type="text" required name="salary_date" id="salary_date"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 
                               focus:outline-none focus:ring-2 focus:ring-blue-500 
                               focus:border-blue-500 shadow-sm"
                        placeholder="dd/mm/yyyy" autocomplete="off">
                </div>

            </div>

<div class="flex flex-col md:flex-row gap-4 md:items-end">    
    <div class="w-full md:w-1/3">
    <label for="account_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Account <span class="text-red-600">*</span></label>
    <select required id="account_id" name="account_id"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
        <option value="">-- Select --</option>
        @foreach ($accounts as $item)
            <option value="{{ $item->account_id }}">{{ $item->account_name }} ({{ $item->account_no }})</option>
        @endforeach
    </select>
    </div>

    <div class="w-full md:w-1/3">
      <label for="posting_type" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Posting Type <span class="text-red-600">*</span></label>
        <select required id="posting_type" name="posting_type"
            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
            <option value="">-- Select --</option>
            <option value="0">Draft</option>
            <option value="1">Final</option>
       </select>
     </div>
    </div>

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
            @foreach($employees as $key => $value)
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <!-- Number -->
                    <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-200">
                        {{ $key + 1 }}
                    </td>

                    <!-- Name -->
                    <td class="py-3 px-4 font-medium text-gray-900 dark:text-gray-100">
                        {{ $value->name }}
                    </td>

                    <!-- Position -->
                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                        {{ $value->designation }}
                    </td>

                    <!-- Phone -->
                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                        {{ $value->phone_no }}
                    </td>

                    <!-- Salary Input -->
                    <td class="py-3 px-4">
                        <input type="hidden" name="employees[{{ $value->id }}][id]" value="{{ $value->id }}">

                        <input type="number"
                            name="employees[{{ $value->id }}][salary]"
                            value="{{ $value->salary ?? 0 }}"
                            required
                            class="w-full px-3 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 
                                   border-gray-300 dark:border-gray-600 
                                   text-gray-900 dark:text-gray-100 
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
    <tr class="bg-gray-200 dark:bg-gray-700 font-semibold text-gray-900 dark:text-gray-100">
        <td colspan="4" class="py-3 px-4 text-right border dark:border-gray-600">
            Total Salary:
        </td>
        <td class="py-3 px-4 border dark:border-gray-600">
            <span id="total_salary">0</span>
        </td>
    </tr>
</tfoot>

    </table>
</div>


            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2">
                    <span class="esc-loading-button hidden">
                        <i class="fa fa-spinner fa-spin"></i>
                    </span>
                    <span class="submit-btn">Submit</span>
                </button>
            </div>

        </form>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#salary_date", {
        dateFormat: "d/m/Y",
        allowInput: true
    });
});

function calculateTotalSalary() {
    let total = 0;

    $('input[name*="[salary]"]').each(function () {
        let val = parseFloat($(this).val()) || 0;
        total += val;
    });

    $('#total_salary').text(total.toFixed(2));
}

// Auto calculate on page load
$(document).ready(function () {
    calculateTotalSalary();

    // Auto calculate whenever salary changes
    $(document).on("input", 'input[name*="[salary]"]', function () {
        calculateTotalSalary();
    });
});

$(document).ready(function () {
    $('#salaryInsertForm').on('submit', function (e) {
        e.preventDefault();
        let thisForm = $(this);
        var formData = new FormData(thisForm[0]);

        $.ajax({
            type: "POST",
            url: "{{ route('salary.store') }}",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,

            beforeSend: function () {
                thisForm.find(".esc-loading-button").removeClass('hidden');
                thisForm.find('button[type="submit"]').addClass('opacity-50 cursor-not-allowed');
                thisForm.find('.submit-btn').text('Submitting...');
            },

            success: function (response) {
                toastr.success(response.message);

                setTimeout(function () {
                    location.href = "{{ route('salary.index') }}";
                }, 1000);
            },

            error: function (xhr) {
                var response = $.parseJSON(xhr.responseText);
                toastr.error(response.message);
            }
        });
    });
});
</script>
@endpush
@endsection
