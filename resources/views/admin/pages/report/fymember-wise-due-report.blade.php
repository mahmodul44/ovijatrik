<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Membership Report - {{ $fiscalYear }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }

        #report-container {
            padding: 40px; 
            background-color: #fff;
            box-sizing: border-box;
            width: 100%;
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

        /* Action Buttons Wrapper */
        .action-buttons {
            margin-top: 15px;
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .btn-action {
            background-color: #036056;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-action:hover {
            background-color: #024a42;
            transform: translateY(-1px);
        }

        .btn-whatsapp {
            background-color: #25D366;
        }
        .btn-whatsapp:hover {
            background-color: #1eb956;
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
            .action-buttons { display: none !important; }
            body { padding: 0; }
            .header { border-bottom: 4px double #000; }
        }
    </style>
</head>
<body>
<div id="report-container">
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
            <h2>Membership Due Report</h2>
            <span class="fiscal-tag">Fiscal Year: {{ $fiscalYear }}</span>
            <span style="font-size: 11px; color: #036056; font-weight: bold; display: block; margin-top: 3px;">
                (Up to {{ date('d M, Y') }})
            </span>
            <br>
            
            <!-- Action Buttons Container -->
            <div class="action-buttons">
                <button class="btn-action" onclick="window.print()">🖨️ Print</button>
                <button class="btn-action" onclick="downloadImage()">📥 Download Image</button>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Member ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Monthly Rate</th>
                <th class="highlight-total">Total Paid</th>
                <th style="background-color: #d9534f; color: white;">Total Due</th>
                @foreach($months as $month)
                    <th> {{ date('M/y', strtotime($month)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php 
                $columnTotals = array_fill_keys($months, 0); 
                $grandTotalPaid = 0; 
                $grandTotalDue = 0;
                $grandFixedTotal = 0;
            @endphp

            @foreach($reportData as $data)
                @php
                    $isFullyPaid = $data['total_due'] <= 0;
                    $rowClass = $isFullyPaid ? 'full-paid' : ($data['individual_total'] > 0 ? 'partial-paid' : 'unpaid');
                @endphp
                <tr class="{{ $rowClass }}">
                    <td>{{ $data['id'] }}</td>
                    <td style="text-align: left; padding-left: 10px;">{{ $data['name'] }}</td>
                    <td>{{ $data['phone'] }}</td>
                    <td style="background: #f9f9f9;">{{ number_format($data['monthly_donate']) }}</td>
                    <td class="highlight-total">{{ number_format($data['individual_total']) }}</td>
                    <td style="background-color: #fff0f0; color: #d9534f; font-weight: bold;">
                        {{ number_format($data['total_due']) }}
                    </td>
                    
                    @foreach($months as $month)
                        @php 
                            $amt = $data['payments'][$month];
                            $columnTotals[$month] += $amt;
                            $monthlyDonate = $data['monthly_donate'];
                        @endphp
                        <td style="text-align: right;">
                            @if($amt >= $monthlyDonate && $monthlyDonate > 0)
                                <span style="color: #2e7d32; font-weight: bold;">{{ number_format($amt) }}</span>
                            @elseif($amt > 0)
                                <span style="color: #ed6c02; font-weight: bold;">{{ number_format($amt) }}</span>
                            @else
                                <span style="color: #d9534f; font-weight: bold;">Due</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
                @php 
                    $grandTotalPaid += $data['individual_total']; 
                    $grandTotalDue  += $data['total_due'];
                    $grandFixedTotal += $data['monthly_donate'];
                @endphp
            @endforeach
        </tbody>
        <tfoot style="background: #333; color: white;">
            <tr>
                <td colspan="3" style="text-align: right; padding-right: 15px;">TOTAL COLLECTION</td>
                <td>{{ number_format($grandFixedTotal) }}</td>
                <td style="background: #ffd700; color: #000;">{{ number_format($grandTotalPaid) }}</td>
                <td style="background: #d9534f; color: #fff; font-weight: bold;">{{ number_format($grandTotalDue) }}</td>
                @foreach($months as $month)
                    <td style="text-align: right">{{ number_format($columnTotals[$month]) }}</td>
                @endforeach
            </tr>
        </tfoot>
    </table>
</div>
    <!-- html2canvas Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
        function generateCanvas() {
            const container = document.getElementById('report-container');
            const buttons = document.querySelector('.action-buttons');
            
            buttons.style.visibility = 'hidden';

            return html2canvas(container, {
                scale: 2, 
                useCORS: true,
                width: container.scrollWidth,
                height: container.scrollHeight,
                windowWidth: container.scrollWidth 
            }).then(canvas => {
                buttons.style.visibility = 'visible';
                return canvas;
            });
        }

        function downloadImage() {
            generateCanvas().then(canvas => {
                const link = document.createElement('a');
                link.download = 'Membership_Report_{{ $fiscalYear }}.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }

    </script>
</body>
</html>