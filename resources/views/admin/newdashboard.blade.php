@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Admin --}}
    @if($user->role == 1)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-50 dark:bg-blue-900 p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
            <h2 class="font-bold text-lg text-blue-700 dark:text-blue-300 mb-2">Total Donations</h2>
            <p class="text-3xl font-semibold text-blue-600 dark:text-blue-400">৳ {{ number_format($totalDonations,2) }}</p>
        </div>
        <div class="bg-green-50 dark:bg-green-900 p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
            <h2 class="font-bold text-lg text-green-700 dark:text-green-300 mb-2">Total Donors</h2>
            <p class="text-3xl font-semibold text-green-600 dark:text-green-400">{{ $totalDonors }}</p>
        </div>
        <div class="bg-purple-50 dark:bg-purple-900 p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
            <h2 class="font-bold text-lg text-purple-700 dark:text-purple-300 mb-2">Last Donation</h2>
            <p class="text-2xl font-medium text-purple-600 dark:text-purple-400">
                {{ $lastDonation ? \Carbon\Carbon::parse($lastDonation->payment_date)->format('d M, Y') : 'N/A' }}
            </p>
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
                            <td class="px-4 py-2">{{ $fy['year'] }}</td>
                            <td class="px-4 py-2">৳ {{ number_format($fy['total'],2) }}</td>
                            <td class="px-4 py-2">{{ $fy['count'] }}</td>
                            <td class="px-4 py-2">{{ $fy['last_date'] ? \Carbon\Carbon::parse($fy['last_date'])->format('d M, Y') : 'N/A' }}</td>
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
    @endif

</div>
@endsection
