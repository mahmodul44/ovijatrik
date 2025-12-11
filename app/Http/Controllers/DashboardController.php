<?php

namespace App\Http\Controllers;
use App\Models\MoneyReceipt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{

public function index()
{
    $user = auth()->user();
    $chartData = null;
    // Admin
    if($user->role == 1){
        $totalDonations = MoneyReceipt::where('status',1)->sum('payment_amount');
        $totalDonors    = \App\Models\User::where('role',3)->count();
        $lastDonation   = MoneyReceipt::where('status',1)->latest('payment_date')->first();
        $donationThisMonth = MoneyReceipt::whereMonth('payment_date', Carbon::now()->month)
                                     ->whereYear('payment_date', Carbon::now()->year)
                                     ->where('status',1)
                                     ->sum('payment_amount');
        $topDonors = MoneyReceipt::select('member_id', DB::raw('SUM(payment_amount) as total'))
                             ->with('member:id,name,member_id')
                             ->groupBy('member_id')
                             ->where('member_id','!=',null)
                             ->where('status',1)
                             ->orderByDesc('total')
                             ->take(5)
                             ->get();
        $latestDonations = MoneyReceipt::with('member:id,name','project:project_id,project_title','paymentmethod:pay_method_id,pay_method_name')
                                   ->orderBy('payment_date', 'desc')
                                   ->where('status',1)
                                   ->take(10)
                                   ->get();

         $chartData = $this->getDonationChartData();
        // dd($latestDonations);
        return view('admin.newdashboard', compact('user','totalDonations','totalDonors','lastDonation','donationThisMonth','topDonors','latestDonations','chartData'));
    }

    // Employee
    if($user->role == 2){
        $totalHandledDonations = MoneyReceipt::where('created_by',$user->id)->where('status',1)->sum('payment_amount');
        $lastDonation = MoneyReceipt::where('created_by',$user->id)->where('status',1)->latest('payment_date')->first();
        $donationThisMonth = MoneyReceipt::whereMonth('payment_date', Carbon::now()->month)
                                     ->whereYear('payment_date', Carbon::now()->year)
                                     ->where('status',1)
                                     ->sum('payment_amount');
        $topDonors = MoneyReceipt::select('member_id', DB::raw('SUM(payment_amount) as total'))
                             ->with('member:id,name,member_id')
                             ->groupBy('member_id')
                             ->where('member_id','!=',null)
                             ->where('status',1)
                             ->orderByDesc('total')
                             ->take(5)
                             ->get();
        $latestDonations = MoneyReceipt::with('member:id,name','project:project_id,project_title','paymentmethod:pay_method_id,pay_method_name')
                                   ->orderBy('payment_date', 'desc')
                                   ->where('status',1)
                                   ->take(10)
                                   ->get();

         $chartData = $this->getDonationChartData();
        return view('admin.newdashboard', compact('user','totalHandledDonations','lastDonation','donationThisMonth','topDonors','latestDonations','chartData'));
    }

    // Donor
    if($user->role == 3){
        $donorId = $user->id; 

        $fiscalYearStart = now()->month >= 7 ? now()->year.'-07-01' : (now()->year-1).'-07-01';
        $fiscalYearEnd   = now()->month >= 7 ? (now()->year+1).'-06-30' : now()->year.'-06-30';

        $donations = MoneyReceipt::where('member_id', $donorId)->where('status',1)->get();

        $totalThisYear = $donations->whereBetween('payment_date', [$fiscalYearStart, $fiscalYearEnd])->sum('payment_amount');
        $totalAllTime  = $donations->sum('payment_amount');
        $lastDonation  = $donations->sortByDesc('payment_date')->first();
        $lastDonateAmount = MoneyReceipt::where('member_id', $donorId)
                    ->where('status', 1)
                    ->orderByDesc('mr_id') 
                    ->limit(1)            
                    ->value('payment_amount');

        // Donation Frequency improved
        $monthsGiven = $donations->groupBy(function($d){ 
            return \Carbon\Carbon::parse($d->payment_date)->format('m-Y'); 
        })->count();

        $frequency = match(true){
            $monthsGiven >= 10 => 'Monthly',
            $monthsGiven >= 4  => 'Quarterly',
            $monthsGiven == 2 || $monthsGiven == 3 => 'Semi-Annually',
            $monthsGiven == 1 => 'Yearly',
            default => 'One-time',
        };

        // Fiscal Year summary
        $fiscalSummary = $donations->groupBy(function($d){
            $date = \Carbon\Carbon::parse($d->payment_date);
            return $date->month >= 7 ? $date->year.'-'.($date->year+1) : ($date->year-1).'-'.$date->year;
        })->map(function($group, $year){
            return [
                'year'      => $year,
                'total'     => $group->sum('payment_amount'),
                'count'     => $group->count(),
                'last_date' => $group->sortByDesc('payment_date')->first()->payment_date ?? null,
            ];
        })->values();
        $lastReceipt = MoneyReceipt::where('member_id', $donorId)
        ->where('status', 1)
        ->orderBy('mr_id', 'desc')
        ->value('selected_months');

        $receiptMonths = [];

        if ($lastReceipt) {
            $monthsArray = json_decode($lastReceipt, true);

            foreach ($monthsArray as $m) {
                // $m = "2025-07"
                $receiptMonths[] = \Carbon\Carbon::createFromFormat('Y-m', $m)->format('F Y');
            }
        }

         $chartData = [
            'months' => [],
            'amounts' => []
        ];
        
        return view('admin.newdashboard', compact('user','totalThisYear','totalAllTime','lastDonation','frequency','fiscalSummary','lastDonateAmount','chartData','receiptMonths'));
    }

    abort(403);
}

 private function getDonationChartData()
    {
        $months = [];
        $amounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');

            $amounts[] = MoneyReceipt::whereYear('payment_date', $month->year)
                                 ->whereMonth('payment_date', $month->month)
                                 ->sum('payment_amount');
        }

        return [
            'months' => $months,
            'amounts' => $amounts,
        ];
    }

}
