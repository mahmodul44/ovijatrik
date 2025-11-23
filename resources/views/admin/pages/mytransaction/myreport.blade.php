@extends('layouts.main')

@section('content')
<div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl mt-8 transition duration-500">
    <h2 class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 mb-6 border-b pb-2 border-gray-200 dark:border-gray-700">
        📊 My Transaction Report
    </h2>
    
    <form id="reportForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="from_date" class="block text-sm font-medium **text-gray-700 dark:text-white mb-1">
                📅 From Date
            </label>
            <input 
                type="text" 
                name="from_date" 
                id="from_date" 
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                autocomplete="off"
                placeholder="dd/mm/yyyy"
            >
        </div>

        <div>
            <label for="to_date" class="block text-sm font-medium **text-gray-700 dark:text-white mb-1">
                📆 To Date
            </label>
            <input 
                type="text" 
                name="to_date" 
                id="to_date" 
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition duration-150" 
                autocomplete="off"
                placeholder="dd/mm/yyyy"
            >
        </div>

        <div class="md:col-span-2 flex justify-end mt-4">
            <button 
                type="button" 
                onclick="openMyReportWindow('{{ route('mytransaction.reportview') }}')" 
                class="bg-blue-600 text-white px-8 py-2.5 rounded-xl shadow-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition duration-300 transform hover:scale-105 font-semibold flex items-center space-x-2"
            >
                <span class="text-xl">🔍</span>
                <span>Generate Report</span>
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
// ... (Your existing JavaScript code for flatpickr and openMyReportWindow)
flatpickr("#from_date", { dateFormat: "d/m/Y", allowInput: true });
flatpickr("#to_date", { dateFormat: "d/m/Y", allowInput: true });

function openMyReportWindow(url) {
    
    let fromDate  = document.querySelector("[name='from_date']").value;
    let toDate    = document.querySelector("[name='to_date']").value;

    let query = `?from_date=${fromDate}&to_date=${toDate}`;

    let width = 800;
    let height = 600;
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