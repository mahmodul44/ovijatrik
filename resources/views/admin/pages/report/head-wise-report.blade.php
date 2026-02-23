@extends('layouts.main')
@section('content')
<div class="max-w-5xl mx-auto mt-10 transition-colors duration-300">

    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
            📊 Head Wise Report
        </h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">
            Filter and view project-based expense summaries
        </p>
    </div>

    <!-- Form Card -->
    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl shadow-2xl rounded-2xl p-8 ring-1 ring-gray-200 dark:ring-gray-700">
        <form id="reportForm" class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Head -->
            <div>
                <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">
                    Head Name
                </label>
                <select name="category_id" 
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">-- Select Head --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>

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

            <!-- Search Button -->
            <div class="md:col-span-3 flex justify-end mt-4">
                <button type="button"
                    onclick="openHeadWReportWindow('{{ route('report.head-wise-search') }}')"
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transform transition-transform hover:-translate-y-0.5 active:scale-95">
                    🔍 Generate Report
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
flatpickr("#from_date", { dateFormat: "d/m/Y", allowInput: true });
flatpickr("#to_date", { dateFormat: "d/m/Y", allowInput: true });

function openHeadWReportWindow(url) {
    let catId = document.querySelector("[name='category_id']").value;
    let fiscalyear = document.querySelector("[name='fiscal_year']").value;

    if (!catId) {
      toastr.error("Please select a Head.");
      return;
    }

    if (!fiscalyear) {
      toastr.error("Please select a Fiscal Year.");
      return;
    }

    let query = `?category_id=${catId}&fiscal_year=${fiscalyear}`;

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
