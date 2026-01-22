@extends('layouts.main')
@section('content')
<div class="max-w-5xl mx-auto mt-10 transition-colors duration-300">

    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 tracking-tight">
            📊 Payment Method Wise Report
        </h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">
            Filter and view project-based expense summaries
        </p>
    </div>

    <!-- Form Card -->
    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl shadow-2xl rounded-2xl p-8 ring-1 ring-gray-200 dark:ring-gray-700">
        <form id="reportForm" class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Account -->
            <div>
                <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">
                    Account 
                </label>
                <select required id="account_id" name="account_id"
                class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                
                <option value="">-- Select Account --</option>

                @foreach ($accounts->groupBy('account_type') as $type => $items)
                    <optgroup label="{{ strtoupper($type == 1 ? 'MEMBERSHIP ACCOUNTS' : 'OTHER ACCOUNTS') }}" class="bg-gray-100 dark:bg-gray-700 font-bold text-blue-400">
                        @foreach ($items as $item)
                            <option value="{{ $item->account_id }}" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                                {{ $item->bank_name }} - {{ $item->account_no }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            </div>

             <!-- From Date -->
            <div>
                <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">
                    From Date
                </label>
                <input type="text" name="from_date" id="from_date" autocomplete="off"
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
            </div>

            <!-- To Date -->
            <div>
                <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">
                    To Date
                </label>
                <input type="text" name="to_date" id="to_date" autocomplete="off"
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
            </div>

            <!-- Search Button -->
            <div class="md:col-span-3 flex justify-end mt-4">
                <button type="button"
                    onclick="openAccountWReportWindow('{{ route('report.paymethod-wise-report') }}')"
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

function openAccountWReportWindow(url) {

    let accountId = document.querySelector("[name='account_id']").value;
    let fromDate  = document.querySelector("[name='from_date']").value;
    let toDate    = document.querySelector("[name='to_date']").value;

    if (!accountId) {
      toastr.error("Please select a Account.");
      return;
    }

    let query = `?account_id=${accountId}&from_date=${fromDate}&to_date=${toDate}`;


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
