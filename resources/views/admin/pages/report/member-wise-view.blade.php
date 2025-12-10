<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Wise Statement</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; padding: 20px; }
        .statement-container {
            max-width: 1000px; margin: auto; background: #fff; padding: 25px 30px;
            border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 { text-align:center; font-size: 26px; margin-bottom:5px; color:#333; }
        .subtitle { text-align:center; font-size:14px; color:#555; margin-bottom:20px; }

        .table-info { margin-bottom:20px; font-size:14px; background:#f8f8f8; padding:12px; border-radius:6px; }
        table { width:100%; border-collapse:collapse; font-size:14px; }
        th, td { border:1px solid #ddd; padding:10px 12px; text-align:left; }
        th { background:#e9ecef; text-align:center; }
        .text-green { color:green; font-weight:bold; }
        .balance { font-weight:bold; }
        .footer-btns { margin-top:20px; display:flex; justify-content:space-between; }
        .btn { padding:10px 18px; background:#007bff; color:white; border:none; border-radius:6px; cursor:pointer; font-weight:bold; }
        .btn:hover { opacity:0.9; }
        @media print { .footer-btns { display:none; } body { background:white; padding:0; } .statement-container { box-shadow:none; } }
        tbody tr:hover { background:#fef3c7; }
    </style>
</head>
<body>

<div class="statement-container">
     @include('layouts.banner')
    <h2>📑 Member Wise Report</h2>

    @if($memberName)
        <p class="subtitle"><b>Member:</b> {{ $memberName->member_id }} - {{ $memberName->name }}</p>
    @endif

    @if($from || $to)
        <p class="subtitle"><b>From:</b> {{ $from ?? '---' }} → <b>To:</b> {{ $to ?? '---' }}</p>
    @endif

    @php 
        $balance = 0; 
        $totalDeposit = 0; 
    @endphp

    @if(count($reportData) > 0)
        <table>
            <thead>
                <tr>
                    <th width="20%">Date</th>
                    <th width="50%">Description</th>
                    <th width="30%">Donation Amount</th>
                </tr>
            </thead>
            <tbody>
            @foreach($reportData as $row)
                @php
                    $deposit = $row->transaction_type == 1 ? $row->transaction_amount : 0;
                    $totalDeposit += $deposit;
                @endphp
                <tr>
                    <td style="text-align: center">{{ \Carbon\Carbon::parse($row->transaction_date)->format('d/m/Y') }}</td>
                    <td>
                        @if(!$memberId)
                           <strong>Donar:</strong> <b>{{ $row->member_name ?? '' }} {{ $row->donar_name ?? '' }}</b><br>
                            <strong>Receipt No:</strong><b>{{ $row->mr_no}}</b><br>
                           @endif
                        @if($row->project_title)
                            <strong>Project:</strong> {{ $row->project_title }}<br>
                        @endif
                        @if($row->account_name)
                            <strong>Account:</strong> <span style="color: #007bff">{{ $row->account_name }} {{ $row->account_no ?? '' }} </span>
                        @endif
                    </td>
                    <td class="text-green" style="text-align: right">{{ $deposit > 0 ? number_format($deposit,2) : '' }}</td>
                 
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr style="background:#f1f1f1; font-weight:bold;">
                    <td colspan="2" style="text-align:right;">Total:</td>
                    <td class="text-green" style="text-align: right">{{ number_format($totalDeposit,2) }}</td>
                </tr>
            </tfoot>
        </table>
    @else
        <div style="text-align:center; font-size:16px; color:#888; margin:30px 0;">🚫 No Data Found</div>
    @endif

    <div class="footer-btns">
        <button class="btn" onclick="window.print()">🖨 Print</button>
        <button class="btn" onclick="window.close()">❌ Close</button>
    </div>

</div>

</body>
</html>
