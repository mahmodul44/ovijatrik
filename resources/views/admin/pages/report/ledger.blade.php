@extends('layouts.main')
@section('content')
<div class="p-6 max-w-6xl mx-auto transition-colors duration-300">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Project Ledger</h1>
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
        {{-- ============================
     TABLE 1 : Special Project
=============================== --}}
<h2 class="text-lg font-bold mb-3 mt-6 text-blue-600"></h2>

<table class="min-w-full text-sm text-gray-700 dark:text-gray-200 mb-10">
    <thead class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700">
        <tr>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">#</th>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Account</th>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Balance</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
        @forelse($specialLedgers as $index => $value)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition duration-200">
                <td class="px-6 py-4">{{ $index + 1 }}</td>

                <td class="px-6 py-4">
                    {{ $value->project->project_title ?? 'N/A' }}
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
            <td colspan="2" class="px-6 py-3 text-right font-semibold">Current Balance:</td>
            <td class="px-6 py-3 font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500">
                {{ number_format($specialLedgers->sum('total_amount'), 2) }}
            </td>
        </tr>
    </tfoot>
</table>


{{-- ============================
     TABLE 2 : Other Projects
=============================== --}}
<h2 class="text-lg font-bold px-3 mb-3 text-green-600">Other Projects</h2>

<table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
    <thead class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700">
        <tr>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">#</th>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Account</th>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Balance</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
        @forelse($otherLedgers as $index => $value)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition duration-200">
                <td class="px-6 py-4">{{ $index + 1 }}</td>

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
            <td colspan="2" class="px-6 py-3 text-right font-semibold">Total Balance:</td>
            <td class="px-6 py-3 font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-500">
                {{ number_format($otherLedgers->sum('total_amount'), 2) }}
            </td>
        </tr>
    </tfoot>
</table>
    </div>

</div>
@endsection
