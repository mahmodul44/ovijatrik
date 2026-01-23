<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Report</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --border-color: #e0e0e0;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: var(--primary-color);
        }

        .report-container {
            max-width: 1100px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        /* Header Styling */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header { display: flex; justify-content: space-between; border-bottom: 4px double #036056; padding-bottom: 20px; margin-bottom: 30px; }
        .company-info h1 { margin: 5px 0; color: #036056; font-size: 22px; }
        .company-info p { margin: 2px 0; font-size: 13px; color: #555; }
        .report-title { text-align: right; }
        .report-title h2 { margin: 0; font-size: 20px; color: #006666; border-bottom: 2px solid #006666; display: inline-block; }
        
        .btn-print { margin-top: 15px; background: #036056; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }


        /* Table Styling */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .report-table th {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
            text-transform: uppercase;
        }

        .report-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
        }

        .report-table tr:nth-child(even) {
            background-color: var(--bg-light);
        }

        .amount-cell {
            font-weight: bold;
            text-align: right;
        }

        /* Summary Section */
        .summary-box {
            float: right;
            width: 250px;
            margin-bottom: 40px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .summary-row.total {
            border-bottom: 2px double var(--primary-color);
            font-weight: bold;
            font-size: 18px;
        }

        /* Footer / Actions */
        .report-footer {
            clear: both;
            display: flex;
            justify-content: center;
            gap: 15px;
            padding-top: 30px;
            border-top: 1px solid var(--border-color);
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-close { margin-top: 15px; background: #2e3a39; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        
        .btn:hover { opacity: 0.8; }

        /* Print Specific Styles */
        @media print {
            body { background: white; padding: 0; }
            .report-container { box-shadow: none; width: 100%;padding: 0; }
            .report-footer { display: none; } 
        }
    </style>
</head>
<body>

<div class="report-container">
  <div class="header">
        <div class="company-info">
            <img src="{{ asset($abouts->logo_dark) }}" alt="Logo" style="width: 150px;">
            <h1>Ovijatrik Social Welfare Organization</h1>
            <p><strong>Reg No:</strong> Dinaj/2581/2024</p>
            <p>Islambagh, Sadar, Dinajpur, Bangladesh</p>
            <p>Phone: +880 1717-017645 | Email: ovijatrik.dinajpur@gmail.com</p>
        </div>

        <div class="report-title">
            <h2>Payment Method Wise Summary</h2>
             <p><strong>Method:</strong> {{ $accountName->bank_name }} {{ $accountName->account_no }}</p>
            <p><strong>Period:</strong> {{ $from ?? 'All Time' }} — {{ $to ?? 'Today' }}</p>
        </div>
    </div>

   <main>
    <table class="report-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Project Name</th>
                <th>Details / Donor</th>
                <th>Added By</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
    @php 
        $totalReceipts = 0; 
        $totalExpenses = 0;
    @endphp
    @foreach($reportData as $row)
        @php 
            /* Logic:
               Positive (+): Type 1 (Receipt), Type 5 (Transfer In)
               Negative (-): Type 2 (Expense/Salary), Type -5 (Transfer Out)
            */
            $isPositive = in_array($row->transaction_type, [1, 5]);
            
            if($isPositive) {
                $totalReceipts += $row->transaction_amount;
            } else {
                $totalExpenses += $row->transaction_amount;
            }
        @endphp
        <tr>
            <td>{{ \Carbon\Carbon::parse($row->transaction_date)->format('d/m/Y') }}</td>
            <td>
                @if($row->transaction_type == 1)
                    <span style="color: green; font-weight: bold;">[Receipt]</span>
                @elseif($row->transaction_type == 5)
                    <span style="color: #3498db; font-weight: bold;">[Transfer In]</span>
                @elseif($row->transaction_type == -5)
                    <span style="color: #e67e22; font-weight: bold;">[Transfer Out]</span>
                @elseif($row->reference_type == 'salary-expenses')
                    <span style="color: #9b59b6; font-weight: bold;">[Salary]</span>
                @else
                    <span style="color: #e74c3c; font-weight: bold;">[Expense]</span>
                @endif
            </td>
            <td>{{ $row->project_title ?? 'N/A' }}</td>
            <td>
                @if($row->reference_type == 'money_receipt')
                    <strong>MR:</strong> {{ $row->mr_no }} <br>
                    <small>{{ $row->donar_name }}</small>
                @elseif($row->reference_type == 'member_receipt')
                    <strong>MR:</strong> {{ $row->mr_no }} <br>
                    <small>{{ $row->member_name  }}</small>
                @elseif($row->reference_type == 'salary-expenses')
                    <strong>Salary:</strong> 
                    {{ \Carbon\Carbon::createFromDate($row->salary_year, $row->salary_month, 1)->format('M - Y') }} 
                    <br> 
                    <small>Salary No: {{ $row->salary_no }}</small>
                @elseif(in_array($row->transaction_type, [5, -5]))
                    <strong>TRF:</strong> {{ $row->acc_transfer_no }} <br>
                    <small>@if($row->transaction_type == 5)
            {{-- Money came INTO this account --}}
            Received from: <strong>{{ $row->from_account_info }}</strong>
        @elseif($row->transaction_type == -5)
            {{-- Money went OUT of this account --}}
            Sent to: <strong>{{ $row->to_account_info }}</strong>
        @endif</small>
                @else
                    <strong>Exp:</strong> {{ $row->expense_no ?? 'General' }} <br>
                    <small>{{ $row->expense_cat_name }}</small>
                @endif
            </td>
            <td>{{ $row->creator_name }}</td>
            
            <td class="amount-cell" style="color: {{ $isPositive ? '#27ae60' : '#c0392b' }}">
                {{ $isPositive ? '' : '-' }}৳ {{ number_format($row->transaction_amount, 2) }}
            </td>
        </tr>
    @endforeach
</tbody>
    </table>

    <div class="summary-box">
        <div class="summary-row total">
            <span>Closing Balance:</span>
            <span>৳ {{ number_format($totalReceipts - $totalExpenses, 2) }}</span>
        </div>
    </div>
</main>

    <footer class="report-footer">
        <button class="btn btn-print" onclick="window.print()">Print Report</button>
        <button class="btn btn-close" onclick="window.close()">Close Window</button>
    </footer>
</div>

</body>
</html>