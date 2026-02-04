@extends('layouts.main')
@section('content')
<div class="p-6 max-w-6xl mx-auto transition-colors duration-300">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Membership Project Ledger</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                Overview of Project & Account Balance
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

<table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
    <thead class="bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700">
        <tr>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">#</th>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Account</th>
            <th class="px-6 py-3 text-left font-semibold uppercase text-xs tracking-wider">Current Balance</th>
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
                    {{ number_format($value->total_amount, 2) }} BDT
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
</table>
    </div>
<br>
  <!-- ================= MEMBERSHIP ACCOUNTS ================= -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg mb-10 border border-gray-200 dark:border-gray-700">

        <h3 class="text-lg font-semibold px-4 py-3 border-b 
                   bg-gray-100 dark:bg-gray-800 
                   text-gray-800 dark:text-gray-200">
            Membership Project Account Details
        </h3>

        <table class="min-w-full text-sm border-collapse">
            <thead class="bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-center">#</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2">Bank Name</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2">Account Name</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-center">Account No</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right">Current Balance</th>
                </tr>
            </thead>

            <tbody class="text-gray-700 dark:text-gray-300">
                @php $totalBalance = 0; @endphp
                @forelse($membershipAccounts as $key => $acc)
                @php $totalBalance += $acc->current_balance; @endphp
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <td class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-center">
                        {{ $key + 1 }}
                    </td>
                    <td class="border border-gray-300 dark:border-gray-700 px-3 py-2">
                        {{ $acc->bank_name }}
                    </td>
                    <td class="border border-gray-300 dark:border-gray-700 px-3 py-2">
                        {{ $acc->account_name }}
                    </td>

                    <td class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-center">
                        {{ $acc->account_no }}
                    </td>

                    <td class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right font-bold
                        {{ $acc->current_balance >= 0 
                            ? 'text-green-600 dark:text-green-400' 
                            : 'text-red-600 dark:text-red-400' }}">
                        {{ number_format($acc->current_balance, 2) }} BDT
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500 dark:text-gray-400">
                        No Membership Accounts Found
                    </td>
                </tr>
                @endforelse
            </tbody>

            <!-- FOOTER TOTAL -->
            <tfoot class="bg-gray-200 dark:bg-gray-800 font-bold text-gray-900 dark:text-gray-100">
                <tr>
                    <td colspan="4" class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right">
                        TOTAL
                    </td>
                    <td class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right
                        {{ $totalBalance >= 0 ? 'text-green-700 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        {{ number_format($totalBalance, 2) }} BDT
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>   

</div>
@endsection
