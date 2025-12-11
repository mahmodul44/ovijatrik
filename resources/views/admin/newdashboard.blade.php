@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

{{-- Admin Dashboard --}}
@if($user->role == 1)

<div class="space-y-8">

    {{-- Top KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Total Donations --}}
        <div class="p-6 rounded-2xl shadow bg-gradient-to-br from-blue-50 to-blue-100 
            dark:from-blue-900 dark:to-blue-800 transition">
            <h2 class="text-sm font-medium text-blue-700 dark:text-blue-300">TOTAL DONATIONS</h2>
            <p class="text-3xl font-bold text-blue-700 dark:text-blue-200 mt-2">
                ৳ {{ number_format($totalDonations,2) }}
            </p>
        </div>

        {{-- Total Donors --}}
        <div class="p-6 rounded-2xl shadow bg-gradient-to-br from-green-50 to-green-100 
            dark:from-green-900 dark:to-green-800 transition">
            <h2 class="text-sm font-medium text-green-700 dark:text-green-300">TOTAL DONORS</h2>
            <p class="text-3xl font-bold text-green-700 dark:text-green-200 mt-2">
                {{ $totalDonors }}
            </p>
        </div>

        {{-- This Month Donation --}}
        <div class="p-6 rounded-2xl shadow bg-gradient-to-br from-purple-50 to-purple-100 
            dark:from-purple-900 dark:to-purple-800 transition">
            <h2 class="text-sm font-medium text-purple-700 dark:text-purple-300">THIS MONTH</h2>
            <p class="text-3xl font-bold text-purple-700 dark:text-purple-200 mt-2">
                ৳ {{ number_format($donationThisMonth,2) }}
            </p>
        </div>

        {{-- Last Donation --}}
        <div class="p-6 rounded-2xl shadow bg-gradient-to-br from-pink-50 to-pink-100 
            dark:from-pink-900 dark:to-pink-800 transition">
            <h2 class="text-sm font-medium text-pink-700 dark:text-pink-300">LAST DONATION</h2>
            <p class="text-xl font-semibold text-pink-700 dark:text-pink-200 mt-2">
                {{ $lastDonation ? \Carbon\Carbon::parse($lastDonation->payment_date)->format('d M, Y') : 'N/A' }}
            </p>
        </div>

    </div>

    {{-- Analytics Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Donation Trend Chart --}}
        <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow">
            <h2 class="text-lg font-semibold mb-4 dark:text-gray-100">Donation Trend (Last 6 Months)</h2>
            <canvas id="donationChart"></canvas>
        </div>

        {{-- Top Donors --}}
        <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl shadow">
            <h2 class="text-lg font-semibold mb-4 dark:text-gray-100">Top Donors (Member)</h2>

            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($topDonors as $d)
                <li class="py-3 flex justify-between">
                    <span class="font-medium dark:text-gray-200">{{ $d->member->member_id }} - {{ $d->member->name }}</span>
                    <span class="font-semibold text-blue-600 dark:text-blue-300">৳ {{ number_format($d->total,2) }}</span>
                </li>
                @endforeach
            </ul>
        </div>

    </div>

    {{-- Latest Donations Table --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
        <h2 class="text-xl font-semibold mb-4 dark:text-gray-100">Recent Donations</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <th class="px-4 py-2 text-left">Receipt No</th>
                        <th class="px-4 py-2 text-left">Donor</th>
                        <th class="px-4 py-2 text-left">Amount</th>
                        <th class="px-4 py-2 text-left">Method</th>
                        <th class="px-4 py-2 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestDonations as $item)
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-2 dark:text-gray-200">{{ $item->mr_no }}</td>
                        <td class="px-4 py-2 dark:text-gray-200">{{ $item->member_id ?  $item->member->name : $item->donar_name }}</td>
                        <td class="px-4 py-2 text-green-600 font-medium">৳ {{ number_format($item->payment_amount,2) }}</td>
                        <td class="px-4 py-2 dark:text-gray-200">{{ $item->paymentmethod->pay_method_name }}</td>
                        <td class="px-4 py-2 dark:text-gray-200">{{ \Carbon\Carbon::parse($item->payment_date)->format('d M, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endif


    {{-- Employee --}}
    @if($user->role == 2)
        <p class="text-lg text-gray-600 dark:text-gray-400">Welcome {{ $user->name }}</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-indigo-50 dark:bg-indigo-900 p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
            <h2 class="font-bold text-lg text-indigo-700 dark:text-indigo-300 mb-2">Added Donations</h2>
            <p class="text-3xl font-semibold text-indigo-600 dark:text-indigo-400">৳ {{ number_format($totalHandledDonations,2) }}</p>
        </div>
        <div class="bg-yellow-50 dark:bg-yellow-900 p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
            <h2 class="font-bold text-lg text-yellow-700 dark:text-yellow-300 mb-2">Last Donation Added</h2>
            <p class="text-2xl font-medium text-yellow-600 dark:text-yellow-400">
                {{ $lastDonation ? \Carbon\Carbon::parse($lastDonation->payment_date)->format('d M, Y') : 'N/A' }}
            </p>
        </div>
      
    </div>
    @endif

    {{-- Donor --}}
    @if($user->role == 3)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-green-50 dark:bg-green-900 p-6 rounded-lg shadow hover:shadow-xl transition duration-300">
            <h2 class="text-lg font-bold mb-2 text-green-700 dark:text-green-300">Total This Year</h2>
            <p class="text-3xl font-semibold text-green-600 dark:text-green-400">৳ {{ number_format($totalThisYear,2) }}</p>
        </div>

        <div class="bg-blue-50 dark:bg-blue-900 p-6 rounded-lg shadow hover:shadow-xl transition duration-300">
            <h2 class="text-lg font-bold mb-2 text-blue-700 dark:text-blue-300">Total Donations</h2>
            <p class="text-3xl font-semibold text-blue-600 dark:text-blue-400">৳ {{ number_format($totalAllTime,2) }}</p>
        </div>

        <div class="bg-yellow-50 dark:bg-yellow-900 p-6 rounded-lg shadow hover:shadow-xl transition duration-300">
            <h2 class="text-lg font-bold mb-2 text-yellow-700 dark:text-yellow-300">Donation Frequency</h2>
            <span class="inline-block bg-yellow-200 dark:bg-yellow-700 text-yellow-800 dark:text-yellow-100 px-3 py-1 rounded-full text-sm font-semibold">
                {{ $frequency }}
            </span>
        </div>
    </div>

    <div class="bg-blue-100 dark:bg-blue-800 border-l-4 border-blue-500 dark:border-blue-400 text-blue-800 dark:text-blue-200 p-4 rounded-md shadow-lg flex items-center justify-between transition duration-300 hover:shadow-xl" role="alert">
    <div class="flex items-center space-x-3">
        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
        
        <p class="font-semibold text-lg">
           Last Donation:
            <span class="ml-2 font-bold text-blue-700 dark:text-blue-300">
                {{ $lastDonation ? \Carbon\Carbon::parse($lastDonation->payment_date)->format('d M, Y') : 'কোনো অনুদান নেই' }}
            </span>
        </p>
    </div>
    
    <div class="flex items-center">
        <span class="text-2xl font-extrabold text-blue-600 dark:text-blue-400">
            ৳ {{ number_format($lastDonateAmount,2) }}
        </span>
    </div>
</div>
 
    {{-- Fiscal Year Summary Table --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-100">Fiscal Year Summary</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 dark:border-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Fiscal Year</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Total Amount</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">No. of Donations</th>
                        <th class="px-4 py-2 text-left text-gray-700 dark:text-gray-200">Last Donation Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fiscalSummary as $fy)
                        <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $fy['year'] }}</td>
                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">৳ {{ number_format($fy['total'],2) }}</td>
                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $fy['count'] }}</td>
                            <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{ $fy['last_date'] ? \Carbon\Carbon::parse($fy['last_date'])->format('d M, Y') : 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">No donations found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6">
    <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-100">
        Receipt Months (Current Fiscal Year)
    </h2>

    @if(count($receiptMonths))
        <div class="text-gray-800 dark:text-gray-200 text-sm leading-6">

            {{-- Convert array to comma-separated string --}}
            {{ implode(', ', $receiptMonths) }}

        </div>
    @else
        <p class="text-gray-500 dark:text-gray-400">No receipt months found</p>
    @endif
</div>


    @endif
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('donationChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['months']),
            datasets: [{
                label: 'Donations',
                data: @json($chartData['amounts']),
                borderWidth: 3,
                borderColor: '#4F46E5',
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

</script>
@endpush
@endsection
