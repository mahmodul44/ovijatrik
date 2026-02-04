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
            <!-- Member -->
            <div class="w-full">
                <label for="member_id" class="block text-gray-700 dark:text-gray-200 font-medium mb-1">
                    Member <span class="text-red-600">*</span>
                </label>
                <select required id="member_id" name="member_id" class="member-select block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                </select>
            </div> 
            <div>
                <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">
                   Membership Project Account 
                </label>
                <select id="account_id" name="account_id"
                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                    <option value="">-- Select --</option>
                    @foreach ($accounts as $item)
                        <option value="{{ $item->account_id }}">
                            {{ $item->bank_name }} - {{ $item->account_no }}
                        </option>
                    @endforeach
                </select>
            </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- From Date -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    From Date
                </label>
                <input type="text" name="from_date" id="from_date" autocomplete="off"
                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
            </div>

            <!-- To Date -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                    To Date
                </label>
                <input type="text" name="to_date" id="to_date" autocomplete="off"
                       class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
            </div>
            </div>
            <!-- Search Button -->
            <div class="md:col-span-3 flex justify-end mt-4">
                <button type="button" 
                    onclick="openMemberWReportWindow('{{ route('report.member-wise-search') }}')" 
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
flatpickr("#from_date", { dateFormat: "d/m/Y", allowInput: true });
flatpickr("#to_date", { dateFormat: "d/m/Y", allowInput: true });
$('.member-select').select2({
        placeholder: "Search by Name, ID, or Mobile",
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            url: '{{ route("member.search") }}', 
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term 
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });

    $('.member-select').on('select2:open', function () {
        setTimeout(() => {
            document.querySelector('.select2-container--open .select2-search__field').focus();
        }, 100);
    });
function openMemberWReportWindow(url) {
    let memberId = document.querySelector("[name='member_id']").value;
    let fromDate  = document.querySelector("[name='from_date']").value;
    let toDate    = document.querySelector("[name='to_date']").value;
    let account_id = document.querySelector("[name='account_id']").value;

    let query = `?member_id=${memberId}&account_id=${account_id}&from_date=${fromDate}&to_date=${toDate}`;

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
