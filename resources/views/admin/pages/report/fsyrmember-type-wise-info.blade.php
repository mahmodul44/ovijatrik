<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Type Wise Report - {{ $fiscalYear }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; padding: 40px; background: #fff; }
        
        /* Header */
        .header { display: flex; justify-content: space-between; border-bottom: 4px double #036056; padding-bottom: 20px; margin-bottom: 30px; }
        .company-info h1 { margin: 5px 0; color: #036056; font-size: 22px; }
        .company-info p { margin: 2px 0; font-size: 13px; color: #555; }
        .report-title { text-align: right; }
        .report-title h2 { margin: 0; font-size: 20px; color: #006666; border-bottom: 2px solid #006666; display: inline-block; }
        
        .btn-print { margin-top: 15px; background: #036056; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }

        /* Table */
        table { width: 100%; border-collapse: collapse; font-size: 13px; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 10px 5px; text-align: center; }
        
        thead tr { background-color: #036056; color: white; }
        .type-column { text-align: left; padding-left: 15px; font-weight: bold; background: #f0fdfa; }
        .total-column { background-color: #ffd700 !important; font-weight: bold; color: #000; }

        @media print {
            .btn-print { display: none !important; }
            body { padding: 10px; }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="company-info">
            <img src="{{ asset($abouts->logo_dark) }}" alt="Logo" style="width: 150px;">
            <h1>Ovijatrik Social Welfare Organization</h1>
            <p><strong>Reg No:</strong> Dinaj/2581/2024</p>
            <p>Islambagh, Sadar, Dinajpur, Bangladesh</p>
            <p>Phone: +880 1717-017645 | Email: ovijatrik.dinajpur@gmail.com</p>
        </div>

        <div class="report-title">
            <h2>Member Type-Wise Summary</h2>
            <p>Fiscal Year: {{ $fiscalYear }}</p>
            <button class="btn-print" onclick="window.print()">🖨️ Print Summary</button>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 150px;">Member Type</th>
                <th class="total-column">Total Collected</th>
                @foreach($months as $month)
                    <th>{{ date('M/y', strtotime($month)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php 
                $colTotals = array_fill_keys($months, 0); 
                $grandTotal = 0;
            @endphp

            @foreach($reportData as $type)
                <tr>
                    <td class="type-column">{{ $type['type_name'] }}</td>
                    <td class="total-column">{{ number_format($type['total_type_paid']) }}</td>
                    
                    @foreach($months as $month)
                        @php 
                            $amt = $type['payments'][$month];
                            $colTotals[$month] += $amt;
                        @endphp
                        <td>{{ $amt > 0 ? number_format($amt) : '-' }}</td>
                    @endforeach
                </tr>
                @php $grandTotal += $type['total_type_paid']; @endphp
            @endforeach
        </tbody>
        <tfoot style="background: #333; color: white; font-weight: bold;">
            <tr>
                <td style="text-align: right; padding-right: 15px;font-size:11px">GRAND TOTAL</td>
                <td style="background: #ffd700; color: #000;">{{ number_format($grandTotal) }}</td>
                @foreach($months as $month)
                    <td>{{ number_format($colTotals[$month]) }}</td>
                @endforeach
            </tr>
        </tfoot>
    </table>

</body>
</html>