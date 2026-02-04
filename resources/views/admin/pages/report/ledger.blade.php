@extends('layouts.main')
@section('content')
<div class="p-6 max-w-6xl mx-auto transition-colors duration-300">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Other Project Ledger</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                Overview of all Project Balance
            </p>
        </div>
    </div>
    @php
        $specialId = 10000001;
        $specialLedgers = $ledgers->filter(fn($row) => $row->project_id == $specialId);
        $otherLedgers   = $ledgers->filter(fn($row) => $row->project_id != $specialId);
    @endphp

    <!-- Report Table Card -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-xl rounded-2xl ring-1 ring-gray-200 dark:ring-gray-700">

<table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
    <thead class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700">
        <tr>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">#</th>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Project Code</th>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Project Name</th>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Balance (BDT)</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
        @php $i = 0; @endphp
        @forelse($otherLedgers as $key => $value)
        @php $i++; @endphp
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition duration-200">
                <td class="px-6 py-4">{{ $i }}</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $value->project->project_code }}</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-100">
                    @if($value->project_id)
                        {{ $value->project->project_title ?? 'N/A' }}
                    @else
                        <span class="italic text-gray-500 dark:text-gray-400">Others Expense</span>
                    @endif
                </td>

                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-200">
                    {{ number_format($value->total_amount, 2) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center px-6 py-5 text-gray-500 dark:text-gray-400">
                    No records found.
                </td>
            </tr>
        @endforelse
    </tbody>

    <tfoot class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700">
        <tr>
            <td colspan="3" class="px-6 py-3 text-right font-semibold">Total Balance:</td>
            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-200">
                {{ number_format($otherLedgers->sum('total_amount'), 2) }}
            </td>
        </tr>
    </tfoot>
</table>
    </div>

</div>
@endsection
