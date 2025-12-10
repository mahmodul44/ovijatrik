<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Money Receipt</title>
    <style>
        /* --- CSS VARIABLES --- */
        :root {
            --theme-color: #27ae60; /* Green for Charity */
            --theme-dark: #1e8449;
            --text-color: #333;
            --text-secondary: #666;
            --bg-color: #f4f4f4;
            --white: #ffffff;
        }

        /* --- RESET & BASIC STYLES --- */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            padding: 4px 0;
        }

        /* --- INVOICE CONTAINER (A4 Size) --- */
        .invoice-container {
            max-width: 800px; /* A4 width approx */
            margin: 0 auto;
            background: var(--white);
            padding-top: 15px!important;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
            border-top: 6px solid var(--theme-color);
        }

        /* --- HEADER (Smart Banner) --- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .company-details img {
            color: var(--theme-color);
            font-size: 26px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .company-details p {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .invoice-title {
            margin-top: 40px;
            text-align: right;
        }

        .invoice-title h1 {
            font-size: 30px;
            color: #ddd;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .receipt-id {
            font-size: 14px;
            color: var(--text-color);
            font-weight: bold;
        }

        /* --- DONOR & INFO SECTION --- */
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .box-title {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 8px;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
            display: inline-block;
        }

        .donor-info, .payment-meta {
            width: 48%;
        }

        .info-content p {
            margin-bottom: 5px;
            font-size: 14px;
        }

        .info-content strong {
            color: var(--theme-dark);
            min-width: 80px;
            display: inline-block;
        }

        /* --- TABLE STYLES --- */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .invoice-table th {
            background-color: var(--theme-color);
            color: white;
            text-align: left;
            padding: 12px 5px;
            font-size: 13px;
            text-transform: uppercase;
        }

        .invoice-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .invoice-table tr:last-child td {
            border-bottom: none;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* --- TOTAL & PAYMENT METHOD SECTION --- */
        .summary-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 10px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .payment-method-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            border-left: 4px solid var(--theme-color);
            font-size: 13px;
            width: 50%;
        }
        
        .payment-method-box span {
            display: block;
            margin-bottom: 4px;
        }

        .total-box {
            text-align: right;
            width: 40%;
        }

        .total-label {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .total-amount {
            font-size: 28px;
            font-weight: bold;
            color: var(--theme-dark);
            margin-top: 5px;
        }

        /* --- FOOTER & SIGNATURE --- */
        .footer {
            margin-top: 60px;
            padding-top: 20px;
            /* border-top: 1px solid #eee; */
        }

        .signature-area {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .signature {
            text-align: center;
            width: 200px;
        }

        .sign-line {
            border-top: 1px solid #333;
            padding-top: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .thank-you-msg {
            text-align: center;
            font-style: italic;
            color: var(--text-secondary);
            font-size: 13px;
        }

        /* --- STAMP EFFECT --- */
        .stamp {
            position: absolute;
            bottom: 40%;
            right: 45%;
            border: 3px solid #27ae60;
            color: #27ae60;
            font-size: 24px;
            font-weight: bold;
            padding: 5px 20px;
            text-transform: uppercase;
            transform: rotate(-15deg);
            opacity: 0.3;
            pointer-events: none;
        }

        /* --- BUTTONS --- */
        .actions {
            text-align: center;
            margin-bottom: 5px;
        }
        .btn {
            background: #333;
            color: white;
            padding: 10px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn:hover { background: #000; }

        /* --- PRINT MEDIA QUERY --- */
        @media print {
            body { background: none; padding: 0; }
            .invoice-container { box-shadow: none; border-top: none; padding: 20px; width: 100%; max-width: 100%; }
            .actions { display: none; }
            .stamp { opacity: 0.5; } /* Darker on print */
        }
    </style>
</head>
<body>

    <div class="actions">
        <button class="btn" onclick="window.print()">🖨️ Print Receipt / Download PDF</button>
    </div>

    <div class="invoice-container">
        
        <!-- PAID STAMP (Visual only) -->
        <div class="stamp">RECEIVED</div>

        <!-- 1. HEADER -->
        <header class="header">
            <div class="company-details">
                <img width="52%" src="{{ asset($abouts->logo_dark) }}" alt="Logo">
                {{-- <h2>Ovijatrik</h2> --}}
                <p>
                    Islambagh, Dinajpur, Dhaka, Bangladesh<br>
                    Reg No: OVJ-88923 | Contact: +880 1717 017645<br>
                    Email: ovijatrik.dinajpur@gmail.com
                </p>
            </div>
            <div class="invoice-title">
                <h1>DONATION RECEIPT</h1>
                <div class="receipt-id">Receipt No#: {{ $invoiceInfo->mr_no }}</div>
            </div>
        </header>

        <!-- 2. DONOR & RECEIPT DETAILS -->
        <section class="info-section">
            <div class="donor-info">
                <div class="box-title">Received From (Donor)</div>
                <div class="info-content">
                    <p><strong>Date:</strong>{{ \Carbon\Carbon::parse($invoiceInfo->payment_date)->format('d M, Y') }}</p>
                    <p><strong>Name:</strong> {{ $invoiceInfo->member ? $invoiceInfo->member->name : 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $invoiceInfo->member_id ? $invoiceInfo->member->phone_no : 'N/A' }} </p>
                    <p><strong>Member ID:</strong> {{ $invoiceInfo->member_id ? $invoiceInfo->member->member_id : 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $invoiceInfo->member_id ? $invoiceInfo->member->email : 'N/A' }}</p>
                     <p><strong>Fiscal Year:</strong> {{ $invoiceInfo->fiscal_year ? $invoiceInfo->fiscal_year : 'N/A' }}</p>
                </div>
            </div>

            <div class="payment-meta">
                <div class="box-title">Receipt Details</div>
                <div class="info-content">
                    <p><strong>Created On:</strong> {{ \Carbon\Carbon::parse($invoiceInfo->created_at)->format('d M, Y') }}</p>
                    {{-- <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($invoiceInfo->created_at)->format('h:i A') }}</p> --}}
                    <p><strong>Created By:</strong>  {{ $invoiceInfo->createdUser->name ?? 'N/A' }}</p>
                    <p><strong>Received Account:</strong> {{ $invoiceInfo->account->account_name }} - {{ $invoiceInfo->account->account_no }}</p>
                </div>
            </div>
        </section>

        <!-- 3. DONATION TABLE -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th width="50%">Description / Purpose</th>
                    <th width="20%" style="text-align: right!important">Amount (BDT)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>{{ $invoiceInfo->project_id ? $invoiceInfo->project->project_title : ''}}</td>
                    <td class="text-right">{{ number_format($invoiceInfo->payment_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- 4. PAYMENT METHOD & TOTAL -->
        <section class="summary-section">
            <div class="payment-method-box">
                <div class="box-title" style="border:none; color:#333;">Payment Information</div>
                <!-- Dynamic Payment Info Goes Here -->
                <span><strong>Method:</strong> {{ $invoiceInfo->pay_method_id ? $invoiceInfo->paymentmethod->pay_method_name : $invoiceInfo->pay_method_id }}</span>
                <span><strong>Sender No:</strong> {{ $invoiceInfo->mobile_account_no ? $invoiceInfo->mobile_account_no : '' }}</span>
                <span><strong>TrxID:</strong> {{ $invoiceInfo->transaction_no ? $invoiceInfo->transaction_no : '' }}</span>
                @php
                    $months = $invoiceInfo->selected_months ? json_decode($invoiceInfo->selected_months) : [];
                @endphp

                <span><strong>Months:</strong> 
                    @if(count($months) > 0)
                        {{ implode(', ', array_map(function($m){
                            return \Carbon\Carbon::createFromFormat('Y-m', $m)->format('F Y');
                        }, $months)) }}
                    @else
                        ---
                    @endif
                </span>
            </div>

            <div class="total-box">
                <div class="total-label">Grand Total Amount</div>
                <div class="total-amount">৳ {{ number_format($invoiceInfo->payment_amount, 2) }}</div>
                <div style="font-size: 12px; color: #1f1e1e; margin-top: 5px;">
                    <strong> ({{ amountInWords($invoiceInfo->payment_amount) }}) </strong>
                </div>
            </div>
        </section>

        <!-- 5. FOOTER -->
        <footer class="footer">
            <div class="signature-area">
                <div class="signature">
                    <!-- <img src="sig.png" alt="Signature" height="40"> -->
                    <div class="sign-line">Accounts Officer</div>
                </div>
            </div>
            <div class="thank-you-msg">
                "Those who spend their wealth in charity will be rewarded."<br>
                Thank you for your generous contribution to humanity.
            </div>
            <div style="text-align: center; font-size: 10px; color: #999; margin-top: 20px;">
                This is a computer-generated receipt and does not require a physical seal.
            </div>
        </footer>

    </div>

</body>
</html>