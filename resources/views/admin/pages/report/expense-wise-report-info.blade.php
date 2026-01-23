<style>

    .report-body {
        font-family: 'Inter', sans-serif;
        background-color: #f1f5f9;
        padding: 30px 10px;
    }

    .report-card {
        max-width: 1000px;
        margin: 0 auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    /* Compact Horizontal Header */
    .header-compact {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 25px 40px;
        background: #1e293b;
        color: white;
        border-bottom: 4px solid #3b82f6;
    }

    .brand-side {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .brand-logo img {
        width: 120px;
        height: auto;
        filter: brightness(0) invert(1);
    }

    .brand-text h1 {
        font-size: 20px;
        font-weight: 800;
        margin: 0;
        line-height: 1.2;
    }

    .brand-text p {
        font-size: 12px;
        margin: 2px 0;
        opacity: 0.8;
    }

    .info-side {
        text-align: right;
    }

    .report-title-badge {
        background: #3b82f6;
        padding: 5px 15px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 14px;
        display: inline-block;
        margin-bottom: 8px;
    }

    .fiscal-info {
        font-size: 13px;
        font-family: 'JetBrains Mono', monospace;
    }

    /* Compressed Table Style */
    .table-section {
        padding: 20px;
    }

    .compact-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .compact-table thead th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        padding: 12px 15px;
        text-align: left;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .compact-table tbody td {
        padding: 10px 15px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
    }

    .compact-table tbody tr:nth-child(even) {
        background-color: #fbfcfd;
    }

    .compact-table tbody tr:hover {
        background-color: #f1f5f9;
    }

    .category-cell {
        font-weight: 600;
        color: #2563eb;
    }

    .amount-cell {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        text-align: right;
        color: #0f172a;
    }

    /* Print Controls */
    .btn-print {
        background: #10b981;
        color: white;
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-size: 13px;
        transition: 0.2s;
    }

    .btn-print:hover { background: #059669; }

    @media print {
        .report-body { padding: 0; background: white; }
        .report-card { box-shadow: none; border: 1px solid #ddd; max-width: 100%; }
        .header-compact { background: white !important; color: black !important; padding: 15px 20px; border-bottom: 2px solid #000; }
        .brand-logo img { filter: none !important; width: 100px; }
        .report-title-badge { background: #eee !important; color: black !important; border: 1px solid #ccc; }
        .btn-print { display: none; }
        .compact-table thead th { background: #eee !important; border-bottom: 1px solid #000; }
    }
</style>

<div class="report-body">
    <div class="report-card">
        <header class="header-compact">
            <div class="brand-side">
                <div class="brand-logo">
                    <img src="{{ asset($abouts->logo_dark) }}" alt="Logo">
                </div>
                <div class="brand-text">
                    <h1>Ovijatrik Social Welfare Organization</h1>
                    <p>Reg: Dinaj/2581/2024 | Islambagh, Dinajpur</p>
                    <p>Phone: +880 1717-017645 | ovijatrik.dinajpur@gmail.com</p>
                </div>
            </div>

            <div class="info-side">
                <div class="report-title-badge">Membership Payment Report</div>
                <div class="fiscal-info">
                    <strong>FY:</strong> {{ $fiscalYear }} <br>
                    @if($month) <strong>Month:</strong> {{ date('F', mktime(0, 0, 0, $month, 1)) }} @endif
                </div>
                <button class="btn-print" onclick="window.print()" style="margin-top: 10px;">🖨️ Print Report</button>
            </div>
        </header>

        <div class="table-section">
            <table class="compact-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">SL</th>
                        <th>Expenditure Head / Category</th>
                        <th style="text-align: center;">Tran. Qty</th>
                        <th style="text-align: right;">Net Amount (BDT)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($reports as $key => $report)
                    @php $grandTotal += $report->total_amount; @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="category-cell">
                            {{ $report->expense_cat_id == 'salary' ? '💼 Staff Salary & Benefits' : '📑 ' . ($report->expense_cat_name ?? 'General Expense') }}
                        </td>
                        <td style="text-align: center;">{{ $report->transaction_count }}</td>
                        <td class="amount-cell">{{ number_format($report->total_amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #f8fafc; border-top: 2px solid #cbd5e1;">
                        <td colspan="3" style="text-align: right; padding: 15px; font-weight: 800; color: #475569; text-transform: uppercase;">Grand Total Expenditure</td>
                        <td class="amount-cell" style="font-size: 18px; color: #1e293b; padding: 15px;">
                            ৳ {{ number_format($grandTotal, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div style="margin-top: 60px; display: flex; justify-content: space-between; padding: 0 20px;">
                <div style="text-align: center; border-top: 1px solid #94a3b8; width: 180px; padding-top: 8px; font-size: 12px; color: #64748b;">Accountant Signature</div>
                <div style="text-align: center; border-top: 1px solid #94a3b8; width: 180px; padding-top: 8px; font-size: 12px; color: #64748b;">Executive Director</div>
            </div>
        </div>
    </div>
</div>