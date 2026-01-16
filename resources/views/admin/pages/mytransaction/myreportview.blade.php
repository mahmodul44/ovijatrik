<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction_Report_{{ now()->format('dmY') }}</title>
    <style>
        @page { size: A4; margin: 15mm; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.5; background: #f0f2f5; margin: 0; padding: 20px; }
        
        .report-canvas { background: white; max-width: 900px; margin: 0 auto; padding: 40px; border-radius: 8px; box-shadow: 0 0 20px rgba(0,0,0,0.1); position: relative; }
        
        /* Company Header */
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #036056; padding-bottom: 20px; margin-bottom: 30px; }
        .company-info h1 { margin: 0; color: #036056; font-size: 28px; letter-spacing: -1px; }
        .company-info p { margin: 2px 0; font-size: 12px; color: #666; }
        
        .report-title { text-align: right; }
        .report-title h2 { margin: 0; color: #333; font-size: 20px; text-transform: uppercase; }
        .date-range { font-size: 12px; background: #f8f9fa; padding: 5px 10px; border-radius: 4px; display: inline-block; margin-top: 5px; }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #036056; color: white; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; padding: 12px; }
        td { padding: 12px; border-bottom: 1px solid #eee; font-size: 13px; }
        tr:nth-child(even) { background-color: #fafafa; }
        
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .amount { font-family: 'Courier New', Courier, monospace; font-weight: bold; font-size: 14px; }

        /* Summary Footer */
        .total-section { margin-top: 30px; border-top: 2px solid #333; padding-top: 10px; }
        .footer-actions { margin-top: 40px; display: flex; justify-content: center; gap: 15px; }
        
        .btn { padding: 10px 25px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: 0.3s; text-decoration: none; }
        .btn-print { background: #036056; color: white; }
        .btn-close { background: #e5e7eb; color: #374151; }

        @media print {
            body { background: white; padding: 0; }
            .report-canvas { box-shadow: none; width: 100%; padding: 0; }
            .footer-actions { display: none; }
        }
    </style>
</head>
<body>

<div class="report-canvas">
    <div class="header">
        <div class="company-info">
            <h1>OVIJATRIK</h1>
            <p>Islambagh, Dinajpur, Bangladesh</p>
            <p>Phone: +880 1717-017645 | Email: ovijatrik.dinajpur@gmail.com</p>
        </div>
        <div class="report-title">
            <h2>Payment Report</h2>
            <div class="date-range">
                <b>Period:</b> {{ $from ?? 'All Time' }} — {{ $to ?? 'Today' }}
            </div>
        </div>
    </div>

    @if($reportData->count() > 0)
    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">Date</th>
                <th width="18%">Receipt No</th>
                <th width="25%">Payment Info</th>
                <th width="17%">Received By</th>
                <th width="20%" class="text-right">Amount (BDT)</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($reportData as $key=>$row)
                @php $total += $row->transaction_amount; @endphp
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->transaction_date)->format('d M, Y') }}</td>
                    <td class="text-bold">{{ $row->mr_no }}</td>
                    <td>
                       <div class="text-bold">
                            @php
                                $months = json_decode($row->selected_months, true);
                            @endphp

                            @if(is_array($months))
                                @foreach($months as $month)
                                    {{ \Carbon\Carbon::parse($month)->format('M-Y') }}@if(!$loop->last), @endif
                                @endforeach
                            @else
                                N/A
                            @endif
                        </div>
                        <div style="font-size: 11px; color: #777;">
                            via {{ $row->pay_method_name }} ({{ $row->account_no ?? 'N/A' }})
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 11px; color: #777;">
                        {{ $row->name ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="text-right amount">{{ number_format($row->transaction_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-section">
                <td colspan="4" class="text-right text-bold">Total Contribution:</td>
                <td colspan="2" class="text-right text-bold amount" style="border-bottom: 4px double #036056;">
                    ৳ {{ number_format($total, 2) }}
                </td>
            </tr>
        </tfoot>
    </table>
    @else
        <div style="text-align:center; padding: 50px; color: #999;">
            <p>No transactions found for the selected date range.</p>
        </div>
    @endif

    <div class="footer-actions">
        <button onclick="window.print()" class="btn btn-print">Download / Print PDF</button>
        <button onclick="window.close()" class="btn btn-close">Close Preview</button>
    </div>
</div>

</body>
</html>