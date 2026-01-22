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

        .company-info h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }

        .company-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .report-title {
            text-align: right;
        }

        .report-title h2 {
            margin: 0;
            color: var(--accent-color);
        }

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
            padding: 10px 25px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-print { background-color: var(--accent-color); color: white; }
        .btn-close { background-color: #95a5a6; color: white; }
        
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
    <header class="report-header">
        <div class="company-info">
            <h1>OVIJATRIK</h1>
            <p>Islambagh, Dinajpur, Bangladesh</p>
            <p>Phone: +880 1717-017645 | Email: ovijatrik.dinajpur@gmail.com</p>
        </div>
        <div class="report-title">
            <h2>Transaction Report</h2>
            <p><strong>Method:</strong> {{ $accountName->account_name }} {{ $accountName->account_no }}</p>
            <p><strong>Period:</strong> {{ $from ?? 'All Time' }} — {{ $to ?? 'Today' }}</p>
        </div>
    </header>

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
            @php $totalReceipts = 0; 
               $totalExpenses = 0;
            @endphp
            @foreach($reportData as $row)
                @php 
                    if($row->transaction_type == 1) {
                        $totalReceipts += $row->transaction_amount;
                    } else {
                        $totalExpenses += $row->transaction_amount;
                    }
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row->transaction_date)->format('d/m/Y') }}</td>
                    <td>
                        @if($row->mr_no)
                            <span style="color: green; font-weight: bold;">[Receipt]</span>
                        @else
                            <span style="color: #e74c3c; font-weight: bold;">[Expense]</span>
                        @endif
                    </td>
                    <td>{{ $row->project_title ?? 'N/A' }}</td>
                    <td>
                        @if($row->reference_type == 'money_receipt')
                        <strong>MR:</strong> {{ $row->mr_no }} <br>
                        @elseif($row->reference_type == 'salary-expenses')
                        <strong>Salary:</strong> {{ $row->salary_no }} <br>
                        <small>month & Year: {{ $row->salary_month}} - {{ $row->salary_year }}</small>
                        @elseif($row->reference_type == 'acc_balance_transfers')
                            <strong>TRF:</strong> {{ $row->acc_transfer_no }} <br>
                            <small>Balance Adjustment</small>
                        @else
                            <strong>Exp:</strong> {{ $row->expense_no ?? 'General Expense' }} <br>
                            <small>{{ $row->expense_cat_name }}</small>
                        @endif
                    </td>
                    <td>{{ $row->creator_name }}</td>
                    <td class="amount-cell" style="color: {{ $row->mr_no ? '#27ae60' : '#c0392b' }}">
                        {{ $row->mr_no ? '' : '-' }}৳ {{ number_format($row->transaction_amount, 2) }}
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