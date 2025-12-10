@extends('layouts.main')
@section('content')

<div class="p-6 max-w-7xl mx-auto">

    <!-- Page Title -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            Account Ledger Report
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Account Type Wise Current Balance
        </p>
    </div>

    <!-- ================= MEMBERSHIP ACCOUNTS ================= -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg mb-10 border border-gray-200 dark:border-gray-700">

        <h3 class="text-lg font-semibold px-4 py-3 border-b 
                   bg-gray-100 dark:bg-gray-800 
                   text-gray-800 dark:text-gray-200">
            Membership Project Accounts
        </h3>

        <table class="min-w-full text-sm border-collapse">
            <thead class="bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-center">#</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2">Account Name</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-center">Account No</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right">Current Balance</th>
                </tr>
            </thead>

            <tbody class="text-gray-700 dark:text-gray-300">
                @forelse($membershipAccounts as $key => $acc)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <td class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-center">
                        {{ $key + 1 }}
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
                    <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">
                        No Membership Accounts Found
                    </td>
                </tr>
                @endforelse
            </tbody>

            <!-- FOOTER TOTAL -->
            <tfoot class="bg-gray-200 dark:bg-gray-800 font-bold text-gray-900 dark:text-gray-100">
                <tr>
                    <td colspan="3" class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right">
                        TOTAL
                    </td>
                    <td class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right text-green-700 dark:text-green-400">
                        {{ number_format($membershipTotal, 2) }} BDT
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>


    <!-- ================= OTHER ACCOUNTS ================= -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">

        <h3 class="text-lg font-semibold px-4 py-3 border-b 
                   bg-gray-100 dark:bg-gray-800 
                   text-gray-800 dark:text-gray-200">
            Other Project Accounts
        </h3>

        <table class="min-w-full text-sm border-collapse">
            <thead class="bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-center">#</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2">Account Name</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-center">Account No</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right">Current Balance</th>
                </tr>
            </thead>

            <tbody class="text-gray-700 dark:text-gray-300">
                @forelse($otherAccounts as $key => $acc)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <td class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-center">
                        {{ $key + 1 }}
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
                    <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">
                        No Other Accounts Found
                    </td>
                </tr>
                @endforelse
            </tbody>

            <!-- FOOTER TOTAL -->
            <tfoot class="bg-gray-200 dark:bg-gray-800 font-bold text-gray-900 dark:text-gray-100">
                <tr>
                    <td colspan="3" class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right">
                        TOTAL
                    </td>
                    <td class="border border-gray-300 dark:border-gray-700 px-3 py-2 text-right text-green-700 dark:text-green-400">
                        {{ number_format($otherTotal, 2) }} BDT
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>

@endsection
