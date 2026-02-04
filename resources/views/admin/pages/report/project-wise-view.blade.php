<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Statement - {{ $projectInfo->project_title }}</title>
    <style>
        /* General Styles */
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
        

        .logo {
            width: 150px;
            margin-bottom: 15px;
        }

        .org-name {
            font-size: 28px;
            font-weight: 800;
            margin: 0;
            color: #1a202c;
            text-transform: uppercase;
        }

        .org-info {
            font-size: 14px;
            color: #718096;
            margin-top: 5px;
        }

        .reg-badge {
            background: #2d3748;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        /* Summary Box */
        .report-summary-box {
            display: inline-block;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
            min-width: 400px;
            text-align: left;
        }

        .report-summary-box h2 {
            font-size: 18px;
            margin: 0 0 10px 0;
            border-bottom: 1px solid #cbd5e0;
            padding-bottom: 8px;
            color: #2d3748;
            text-align: center;
        }

        .summary-grid {
            display: flex;
            justify-content: space-between;
        }

        .summary-item label {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            color: #a0aec0;
            font-weight: bold;
        }

        .summary-item span {
            font-size: 14px;
            font-weight: bold;
            color: #2b6cb0;
        }

        /* Project Info Cards */
        .info-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #edf2f7;
        }

        .project-card {
            background-color: #ebf8ff;
            border-left: 5px solid #3182ce;
        }

        .account-card {
            background-color: #f0fff4;
            border-left: 5px solid #38a169;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
            border: 1px solid #cbd5e0;
        }

        th {
            background-color: #2d3748;
            color: white;
            padding: 12px;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #cbd5e0;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #edf2f7;
            border: 1px solid #cbd5e0;
            vertical-align: top;
        }

        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .deposit { color: #2f855a; font-weight: bold; }
        .withdraw { color: #c53030; font-weight: bold; }
        
        .opening-balance {
            background-color: #fffaf0;
            font-style: italic;
        }

        .footer-row {
            background-color: #f7fafc;
            font-weight: bold;
            font-size: 16px;
        }

        .balance-total {
            background-color: #2d3748;
            color: white;
        }

        /* Buttons */
        .btn-group {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            flex: 1;
        }

        .btn-print { background: #3182ce; color: white; }
        .btn-close { background: #e2e8f0; color: #4a5568; }

        /* Print Specific */
        @media print {
            body { background: white; padding: 0; }
            .btn-group { display: none; }
            th { background-color: #333 !important; color: white !important; -webkit-print-color-adjust: exact; }
            .footer-row { background-color: #eee !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div class="company-info">
            <img src="{{ asset($abouts->logo_dark) }}" alt="Logo" style="width: 150px;">
            <h1>Ovijatrik Social Welfare Organization</h1>
            <p><strong>Reg No:</strong> Dinaj/2581/2024</p>
            <p>Islambagh, Sadar, Dinajpur, Bangladesh</p>
            <p>Phone: +880 1717-017645 | Email: ovijatrik.dinajpur@gmail.com</p>
        </div>

        <div class="report-title">
            <h2>Project Wise Summary</h2>
            <p><strong>Period:</strong> {{ $from ?? 'All Time' }} — {{ $to ?? 'Today' }}</p>
        </div>
    </div>

    <div class="info-cards">
        <div class="card project-card">
            <label style="font-size: 10px; font-weight: bold; color: #2b6cb0; text-transform: uppercase;">Selected Project</label>
            <div style="font-size: 18px; font-weight: bold; margin-top: 5px;">
                {{ $projectInfo->project_code }} - {{ $projectInfo->project_title }}
            </div>
            <div style="margin-top: 10px; font-size: 12px;">
                Target: <b>{{ number_format($projectInfo->target_amount, 2) }}</b> | 
                Collected: <b>{{ number_format($projectInfo->collection_amount, 2) }}</b>
            </div>
        </div>
        <div class="card account-card">
            <label style="font-size: 10px; font-weight: bold; color: #276749; text-transform: uppercase;">Filter Status</label>
            <div style="font-size: 16px; font-weight: bold; margin-top: 5px;">
                {{ $accountInfo ? $accountInfo->bank_name : 'All Accounts' }}
                {{ $accountInfo ? $accountInfo->account_no : '' }}
            </div>
            <p style="font-size: 12px; margin-top: 5px; color: #4a5568;">Generated: {{ date('d M, Y h:i A') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">Date</th>
                <th width="40%">Description</th>
                <th width="15%" class="text-right">Deposit</th>
                <th width="15%" class="text-right">Withdraw</th>
                <th width="15%" class="text-right">Balance</th>
            </tr>
        </thead>
        <tbody>
            <tr class="opening-balance">
                <td>{{ $from ? \Carbon\Carbon::parse($from)->subDay()->format('d/m/Y') : '-' }}</td>
                <td>Opening Balance (Brought Forward)</td>
                <td class="text-right">---</td>
                <td class="text-right">---</td>
                <td class="text-right font-bold">{{ number_format($previousBalance, 2) }}</td>
            </tr>

            @php 
                $balance = $previousBalance; 
                $totalDep = 0; $totalWith = 0;
            @endphp

            @foreach($reportData as $row)
                @php
                    $deposit = $row->transaction_type == 1 ? $row->transaction_amount : 0;
                    $withdraw = $row->transaction_type == -1 ? $row->transaction_amount : 0;
                    $totalDep += $deposit;
                    $totalWith += $withdraw;
                    $balance += ($deposit - $withdraw);
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row->transaction_date)->format('d/m/Y') }}</td>
                    <td>
                        @if($row->transaction_type == 1)
                            <small style="color: #3182ce; font-weight: bold;">RECEIPT: {{ $row->mr_no }}</small><br>
                            <strong>{{ $row->receipt_donor_name }}</strong>
                        @else
                            <small style="color: #e53e3e; font-weight: bold;">VOUCHER: {{ $row->expense_no }}</small><br>
                            <strong>{{ $row->expense_cat_name }}</strong>
                        @endif
                        <br><small style="color: #a0aec0;">{{ $row->bank_name }} ({{ $row->account_no }})</small>
                    </td>
                    <td class="text-right deposit">{{ $deposit > 0 ? number_format($deposit, 2) : '' }}</td>
                    <td class="text-right withdraw">{{ $withdraw > 0 ? number_format($withdraw, 2) : '' }}</td>
                    <td class="text-right font-bold">{{ number_format($balance, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="footer-row">
                <td colspan="2" class="text-right">Total Summary:</td>
                <td class="text-right" style="color: #2f855a;">{{ number_format($totalDep, 2) }}</td>
                <td class="text-right" style="color: #c53030;">{{ number_format($totalWith, 2) }}</td>
                <td class="text-right balance-total">{{ number_format($balance, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="btn-group">
        <button onclick="window.print()" class="btn btn-print">Print Statement</button>
        <button onclick="window.close()" class="btn btn-close">Close</button>
    </div>
</div>

</body>
</html>