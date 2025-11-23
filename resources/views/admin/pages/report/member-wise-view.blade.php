<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Wise Report</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h2 { margin: 0; font-size: 22px; font-weight: bold; color: #444; }
        .subtitle { margin: 10px 0 20px; font-size: 14px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px 12px; text-align: center; }
        th { background: #eaeaea; font-weight: bold; }
        .text-green { color: green; font-weight: 600; }
        .text-red { color: crimson; font-weight: 600; }
        .balance { font-weight: bold; }
        .footer { display: flex; justify-content: space-between; }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-print { background: #28a745; color: white; }
        .btn-print:hover { background: #218838; }
        .btn-close { background: #6c757d; color: white; }
        .btn-close:hover { background: #5a6268; }
        .no-data { text-align: center; font-size: 16px; color: #888; margin: 30px 0; }
@media print {
.footer {
        display: none;
    }
}
    </style>
</head>
<body>
    <div class="container">
        <h2>📑 Member Wise Report</h2>

        @if($memberName)
            <p class="subtitle"><b>Member:</b> {{ $memberName }}</p>
        @endif

        @if($from || $to)
            <p class="subtitle"><b>From:</b> {{ $from ?? '---' }} → <b>To:</b> {{ $to ?? '---' }}</p>
        @endif

        @if(count($reportData) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Project</th> 
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
            @php 
                $balance = 0; 
                $totalReceipt = 0;
                $totalExpense = 0;
            @endphp
            @foreach($reportData as $row)
                @php 
                    $balance += ($row->total_receipt - $row->total_expense); 
                    $totalReceipt += $row->total_receipt;
                    $totalExpense += $row->total_expense;
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row->transaction_date)->format('d/m/Y') }}</td>
                    <td style="text-align: left">{{ $row->project_title }}</td>
                    <td style="text-align: right" class="text-green">{{ number_format($row->total_receipt,2) }}</td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align:right">Total:</th>
                        <th class="text-green" style="text-align:right">{{ number_format($totalReceipt,2) }}</th>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="no-data">🚫 No Data Found</div>
        @endif

        <div class="footer">
            <button onclick="window.print()" class="btn btn-print">🖨 Print</button>
            <button onclick="window.close()" class="btn btn-close">❌ Close</button>
        </div>
    </div>
</body>
</html>
