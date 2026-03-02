<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Expense Head Wise Statement - {{ $category->project_exp_cat_name }}</title>
    <style>
        /* Tomar dewa style gulo eikhane thakbe */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background-color: #f4f4f4; color: #333; }
        .container { max-width: 1100px; margin: 0 auto; background: white; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius: 8px; }
        .header { display: flex; justify-content: space-between; border-bottom: 4px double #036056; padding-bottom: 20px; margin-bottom: 30px; }
        .company-info h1 { margin: 5px 0; color: #036056; font-size: 22px; }
        .company-info p { margin: 2px 0; font-size: 13px; color: #555; }
        .report-title { text-align: right; }
        .report-title h2 { margin: 0; font-size: 20px; color: #006666; border-bottom: 2px solid #006666; display: inline-block; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; border: 1px solid #cbd5e0; }
        th { background-color: #2d3748; color: white; padding: 10px; text-align: left; text-transform: uppercase; border: 1px solid #cbd5e0; }
        td { padding: 12px; border: 1px solid #cbd5e0; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .deposit { color: #2f855a; }
        .withdraw { color: #c53030; }
        .footer-row { background-color: #f7fafc; font-weight: bold; }
        .balance-total { background-color: #2d3748; color: white; }

        .btn-group { margin-top: 30px; display: flex; gap: 10px; }
        .btn { padding: 12px 25px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; flex: 1; text-align: center; text-decoration: none; }
        .btn-print { background: #3182ce; color: white; }
        .btn-close { background: #e2e8f0; color: #4a5568; }

        @media print {
            .btn-group { display: none; }
            body { padding: 0 !important;
        margin: 0 !important;}
            .container { padding: 0 !important;
        margin: 0 !important; box-shadow: none; border: none; width: 100%; max-width: 100%; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div class="company-info">
            <img src="{{ asset($abouts->logo_dark ?? 'logo.png') }}" alt="Logo" style="width: 150px;">
            <h1>Ovijatrik Social Welfare Organization</h1>
            <p><strong>Reg No:</strong> Dinaj/2581/2024</p>
            <p>Islambagh, Sadar, Dinajpur, Bangladesh</p>
            <p>Phone: +880 1717-017645 | Email: ovijatrik.dinajpur@gmail.com</p>
        </div>

        <div class="report-title">
            <h2>Project Expense Head Wise Statement</h2>
            <p><strong>Head:</strong> {{ $category->project_exp_cat_name }}</p>
            <p><strong>Fiscal Year:</strong> {{ $fiscal_year ?? 'All Time' }}</p>
        </div>
    </div>

    <table>
    <thead>
        <tr>
            <th width="60%">Project Name</th>
            <th width="40%" class="text-right">Total Expense (TK)</th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotal = 0; @endphp

        @foreach($reportData as $data)
            @php
                $grandTotal += $data->total_expense;
            @endphp
            <tr>
                <td class="font-bold">{{ $data->project_title }}</td>
                <td class="text-right withdraw">
                    {{ number_format($data->total_expense, 2) }}
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="footer-row">
            <td class="text-right">Grand Total:</td>
            <td class="text-right balance-total">
                {{ number_format($grandTotal, 2) }}
            </td>
        </tr>
    </tfoot>
</table>

    <div class="btn-group">
        <button onclick="window.print()" class="btn btn-print">Print Report</button>
        <a href="#" onclick="window.close()" class="btn btn-close">Close</a>
    </div>
</div>

</body>
</html>