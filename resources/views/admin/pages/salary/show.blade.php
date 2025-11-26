@extends('backend.master')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<section class="content pt-2">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card card-primary">
  <div class="card-header">
    <div class="row">
        <div class="col-md-6 text-left">
            <h3 class="card-title">সালারি প্রিভিউ</h3>
        </div>
         <div class="col-md-6 text-right">
          <a class="btn btn-sm btn-info" href="{{route('salary.salaryIndex')}}">তালিকা দেখুন</a>
        </div>
    </div>
  </div>

  <!-- form start -->
<form role="form" id="salaryInsertForm" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <div class="card-body">
        <div class="form-group row">
            <div class="col-md-4">
                <label>সেলারী বছরঃ <?php echo en2bn($salary->salary_year); ?></label>
            </select>
            </div>
            <div class="col-md-4">
<?php  
$months = [
    1 => 'জানুয়ারি',
    2 => 'ফেব্রুয়ারি',
    3 => 'মার্চ',
    4 => 'এপ্রিল',
    5 => 'মে',
    6 => 'জুন',
    7 => 'জুলাই',
    8 => 'আগস্ট',
    9 => 'সেপ্টেম্বর',
    10 => 'অক্টোবর',
    11 => 'নভেম্বর',
    12 => 'ডিসেম্বর',
];

$data['months'] = $months;
?>
            <label>সেলারী মাসঃ {{ $months[$salary->salary_month] ?? 'N/A' }}</label>
              
            </div>
             <div class="col-md-4">
            <label>সেলারী তারিখঃ </label>
            <label>{{ en2bn(\Carbon\Carbon::parse($salary->salary_date)->format('d/m/Y')) }}</label>
        </div>
        </div>
        <table class="table table-bordered">
            <thead style="text-align:center;">
                <tr>
                    <th>#</th>
                    <th>DSR নাম</th>
                    <th>মোবাইল নাম্বার</th>
                    <th>সেলারী টাকা</th>
                </tr>
            </thead>
            <tbody>
            @php 
            $i = 0;
            $total = 0;
            @endphp
            @foreach($salary->salaryDetails as $key => $detail) 
            @if($detail->salary_amount > 0)
                @php 
                $i++;
                $total += $detail->salary_amount;
                @endphp
                <tr> 
                    <td style="text-align: center;">{{ en2bn($i) }}</td>
                    <td>{{ $detail->customer->customer_name }}</td> <!-- Access customer via salaryDetails -->
                    <td style="text-align:center;">{{ en2bn($detail->customer->mobile_no) }}</td>
                    <td style="text-align:right;">{{ en2bn($detail->salary_amount ?? 0) }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
            <tfoot style="text-align:right;">
                <tr>
                    <td colspan="3">সর্বমোট</td>
                    <td>{{en2bn(number_format($total,2))}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <a class="btn btn-success" href="{{route('salary.salaryIndex')}}">তালিকায় ফিরে যান</a>
    </div>
</form>

</div>
</div>
</div>
</div>
</section>

@endsection