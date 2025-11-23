<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense Voucher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .voucher-container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        /* Header */
        .voucher-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
            padding: 20px;
        }

        .voucher-header img {
            height: 60px;
            width: auto;
            margin-right: 15px;
        }

        .voucher-header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .voucher-header p {
            margin: 2px 0;
            font-size: 12px;
            color: #666;
        }

        .voucher-title {
            text-align: right;
        }

        .voucher-title h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            color: #444;
        }

        .voucher-title p {
            font-size: 12px;
            color: #777;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px;
            font-size: 14px;
        }

        table td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        table tr:nth-child(even) {
            background: #f9f9f9;
        }

        table td:first-child {
            font-weight: bold;
            width: 30%;
            background: #f5f5f5;
        }

        .amount {
            color: green;
            font-weight: bold;
            font-size: 16px;
        }

        /* Signatures */
        .signatures {
            display: flex;
            justify-content: space-between;
            padding: 30px 20px;
            font-size: 13px;
            color: #555;
        }

        .signatures div {
            text-align: center;
            width: 30%;
        }

        .signatures p {
            border-top: 1px solid #888;
            padding-top: 5px;
            margin-top: 40px;
        }

        /* Buttons */
        .buttons {
            text-align: center;
            margin-top: 20px;
        }

        .buttons button {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 10px 18px;
            margin: 0 8px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease;
        }

        .buttons button:hover {
            background: #1e40af;
        }

        .buttons .close {
            background: #6b7280;
        }

        .buttons .close:hover {
            background: #374151;
        }

        /* Print */
        @media print {
            body {
                background: #fff;
            }
            .buttons {
                display: none;
            }
            .voucher-container {
                box-shadow: none;
                border: 1px solid #000;
            }
        }
    </style>
</head>
<body>

    <div class="voucher-container">
        <!-- Header -->
        <div class="voucher-header">
            <div style="display: flex; align-items: center;">
                <img src="{{ asset('logo_bgtransparent-sm.png') }}" alt="Company Logo">
                <div>
                    <h1>Ovijatrik</h1>
                    <p>Charity Organization</p>
                    <p>Islambagh, Dinajpur, Bangladesh</p>
                    <p>01717 017645 | ovijatrik.org</p>
                </div>
            </div>
            <div class="voucher-title">
                <h2>Expense Voucher</h2>
                <p>Generated on: {{ now()->format('d M, Y') }}</p>
            </div>
        </div>

        <!-- Body -->
        <table>
            <tr>
                <td>Voucher No</td>
                <td>{{ $expense->expense_no }}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td>Amount</td>
                <td class="amount">{{ number_format($expense->expense_amount, 2) }} ৳</td>
            </tr>
            <tr>
                <td>Expense Head</td>
                <td>{{ $expense->project_id ? $expense->project->project_title : $expense->expcategory->expense_cat_name }}</td>
            </tr>
            <tr>
                <td>Remarks</td>
                <td>{{ $expense->expense_remarks ?? 'N/A' }}</td>
            </tr>
        </table>

        <!-- Signatures -->
        <div class="signatures">
            <div><p>Prepared By</p></div>
            <div><p>Approved By</p></div>
            <div><p>Received By</p></div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="buttons">
        <button onclick="window.print()">Print</button>
        <button onclick="window.close()" class="close">Close</button>
    </div>

</body>
</html>
