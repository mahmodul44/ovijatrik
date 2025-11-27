@extends('layouts.main')
@section('content')

<div class="max-w-7xl mx-auto p-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
            Pending Salary List (Month-wise)
        </h2>
    </div>

    <!-- Filter: Year + Month -->
    {{-- <form method="GET" class="flex flex-col md:flex-row gap-4 mb-6">

        @php
            $currentYear = date('Y');
            $years = [
                $currentYear - 1,
                $currentYear,
                $currentYear + 1
            ];
        @endphp

        <!-- Year Dropdown -->
        <select name="year"
            class="px-4 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 dark:border-gray-600
                   text-gray-900 dark:text-gray-200 w-full md:w-auto">

            <option value="">All Year</option>

            @foreach($years as $year)
                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>

        <!-- Month Dropdown -->
        <select name="salary_month" id="salary_month"
            class="px-4 py-2 rounded-lg border bg-gray-50 dark:bg-gray-700 dark:border-gray-600
                   text-gray-900 dark:text-gray-200 w-full md:w-auto">

            <option value="">All Months</option>

            @for($m=1; $m<=12; $m++)
                <option value="{{ $m }}" {{ request('salary_month') == $m ? 'selected' : '' }}>
                    {{ date("F", mktime(0, 0, 0, $m, 1)) }}
                </option>
            @endfor
        </select>

        <!-- Filter Button -->
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition w-full md:w-auto">
            Filter
        </button>

    </form> --}}


    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">

            <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <th class="py-3 px-4 text-center w-12 border">#</th>
                            <th class="py-3 px-4 border">Salary No</th>
                            <th class="py-3 px-4 text-center border">Year</th>
                            <th class="py-3 px-4 text-center border">Month</th>
                            <th class="py-3 px-4 text-center border">Date</th>
                            <th class="py-3 px-4 text-right border">Total Salary</th>
                            <th class="py-3 px-4 text-center border">Status</th>
                            <th class="py-3 px-4 text-center border w-40">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $months = [
                                1 => 'January',
                                2 => 'February',
                                3 => 'March',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'August',
                                9 => 'September',
                                10 => 'October',
                                11 => 'November',
                                12 => 'December',
                            ];
                        @endphp

                        @foreach ($pendingList as $key => $value)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-100">{{ $key + 1 }}</td>

                                <td class="py-3 px-4 text-gray-800 dark:text-gray-100">{{ $value->salary_no }}</td>

                                <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-100">
                                    {{ $value->salary_year }}
                                </td>

                                <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-100">
                                    {{ $months[$value->salary_month] ?? 'N/A' }}
                                </td>

                                <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($value->salary_date)->format('d/m/Y') }}
                                </td>

                                <td class="py-3 px-4 text-right text-gray-800 dark:text-gray-100">
                                    {{ number_format($value->total_salary, 2) }}
                                </td>

                                <td class="py-3 px-4 text-center">
                                    @if ($value->status == 0)
                                        <span class="px-3 py-1 bg-red-500 text-white text-xs rounded-full">
                                            Pending
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-green-600 text-white text-xs rounded-full">
                                            Approved
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 text-center space-x-2 flex items-center justify-center">

                                <!-- Show -->
                                <a href="{{ route('salary.show', $value->salary_id) }}"
                                    class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>

                                <!-- Delete -->
                                @if ($value->posting_type == 0)
                                <!-- Edit -->
                                <a href="{{ route('salary.edit', $value->salary_id) }}"
                                    class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.313 3 21l1.687-4.5L16.862 3.487z" />
                                    </svg>
                                </a>
                                    <form class="deleteSalaryForm inline-block" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="url" class="deleteUrl"
                                            value="{{ route('salary.destroy', $value->salary_id) }}">

                                        <button type="submit"
                                            class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 inline-flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 7h12M9 7V4h6v3m-7 4v6m4-6v6m4-6v6M4 7h16l-1 12a2 2 0 01-2 2H7a2 2 0 01-2-2L4 7z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>

        </div>
    </div>

</div>
@endsection
