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
<div class="space-y-8 p-4 md:p-8 min-h-screen">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Admin Overview</h1>
            <p class="text-gray-500 dark:text-gray-400">Welcome back, <span class="font-semibold text-green-600">{{ $user->name }}</span>. Here is your activity summary.</p>
        </div>
        <div class="flex gap-3">
            <button class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-4 py-2 rounded-lg text-sm font-medium shadow-sm hover:bg-gray-50 transition">
              <a href="{{route('report.fiscalyearmember-wise')}}">  Export Report </a>
            </button>
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-md shadow-green-200 transition">
                <a href="{{ route('member.create') }}"> + Add Donation </a>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 dark:bg-green-900/30 rounded-xl text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">Personal Total</span>
            </div>
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Added Donations</h3>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">৳ {{ number_format($totalHandledDonations, 2) }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Last Donation Added</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                {{ $lastDonation ? \Carbon\Carbon::parse($lastDonation->payment_date)->format('d M, Y') : 'No Records' }}
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-4 text-orange-600">
                <div class="p-3 bg-orange-50 dark:bg-orange-900/30 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Active Status</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">Verified Admin</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">Donation Trend</h2>
                <select class="text-xs border-gray-200 dark:bg-gray-700 rounded-md">
                    <option>Last 6 Months</option>
                </select>
            </div>
            <div class="h-[300px]">
                <canvas id="donationChart"></canvas>
            </div>
        </div>

        <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-6">Top Member Donors</h2>
            <div class="space-y-4">
                @foreach($topDonors as $d)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-xl transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs">
                            {{ substr($d->member->name, 0, 2) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold dark:text-white">{{ $d->member->name }}</p>
                            <p class="text-xs text-gray-500">ID: {{ $d->member->member_id }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-green-600">৳{{ number_format($d->total, 0) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-sm rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Recent Transactions</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400 uppercase text-[10px] font-bold">
                    <tr>
                        <th class="px-6 py-4 text-left">Receipt No</th>
                        <th class="px-6 py-4 text-left">Donor Details</th>
                        <th class="px-6 py-4 text-left">Amount</th>
                        <th class="px-6 py-4 text-left">Method</th>
                        <th class="px-6 py-4 text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($latestDonations as $item)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-6 py-4 font-mono text-xs text-indigo-600">{{ $item->mr_no }}</td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900 dark:text-gray-200">
                                {{ $item->member_id ? $item->member->name : $item->donar_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                + ৳ {{ number_format($item->payment_amount, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $item->paymentmethod->pay_method_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->payment_date)->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

    {{-- Donor --}}
    @if($user->role == 3)
  <div class="space-y-8 p-4 md:p-8 bg-gray-50 dark:bg-gray-900 min-h-screen text-gray-800 dark:text-gray-200 font-sans">

<div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-700 transition-all duration-300">
    
    <div class="h-20 bg-gradient-to-r from-blue-800 via-indigo-700 to-emerald-700 opacity-90"></div>

    <div class="px-6 pb-8 -mt-12">
        <div class="flex flex-col lg:flex-row gap-8 items-start">
            
            <div class="w-full lg:w-[65%] flex flex-col group">
                <div class="relative overflow-hidden rounded-3xl shadow-2xl border-4 border-white dark:border-gray-700 transform transition-transform duration-500 hover:scale-[1.01]">
                    <img src="{{ $user->id_card_photo ? asset('storage/' . $user->id_card_photo) : asset('images/default-card-placeholder.png') }}" 
                         alt="Membership Card" 
                         class="w-full h-auto object-cover">
                    
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                    @if($user->id_card_photo)
                        <a href="{{ asset('storage/' . $user->id_card_photo) }}" 
                           download="Ovijatrik_Membership_Card.jpeg" 
                           class="flex items-center gap-2 bg-white text-gray-900 px-6 py-3 rounded-2xl font-bold shadow-xl hover:bg-blue-50 transition transform hover:scale-105">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Virtual Membership Card
                        </a>
                        @endif

                </div>
                </div>
                
                <div class="hidden lg:flex mt-4 items-center justify-between px-2">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest italic">Virtual Membership Card • Ovijatrik Social Walfare Organization</p>
                 
                </div>
            </div>

            <div class="w-full lg:w-[35%] space-y-6">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                       <img class="h-20 w-20 rounded-2xl border-4 border-white dark:border-gray-700 shadow-lg object-cover" 
                             src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=036056&color=fff' }}" 
                             alt="Profile">
                        <div class="absolute -bottom-2 -right-2 bg-green-500 border-2 border-white dark:border-gray-800 p-1 rounded-full">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                        </div>
                    </div>
                    <div>
                       <h2 class="inline-block px-4 py-1 rounded-full bg-white/20 dark:bg-black/20 backdrop-blur-md border border-white/30 text-2xl font-black tracking-tight text-gray-900 dark:text-white">{{ $user->name }}</h2>
                        {{-- <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-tighter italic">Premium Benefactor</span> --}}
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-[10px] font-bold text-gray-400 uppercase">  <svg class="w-4 h-4 mr-1.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>  Donor ID</span>
                        <span class="text-sm font-mono font-bold text-gray-700 dark:text-gray-200">{{ $user->member_id ?? 'DR-0042' }}</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-3">
                        <span class="flex items-center text-[10px] font-bold text-gray-400 uppercase"> <svg class="w-4 h-4 mr-1.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> Contact</span>
                        <span class="text-sm font-bold text-gray-700 dark:text-gray-200">{{ $user->phone_no ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-3">
                    <span class="flex items-center text-[10px] font-bold text-gray-400 uppercase">
                        <svg class="w-4 h-4 mr-1.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Status
                    </span>
                    
                    <span class="px-2 py-0.5 rounded-lg text-[11px] font-black uppercase tracking-tighter {{ $user->status == 1 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-gray-100 text-gray-500' }}">
                        {{ $user->status == 1 ? 'Active Member' : 'Inactive' }}
                    </span>
                </div>
                <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-3">
                        <span class="flex items-center text-[10px] font-bold text-gray-400 uppercase">Monthly Donate Amount</span>
                        <span class="text-sm font-bold text-gray-700 dark:text-gray-200">{{ $user->monthly_donate ?? '0.00' }} BDT</span>
                    </div>
                </div>
             
            </div>

        </div>
    </div>
</div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-6 rounded-3xl shadow-lg text-white group cursor-default">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-teal-100 font-medium uppercase tracking-wider text-[10px]">Paid This Fiscal Year</p>
                    <h2 class="text-3xl font-bold mt-1">৳ {{ number_format($totalThisYear,2) }}</h2>
                </div>
                <div class="p-2 bg-white/20 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="mt-4 text-[10px] bg-black/10 w-max px-2 py-1 rounded">
            Fiscal: 
            {{ now()->month >= 7 ? now()->year . '-' . (now()->year + 1) : (now()->year - 1) . '-' . now()->year }}
        </p>
        </div>

        <div class="bg-gradient-to-br from-indigo-500 to-blue-600 p-6 rounded-3xl shadow-lg text-white group cursor-default">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 font-medium uppercase tracking-wider text-[10px]">Lifetime Donation</p>
                    <h2 class="text-3xl font-bold mt-1">৳ {{ number_format($totalAllTime,2) }}</h2>
                </div>
                <div class="p-2 bg-white/20 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <p class="mt-4 text-[10px] bg-black/10 w-max px-2 py-1 rounded">Total Paid</p>
        </div>

        <div class="bg-gradient-to-br from-rose-500 to-orange-600 p-6 rounded-3xl shadow-lg text-white group cursor-default">
    <div class="flex justify-between items-start">
        <div>
            <p class="text-rose-100 font-medium uppercase tracking-wider text-[10px]">
                @php
                    $memberId = Auth::user()->member_id ?? '';
                    
                    if (str_starts_with($memberId, 'OTBM')) {
                        $memberType = 'Triple Brick';
                    } elseif (str_starts_with($memberId, 'ODBM')) {
                        $memberType = 'Double Brick';
                    } elseif (str_starts_with($memberId, 'OBM')) {
                        $memberType = 'Single Brick';
                    }elseif (str_starts_with($memberId, 'OPM')) {
                        $memberType = 'Single Pillar';
                    }elseif (str_starts_with($memberId, 'ODPM')) {
                        $memberType = 'Double Pillar';
                    } else {
                        $memberType = 'General';
                    }
                    @endphp
                        Member Type
                    </p>
                    <h4 class="text-2xl font-bold mt-1 uppercase">{{ $memberType }}</h4>
                    <p class="mt-4 text-[10px] bg-black/10 w-max px-2 py-1 rounded">{{ $frequency }}</p>
                </div>
                <div class="p-2 bg-white/20 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                </div>
            </div>
            
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center bg-gray-50/50 dark:bg-gray-700/20 gap-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Fiscal Year Records
            </h2>
            <a href="{{ route('mytransaction.index') }}" class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-tighter shadow-sm hover:shadow-md transition flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download Statement
            </a>
        </div>
        <div class="overflow-x-auto">
   <table class="min-w-full border-collapse border border-gray-200 dark:border-gray-700">
    <thead class="text-gray-400 text-[12px] uppercase tracking-widest bg-gray-50 dark:bg-gray-800/50">
        <tr>
            <th class="px-6 py-4 text-left border border-gray-200 dark:border-gray-700">Fiscal Year</th>
            <th class="px-6 py-4 text-left border border-gray-200 dark:border-gray-700">TXN Info</th>
            <th class="px-6 py-4 text-left border border-gray-200 dark:border-gray-700">Paid Months</th>
            <th class="px-6 py-4 text-left border border-gray-200 dark:border-gray-700">Unpaid Months</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
        @forelse($fiscalSummary as $fy)
        <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition group">
            <td class="px-6 py-4 font-bold text-gray-700 dark:text-gray-200 text-sm italic tracking-tighter border border-gray-200 dark:border-gray-700">
                {{ $fy['year'] }}
            </td>

            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-xs font-bold border border-gray-200 dark:border-gray-700">
                <span class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">
                    {{ $fy['count'] }} TXNs
                </span>
            </td>

            <td class="px-6 py-4 border border-gray-200 dark:border-gray-700">
                <div class="flex flex-wrap gap-1">
                    <span class="w-full text-[12px] text-blue-600 font-bold mb-1">Total: {{ $fy['paid_count'] }}</span>
                    @foreach($fy['paid_months'] as $monthName)
                        <span class="bg-green-50/50 text-green-700 dark:bg-green-900/50 dark:text-blue-300 text-[11px] font-black px-2 py-0.5 rounded-md border border-blue-100 dark:border-blue-800 uppercase tracking-tighter">
                            {{ $monthName }}
                        </span>
                    @endforeach
                </div>
            </td>

            <td class="px-6 py-4 border border-gray-200 dark:border-gray-700">
                <div class="flex flex-wrap gap-1">
                    <span class="w-full text-[14px] text-red-500 font-bold mb-1">Total: {{ $fy['unpaid_count'] }}</span>
                    @foreach($fy['unpaid_months'] as $monthName)
                        <span class="bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 text-[11px] font-bold px-2 py-0.5 rounded-md border border-red-100 dark:border-red-900/30 uppercase tracking-tighter opacity-70">
                            {{ $monthName }}
                        </span>
                    @endforeach
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="px-6 py-12 text-center text-gray-400 text-xs italic border border-gray-200 dark:border-gray-700">No donation records found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-xl font-bold mb-6 flex items-center text-gray-700 dark:text-white">
                <span class="w-2 h-6 bg-red-500 rounded-full mr-3"></span> Active Projects
            </h3>
            <div class="space-y-4">
                @foreach($activeProjects as $project)
                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700 group hover:border-blue-300 dark:hover:border-blue-800 transition">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-bold text-gray-800 dark:text-gray-100 leading-tight">{{ $project['project_title'] }}</h4>
                            <p class="text-[10px] text-gray-500 mt-1 uppercase">CODE: {{ $project['project_code'] }}</p>
                        </div>
                        <a href="project/{{ $project['project_id'] }}" target="_blank" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold rounded-lg transition shadow-md flex items-center">
                            Details
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                    @php $percentage = $project['target_amount'] > 0 ? round(($project['collection_amount'] / $project['target_amount']) * 100) : 0; @endphp
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-2">
                        <div class="bg-blue-600 h-2 rounded-full shadow-inner" style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] font-bold uppercase">
                        <span class="text-gray-400 font-medium italic italic">Target: ৳{{ number_format($project['target_amount']) }}</span>
                        <span class="text-blue-600 tracking-wider">{{ $percentage }}% Goal Reached</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-xl font-bold mb-6 flex items-center text-gray-700 dark:text-white">
                    <span class="w-2 h-6 bg-indigo-500 rounded-full mr-3"></span> Fast Donation Channels
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($paymentMethods as $method)
                    <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl border border-indigo-100 dark:border-indigo-800 relative overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tight">{{ $method['bank_name'] }}</p>
                            @if(!empty($method['account_name']))
                            <p class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tight">
                                A/C: {{ $method['account_name'] }}
                            </p>
                        @endif

                        @if(!empty($method['branch_name']))
                            <p class="text-[9px] font-black text-indigo-400 dark:text-indigo-200 tracking-tight">
                                Br: {{ $method['branch_name'] }}
                            </p>
                        @endif
                        <p class="text-lg font-mono font-bold text-gray-800 dark:text-white mt-1">{{ $method['account_no'] }}</p>
                            
                        </div>
                        <svg class="absolute right-[-10px] bottom-[-10px] w-20 h-20 text-indigo-100 dark:text-indigo-800 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-3xl shadow-xl text-white">
                <h4 class="font-bold text-lg">Need Support?</h4>
                <p class="text-xs text-gray-400 mt-1 mb-6">Our team is available to help you with your queries.</p>
                <div class="flex flex-wrap gap-2">
                    <a href="mailto:support@obhijatrik.org" class="flex items-center text-xs bg-gray-700 hover:bg-gray-600 px-4 py-2.5 rounded-xl transition font-bold border border-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Email Us
                    </a>
                    <a href="tel:+8801717017645" class="flex items-center text-xs bg-blue-600 hover:bg-blue-500 px-4 py-2.5 rounded-xl transition font-bold">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Hotline
                    </a>
                    <a href="https://facebook.com/ovijatrik.dinajpur" target="_blank" class="flex items-center justify-center gap-2 p-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl text-xs font-bold border border-blue-100 dark:border-blue-800/30 hover:bg-blue-100 transition">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Facebook
                    </a>
                    <a href="https://wa.me/01717017645" target="_blank" class="flex items-center justify-center gap-2 p-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl text-xs font-bold border border-emerald-100 dark:border-emerald-800/30 hover:bg-emerald-100 transition">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835c1.523.904 3.013 1.358 4.606 1.359 5.343 0 9.689-4.345 9.691-9.691.001-2.589-1.007-5.023-2.839-6.855-1.832-1.832-4.267-2.839-6.858-2.84-5.341 0-9.69 4.344-9.693 9.69-.001 1.745.469 3.447 1.359 4.966l-1.02 3.73 3.83-1.003z"/></svg>
                        WhatsApp
                    </a>
                    
                </div>
                 
            </div>
        </div>
    </div>

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
