<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Wise Statement</title>

    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; padding: 20px; }

        .statement-container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* Header */
        .header-area {
            text-align: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header-area img {
            max-width: 90px;
            margin-bottom: 10px;
        }
        .org-name { font-size: 26px; font-weight: bold; color: #333; }
        .org-sub { color: #555; font-size: 14px; }

        /* Project info */
        .project-info {
            margin-bottom: 20px;
            font-size: 14px;
            background: #f8f8f8;
            padding: 12px;
            border-radius: 6px;
        }
        .bold { font-weight: bold; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #e9ecef;
            font-size: 15px;
            text-align: center;
        }
        .text-green { color: green; font-weight: bold; }
        .text-red { color: crimson; font-weight: bold; }
        .balance { font-weight: bold; }

        .footer-btns {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
        }

        .btn {
            padding: 10px 18px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        @media print {
            .footer-btns { display: none; }
            body { background: white; padding: 0; }
            .statement-container { box-shadow: none; }
        }
    </style>
</head>

<body>

<div class="statement-container">

   @include('layouts.banner')

    <!-- Project Info -->
    @if($projectInfo)
    <div class="project-info">
        <div><span class="bold">Project:</span> {{ $projectInfo->project_code }} - {{ $projectInfo->project_title }}</div>
        <div><span class="bold">Duration:</span> {{ $projectInfo->project_start_date ?? '---' }} - {{ $projectInfo->project_end_date ?? '---' }}</div>
        <div><span class="bold">Target Amount:</span> {{ $projectInfo->target_amount ?? '---' }} <span class="bold">Collection:</span> {{ $projectInfo->collection_amount ?? '---' }} <span class="bold">Expense:</span>  {{ $projectInfo->total_expense ?? '---' }} </div>
    </div>
    @endif

    <!-- Date Range -->
    <div class="project-info">
        <span class="bold">From:</span> {{ $from ?? '---' }} |
        <span class="bold">To:</span> {{ $to ?? '---' }}
    </div>

    @php $balance = 0; @endphp

    <table>
        <thead>
            <tr>
                <th width="12%">Date</th>
                <th width="45%">Description</th>
                <th width="12%">Deposit</th>
                <th width="12%">Withdraw</th>
                <th width="12%">Balance</th>
            </tr>
        </thead>

        <tbody>
            @php 
            $balance = 0;
            $totalDeposit = 0;
            $totalWithdraw = 0;
        @endphp
        @foreach($reportData as $row)

            @php
            $deposit = $row->transaction_type == 1 ? $row->transaction_amount : 0;
            $withdraw = $row->transaction_type == -1 ? $row->transaction_amount : 0;
                $totalDeposit  += $deposit;
                $totalWithdraw += $withdraw;
                $balance += ($deposit - $withdraw);
            @endphp

            <tr>
                <td>{{ \Carbon\Carbon::parse($row->transaction_date)->format('d/m/Y') }}</td>

                <td>
                    @if(!$projectId)
                        <b>{{ $row->project_code }} - {{ $row->project_title }}</b><br>
                    @endif
                     @if($row->transaction_type == '1')
                        Receipt No: {{ $row->mr_no }}
                        Name: {{ $row->member_name }}
                        Account: {{ $row->account_no }}
                    @else
                     @if(!empty($row->expense_cat_name))
                        <b>{{ $row->expense_cat_name }}</b><br>
                    @endif
                        Voucher No: {{ $row->expense_no }}
                        Account: {{ $row->account_no }}
                    @endif  

                </td>

                <td class="text-green">
                    {{ $deposit > 0 ? number_format($deposit,2) : '' }}
                </td>

                <td class="text-red">
                    {{ $withdraw > 0 ? number_format($withdraw,2) : '' }}
                </td>

                <td class="balance">{{ number_format($balance,2) }}</td>
            </tr>

        @endforeach

        </tbody>
        <tfoot>
    <tr style="background:#f1f1f1; font-weight:bold;">
        <td colspan="2" style="text-align:right;">Total Summary:</td>

        <td style="color:green;">
            {{ number_format($totalDeposit, 2) }}
        </td>

        <td style="color:crimson;">
            {{ number_format($totalWithdraw, 2) }}
        </td>

        <td>
            {{ number_format($balance, 2) }}
        </td>
    </tr>
</tfoot>

    </table>

    <div class="footer-btns">
        <button class="btn" onclick="window.print()">Print</button>
        <button class="btn" onclick="window.close()">Close</button>
    </div>

</div>

</body>
</html>
