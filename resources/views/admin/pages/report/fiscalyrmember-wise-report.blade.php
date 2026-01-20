<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Membership Report - {{ $fiscalYear }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 40px;
            background-color: #fff;
            color: #333;
        }

        /* Smart Header Design */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 4px double #036056;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-info {
            flex: 1;
        }

        .company-info h1 {
            margin: 5px 0;
            color: #036056;
            font-size: 18px;
        }

        .company-info p {
            margin: 2px 0;
            font-size: 13px;
            color: #555;
            line-height: 1.4;
        }

        /* Right Aligned Title Section */
        .report-title {
            flex: 1;
            text-align: right; /* Aligns everything inside to the right */
        }

        .report-title h2 {
            margin: 0;
            font-size: 20px;
            color: #006666;
            border-bottom: 2px solid #006666;
            display: inline-block; /* Allows border to only fit text width */
            padding-bottom: 5px;
        }

        .report-title .fiscal-tag {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            display: block;
        }

        /* Smart Print Button */
        .btn-print {
            margin-top: 15px;
            background-color: #036056;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .btn-print:hover {
            background-color: #024a42;
            transform: translateY(-1px);
        }

        /* Table Design */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #444;
            padding: 8px 4px;
            text-align: center;
        }

        thead tr { background-color: #036056; color: white; }
        
        /* Row Status Colors */
        .full-paid { background-color: #e6fffa !important; }
        .partial-paid { background-color: #fffaf0 !important; }
        .unpaid { background-color: #fff5f5 !important; }
        
        .highlight-total { background-color: #ffd700 !important; font-weight: bold; color: #000; }

        @media print {
            .btn-print { display: none !important; }
            body { padding: 0; }
            .header { border-bottom: 4px double #000; }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="company-info">
            <div class="logo-container">
                <img src="{{ asset($abouts->logo_dark) }}" alt="OVIJATRIK Logo" style="width: 180px; height: auto;">
            </div>
            <h1>Ovijatrik Social Welfare Organization</h1>
            <p><strong>Reg No:</strong> Dinaj/2581/2024</p>
            <p>Islambagh, Sadar, Dinajpur, Bangladesh</p>
            <p>Phone: +880 1717-017645 | Email: ovijatrik.dinajpur@gmail.com</p>
        </div>

        <div class="report-title">
            <h2>Membership Payment Report</h2>
            <span class="fiscal-tag">Fiscal Year: {{ $fiscalYear }}</span>
            <br>
            <button class="btn-print" onclick="window.print()">🖨️ Print Official Report</button>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Member ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Individual Total</th>
                <th class="highlight-total">Total Paid</th>
                @foreach($months as $month)
                    <th>{{ date('M/y', strtotime($month)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php 
                $columnTotals = array_fill_keys($months, 0); 
                $grandTotalPaid = 0; 
                $grandFixedTotal = 0;
            @endphp

            @foreach($reportData as $data)
                @php
                    $paidMonthsCount = collect($data['payments'])->filter(fn($amt) => $amt > 0)->count();
                    $rowClass = ($paidMonthsCount == 12) ? 'full-paid' : (($paidMonthsCount > 0) ? 'partial-paid' : 'unpaid');
                @endphp
                <tr class="{{ $rowClass }}">
                    <td>{{ $data['id'] }}</td>
                    <td style="text-align: left; padding-left: 10px;">{{ $data['name'] }}</td>
                    <td>{{ $data['phone'] }}</td>
                    <td style="background: #f9f9f9;">{{ number_format($data['monthly_donate']) }}</td>
                    <td class="highlight-total">{{ number_format($data['individual_total']) }}</td>
                    @foreach($months as $month)
                        @php 
                            $amt = $data['payments'][$month];
                            $columnTotals[$month] += $amt;
                        @endphp
                        <td style="text-align: right">{{ $amt > 0 ? number_format($amt) : '-' }}</td>
                    @endforeach
                </tr>
                @php 
                    $grandTotalPaid += $data['individual_total']; 
                    $grandFixedTotal += $data['monthly_donate'];
                @endphp
            @endforeach
        </tbody>
        <tfoot style="background: #333; color: white;">
            <tr>
                <td colspan="3" style="text-align: right; padding-right: 15px;">TOTAL COLLECTION</td>
                <td>{{ number_format($grandFixedTotal) }}</td>
                <td style="background: #ffd700; color: #000;">{{ number_format($grandTotalPaid) }}</td>
                @foreach($months as $month)
                    <td style="text-align: right">{{ number_format($columnTotals[$month]) }}</td>
                @endforeach
            </tr>
        </tfoot>
    </table>

</body>
</html>