<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Wise Statement</title>

    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            background: #f1f3f8;
            color: #222;
            padding: 40px 0;
        }

        .container {
            width: 95%;
            max-width: 1100px;
            margin: auto;
        }

        /* Header */
        .page-title {
            text-align: center;
            font-size: 35px;
            font-weight: 800;
            margin-bottom: 25px;
            background: linear-gradient(90deg, #4f6ef7, #6a4bf7);
            -webkit-background-clip: text;
            color: transparent;
        }

        /* Card Box */
        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(6px);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            border: 1px solid #e3e3e3;
        }

        .card h3 {
            margin-bottom: 15px;
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            row-gap: 10px;
            column-gap: 25px;
            font-size: 16px;
        }

        .summary-grid strong {
            color: #444;
        }

        /* Table */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        thead tr {
            background: linear-gradient(90deg, #4f6ef7, #6a4bf7);
            color: white;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }

        tbody tr:hover {
            background: #f2f5ff;
        }

        tfoot tr {
            background: #eef1ff;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .balance {
            font-weight: bold;
            color: #2b50f7;
        }

        /* Error Box */
        .error-box {
            background: #ffdfdf;
            padding: 12px 18px;
            color: #c10000;
            border-left: 5px solid #ff4d4d;
            border-radius: 6px;
            margin-bottom: 15px;
            font-weight: 600;
            text-align: center;
        }

        /* Responsive */
        @media(max-width: 768px){
            .summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

</head>
<body>

<div class="container">

    @if(session('error'))
        <div class="error-box">
            {{ session('error') }}
        </div>
    @endif

    <!-- Page Title -->
    @include('layouts.banner')
    <!-- Summary Card -->
    <div class="card">
        <h3>📄 Report Summary</h3>

        <div class="summary-grid">
            @if($projectInfo)
            <p><strong>Project:</strong> {{ $projectInfo->project_title }}</p>
            @endif

            @if($accountInfo)
            <p><strong>Account:</strong> {{ $accountInfo->account_name }} ({{ $accountInfo->account_no }})</p>
            @endif

            @if(!$projectInfo && !$accountInfo)
            <p style="color:red;">No selection matched.</p>
            @endif
        </div>
    </div>

    <!-- Ledger Table -->
    <div class="card table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Account</th>
                    <th class="text-right">Balance</th>
                </tr>
    </thead>
    <tbody>
    @php $totalamount = 0; $i = 0; @endphp

    @foreach($reportData as $row)
    @php
        $i++;
        $totalamount += $row->ledger_amount;
    @endphp

    <tr>
        <td>{{ $i }}</td>
        <td>
            {{ $row->project ? $row->project->project_title.' - ' : '' }}
            {{ $row->account ? $row->account->account_name : '' }}
        </td>
        <td class="text-right">{{ number_format($row->ledger_amount, 2) }}</td>
    </tr>
    @endforeach
</tbody>
<tfoot>
    <tr>
        <td></td>
        <td class="text-right">Total:</td>
        <td class="text-right">{{ number_format($totalamount,2) }}</td>
    </tr>
</tfoot>

</table>
</div>

</div>

</body>
</html>
