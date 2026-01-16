@extends('layouts.main')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-[#f8fafc] dark:bg-[#020617]">
    <div class="max-w-3xl w-full">
<div class="relative z-10 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-slate-200 dark:border-slate-800 p-8 md:p-12">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center p-3 bg-blue-600 rounded-2xl shadow-lg shadow-blue-500/30 mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Statement Generator</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-2 font-medium">Select a date range to view your financial transactions.</p>
            </div>

            <form id="reportForm" class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="relative group">
                        <label for="from_date" class="block text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 ml-1">
                            Start Date
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="from_date" 
                                id="from_date" 
                                class="w-full bg-slate-50 dark:bg-slate-800/50 border-2 border-slate-100 dark:border-slate-700/50 rounded-2xl px-5 py-4 text-slate-900 dark:text-white font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer" 
                                placeholder="DD/MM/YYYY"
                            >
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <label for="to_date" class="block text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 ml-1">
                            End Date
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="to_date" 
                                id="to_date" 
                                class="w-full bg-slate-50 dark:bg-slate-800/50 border-2 border-slate-100 dark:border-slate-700/50 rounded-2xl px-5 py-4 text-slate-900 dark:text-white font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all cursor-pointer" 
                                placeholder="DD/MM/YYYY"
                            >
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="pt-4">
                    <button 
                        type="button" 
                        onclick="openMyReportWindow('{{ route('mytransaction.reportview') }}')" 
                        class="w-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-5 rounded-2xl font-black text-lg shadow-xl shadow-slate-200 dark:shadow-none hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center space-x-3"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Generate Statement</span>
                    </button>
                    
                    <p class="text-center text-slate-400 dark:text-slate-500 text-xs mt-6 font-bold uppercase tracking-widest">
                        Report will open in a new secure window
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    const config = {
        dateFormat: "d/m/Y",
        allowInput: true,
        onReady: function(selectedDates, dateStr, instance) {
            instance.calendarContainer.classList.add('dark:bg-slate-900', 'dark:border-slate-800', 'rounded-2xl', 'shadow-2xl');
        }
    };

    flatpickr("#from_date", config);
    flatpickr("#to_date", config);

    function openMyReportWindow(url) {
        let fromDate = document.getElementById("from_date").value;
        let toDate = document.getElementById("to_date").value;

        if(!fromDate || !toDate) {
            toastr.error("Please select both dates to generate the report.");
            return;
        }

        let query = `?from_date=${fromDate}&to_date=${toDate}`;

        let width = 1100; 
        let height = 800;
        let left = (screen.width - width) / 2;
        let top = (screen.height - height) / 2;

        window.open(
            url + query,
            'StatementPreview',
            `width=${width},height=${height},top=${top},left=${left},scrollbars=yes,resizable=yes`
        );
    }
</script>
@endpush