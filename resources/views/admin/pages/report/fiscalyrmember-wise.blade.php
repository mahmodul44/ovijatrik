@extends('layouts.main')
@section('content')
<div class="max-w-6xl mx-auto mt-10 px-4 transition-colors duration-300">

    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 flex justify-center items-center gap-2">
            📊 Member Wise Report
        </h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
            View detailed report of each member’s transactions within a selected date range.
        </p>
    </div>

    <!-- Form Container -->
    <div class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl shadow-2xl rounded-2xl p-8 ring-1 ring-gray-200 dark:ring-gray-700">
        <form id="reportForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
        Fiscal Year
    </label>
    <select required name="fiscal_year" id="fiscal_year"
        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
        @php
            $currentYear = date('Y');
            $nextYear = $currentYear + 1;
            $prevYear = $currentYear - 1;
            $years = [
                ($prevYear-1)."-".$prevYear,
                $prevYear."-".$currentYear,
                $currentYear."-".$nextYear,
            ];
        @endphp
        <option value="">-- Select Fiscal Year --</option>
        @foreach($years as $year)
            <option value="{{ $year }}">{{ $year }}</option>
        @endforeach
    </select>
</div>
            
            </div>
            
            <!-- Search Button -->
            <div class="md:col-span-3 flex justify-end mt-4">
                <button type="button" 
                    onclick="openfiscalyrmemberWReportWindow('{{ route('report.fiscalyearmember-wise-report') }}')" 
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-3 rounded-xl shadow-lg hover:shadow-xl font-semibold transition-transform transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-offset-gray-900">
                    🔍 Generate Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>

function openfiscalyrmemberWReportWindow(url) {
    let fiscalYear = document.querySelector("[name='fiscal_year']").value;
    if (!fiscalYear) {
      toastr.error("Please select a Fiscal Year.");
      return;
    }
    let query = `?fiscal_year=${fiscalYear}`;

    let width = 900;
    let height = 650;
    let left = (screen.width / 2) - (width / 2);
    let top = (screen.height / 2) - (height / 2);

    window.open(
        url + query,
        'previewWindow',
        `width=${width},height=${height},top=${top},left=${left},scrollbars=yes,resizable=no`
    );
}
</script>
@endpush
