@extends('layouts.main')
@section('content')

<div class="max-w-6xl mx-auto py-6 px-4">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Salary Preview</h2>
        <a href="{{ route('salary.index') }}"
           class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm">
            Back to List
        </a>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
            <p class="text-gray-600 dark:text-gray-300 text-sm">Salary Year</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">
                {{ $salary->salary_year }}
            </p>
        </div>

        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
            <p class="text-gray-600 dark:text-gray-300 text-sm">Salary Month</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">
                {{ $months[$salary->salary_month] ?? 'N/A' }}
            </p>
        </div>

        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
            <p class="text-gray-600 dark:text-gray-300 text-sm">Date</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($salary->salary_date)->format('d/m/Y') }}
            </p>
        </div>

    </div>

    <!-- Salary Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full border border-gray-300 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                <tr class="text-center">
                    <th class="py-2 px-3 border">#</th>
                    <th class="py-2 px-3 border">Employee</th>
                    <th class="py-2 px-3 border">Phone</th>
                    <th class="py-2 px-3 border">Pay Amount</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $i = 0;
                    $total = 0;
                @endphp

                @foreach($salary->salaryDetails as $detail)
                    @if($detail->salary_amount > 0)
                        @php
                            $i++;
                            $total += $detail->salary_amount;
                        @endphp

                        <tr class="text-center border-b dark:border-gray-700">
                            <td class="py-2 px-3">{{ $i }}</td>
                            <td class="py-2 px-3">{{ $detail->employee->name }}</td>
                            <td class="py-2 px-3">{{ $detail->employee->phone_no }}</td>
                            <td class="py-2 px-3 text-right pr-5">
                                {{ number_format($detail->salary_amount,2) }}
                            </td>
                        </tr>

                    @endif
                @endforeach
            </tbody>

            <tfoot>
                <tr class="bg-gray-100 dark:bg-gray-700 font-bold">
                    <td colspan="3" class="py-2 px-3 text-right">Total</td>
                    <td class="py-2 px-3 text-right pr-5">{{ number_format($total,2) }}</td>
                </tr>
            </tfoot>

        </table>
    </div>

    <!-- Approve & Decline Section -->
    <div class="mt-6 flex gap-4">

        <!-- Approve -->
        <form action="{{ route('salary.salaryapprove', $salary->salary_id) }}" method="POST">
            @csrf
            <button type="submit"
                class="px-6 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                Approve
            </button>
        </form>

        <!-- Decline Button -->
        <button onclick="document.getElementById('declineBox').classList.remove('hidden')"
            class="px-6 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
            Decline
        </button>

    </div>

    <!-- Decline Remark Box -->
    <div id="declineBox" class="hidden mt-6 bg-white dark:bg-gray-800 p-5 rounded-lg shadow-lg">

        <form action="{{ route('salary.salarydecline', $salary->salary_id) }}" method="POST">
            @csrf

            <label class="block text-gray-700 dark:text-gray-300 mb-2 font-medium">
                Remark (Reason of Decline)
            </label>

            <textarea name="remark" required class="w-full p-3 rounded-lg border dark:border-gray-600 
                     bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white" rows="4"
                      placeholder="Enter decline reason..."></textarea>

            <div class="mt-4">
                <button class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
                    Submit Decline
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
