<style>
    /* Print styles */
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .report-container { box-shadow: none !important; border: none !important; max-width: 100% !important; }
    }

    body { background-color: #f3f4f6; color: #1f2937; }

    .report-container {
        max-width: 1000px;
        margin: 30px auto;
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Modern Header Design */
    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 3px solid #2563eb;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .company-brand { display: flex; align-items: center; gap: 20px; }
    .company-brand img { height: 80px; width: auto; }
    .company-details h1 { margin: 0; font-size: 24px; color: #1e3a8a; }
    .company-details p { margin: 2px 0; font-size: 13px; color: #4b5563; }

    .report-info { text-align: right; }
    .report-info h2 { margin: 0; font-size: 20px; color: #2563eb; }
    .badge {
        background: #2563eb; color: white; padding: 4px 12px;
        border-radius: 20px; font-size: 12px; display: inline-block; margin-top: 5px;
    }

    /* Table Design */
    .report-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .report-table th {
        background: #f8fafc; color: #334155; font-weight: 700;
        text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px;
        border: 1px solid #cbd5e1; padding: 12px;
    }
    .report-table td { border: 1px solid #cbd5e1; padding: 10px; vertical-align: top; }

    .data-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 14px; }
    .total-row {
        border-top: 2px solid #334155; margin-top: 10px; padding-top: 10px;
        font-weight: bold; color: #1e3a8a;
    }
    
    .summary-card { background: #f0f7ff; padding: 15px; border-radius: 6px; }

    .btn-print {
        background: #059669; color: white; border: none; padding: 8px 16px;
        border-radius: 6px; cursor: pointer; font-weight: 600; transition: 0.3s;
    }
    .btn-print:hover { background: #047857; }
</style>

<div class="report-container">
    <div class="report-header">
        <div class="company-brand">
            <img src="{{ asset($abouts->logo_dark) }}" alt="Logo">
            <div class="company-details">
                <h1>Ovijatrik Social Welfare Organization</h1>
                <p><strong>Reg No:</strong> Dinaj/2581/2024</p>
                <p>Islambagh, Sadar, Dinajpur, Bangladesh</p>
                <p>Phone: +880 1717-017645 | Email: ovijatrik.dinajpur@gmail.com</p>
            </div>
        </div>
        <div class="report-info">
            <h2>Month-Wise Report</h2>
            <div class="badge">Fiscal Year: {{ $fiscalYear }}</div>
            <p style="margin-top: 8px; font-weight: 600;">Month: {{ date('F', mktime(0,0,0,$month,1)) }}</p>
            <div class="no-print" style="margin-top: 15px;">
                <button class="btn-print" onclick="window.print()">🖨️ Print Report</button>
            </div>
        </div>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th width="35%">Income (Receipts)</th>
                <th width="35%">Expenses (Official)</th>
                <th width="30%">Financial Summary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="data-row">
                        <span>Opening Balance (Prev.)</span>
                        <span>{{ number_format($openingBalance, 2) }}</span>
                    </div>
                    <div class="data-row" style="color: #059669;">
                        <span>Current Month Income</span>
                        <span>{{ number_format($incomeItems->sum('payment_amount'), 2) }}</span>
                    </div>
                    
                    <div class="total-row">
                        <div class="data-row">
                            <span>Total Available</span>
                            <span>{{ number_format($openingBalance + $incomeItems->sum('payment_amount'), 2) }}</span>
                        </div>
                    </div>
                </td>

                <td>
                    @foreach($expenseItems as $item)
                        <div class="data-row">
                            <span style="flex-grow: 1; margin-left: 10px;">
                {{ $item['head_name'] }}
            </span>
                            <span>{{ number_format($item['totalexp_amount'], 2) }}</span>
                        </div>
                    @endforeach
                    
                    <div class="total-row" style="color: #dc2626;">
                        <div class="data-row">
                            <span>Total Expense</span>
                            <span>{{ number_format($expenseItems->sum('totalexp_amount'), 2) }}</span>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="summary-card">
                        <div class="data-row">
                            <span>Total Income:</span>
                            <strong>{{ number_format($openingBalance + $incomeItems->sum('payment_amount'), 2) }}</strong>
                        </div>
                        <div class="data-row">
                            <span>Total Expense:</span>
                            <strong style="color: #dc2626;">-{{ number_format($expenseItems->sum('totalexp_amount'), 2) }}</strong>
                        </div>
                        <hr style="border: 0; border-top: 1px solid #cbd5e1; margin: 10px 0;">
                        <div class="data-row" style="font-size: 16px;">
                            <span>Net Balance:</span>
                            <strong style="color: #2563eb;">{{ number_format(($openingBalance + $incomeItems->sum('payment_amount')) - $expenseItems->sum('totalexp_amount'), 2) }}</strong>
                        </div>
                    </div>
                    <p style="font-size: 11px; color: #94a3b8; margin-top: 15px; text-align: center; font-style: italic;">
                        Generated on: {{ date('d M Y, h:i A') }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top: 30px;">
    <h3 style="font-size: 16px; color: #1e3a8a; border-left: 4px solid #2563eb; padding-left: 10px; margin-bottom: 15px;">
        Account Balance Status (Up to {{ date('d M Y', strtotime($endDate)) }})
    </h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 15px;">
        @foreach($accountBalances as $acc)
        <div style="background: #ffffff; border: 1px solid #e2e8f0; padding: 12px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="display: block; font-size: 11px; color: #64748b; text-transform: uppercase;">{{ $acc->bank_name }}</span>
                <span style="font-weight: 600; color: #334155;"> {{ $acc->account_no }}</span>
            </div>
            <div style="text-align: right;">
                <span style="display: block; font-size: 11px; color: #64748b; text-transform: uppercase;">Balance</span>
                <span style="font-weight: 700; color: #2563eb;">{{ number_format($acc->calculated_balance, 2) }}</span>
            </div>
        </div>
        @endforeach
    </div>

    <div style="margin-top: 15px; background: #1e3a8a; color: white; padding: 12px; border-radius: 8px; display: flex; justify-content: space-between;">
        <span style="font-weight: 600;">Total Asset</span>
        <span style="font-weight: 700; font-size: 16px;">৳ {{ number_format($accountBalances->sum('calculated_balance'), 2) }}</span>
    </div>
</div>
</div>