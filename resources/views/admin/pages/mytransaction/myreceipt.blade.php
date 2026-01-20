@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-[#f8fafc] dark:bg-[#020617] py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="relative overflow-hidden rounded-[2rem] bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-8 mb-8 shadow-xl shadow-blue-500/5">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[10px] font-black uppercase tracking-widest">Finance Portal</span>
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">Financial Records</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 font-medium">Manage and download your contribution receipts with ease.</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-700">
                        <p class="text-[10px] text-slate-400 uppercase font-black tracking-tighter">Current Fiscal Year</p>
                        <p class="text-lg font-black text-slate-900 dark:text-white leading-none mt-1">2025 - 2026</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-6 py-4 rounded-2xl text-sm font-bold transition-all hover:scale-105 active:scale-95 shadow-lg">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 shadow-2xl rounded-[2.5rem] border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="overflow-x-auto p-2">
                <table id="myreceiptTable" class="w-full text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-slate-400">
                            <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest !text-center">Date</th>
                            <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest">Project Description</th>
                            <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest">Payment Info</th>
                            <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-right">Amount</th>
                            <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest !text-center">Receipt Detail</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent">
                        @foreach($moneyreceipts as $value)
                        <tr class="group bg-slate-50/50 dark:bg-slate-800/20 hover:bg-white dark:hover:bg-slate-800 transition-all duration-300">
                            <td class="px-6 py-5 first:rounded-l-2xl">
                                <span class="block text-sm font-black text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($value->payment_date)->format('d M, Y') }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="max-w-[220px]">
                                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200 truncate">{{ $value->project->project_title ?? 'General' }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Inv No: {{ $value->mr_no }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-slate-700 dark:text-slate-200 uppercase">{{ $value->paymentmethod->pay_method_name ?? 'Cash' }}</span>
                                        <span class="text-[10px] text-slate-400 italic font-medium">By: {{ $value->createdUser->name ?? 'Admin' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <span class="text-lg font-black text-slate-900 dark:text-white">৳{{ number_format($value->payment_amount, 0) }}</span>
                            </td>
                            <td class="px-6 py-5 last:rounded-r-2xl text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openPreviewWindow('{{ route('moneyreceipt.invoicedownload', $value->mr_id) }}')" 
                                            class="p-2.5 rounded-xl bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 hover:shadow-lg transition-all border border-slate-100 dark:border-slate-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <a href="{{ route('moneyreceipt.invoicedownload', $value->mr_id) }}?download=true" 
                                       class="p-2.5 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:scale-110 transition-all shadow-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
  $(document).ready(function () {
        $('#myreceiptTable').DataTable({
            responsive: true,
            // 'l' shows the length dropdown (entries)
            // 'f' is the filter (search)
            // 't' is the table
            // 'i' is the info
            // 'p' is the pagination
            "dom": '<"flex flex-col md:flex-row justify-between items-center p-6 bg-slate-50/50 dark:bg-slate-800/50 gap-4"lf>rt<"flex flex-col md:flex-row justify-between items-center p-6 gap-4"ip>',
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language": {
                "lengthMenu": "Show _MENU_ entries",
                "search": "",
                "searchPlaceholder": "Search records...",
                "paginate": {
                    "previous": '<span class="flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Previous</span>',
                    "next": '<span class="flex items-center gap-1">Next <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></span>'
                }
            }
        });

        $('.dataTables_filter input').addClass('bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none w-64 transition-all');
        $('.dataTables_length select').addClass('bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none mx-2 transition-all cursor-pointer');
    });

    function openPreviewWindow(url) {
        const width = 1000;
        const height = 800;
        const left = (screen.width - width) / 2;
        const top = (screen.height - height) / 2;
        window.open(url, 'ReceiptPreview', `width=${width},height=${height},top=${top},left=${left},scrollbar=yes`);
    }
</script>

<style>
    .paginate_button {
        @apply px-4 py-2 rounded-xl text-sm font-bold transition-all !important;
    }
    .paginate_button.current {
        @apply bg-blue-600 text-white !important;
    }
    .dataTables_info {
        @apply text-sm text-slate-400 font-bold !important;
    }
</style>
@endpush
@endsection
