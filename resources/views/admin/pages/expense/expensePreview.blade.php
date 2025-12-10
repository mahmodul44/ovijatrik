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
            color: #740505;
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
            justify-content: space-between;
            margin-bottom: 20px;
            width: 100%;
        }

        .signature {
            text-align: center;
            flex: 1;  
        }

        .sign-line {
            border-top: 1px solid #333;
            padding-top: 5px;
            font-weight: bold;
            font-size: 14px;
            width: 80%;          
            margin: 0 auto; 
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
            right: 42%;
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
        <button class="btn" onclick="window.print()">🖨️ Print Voucher / Download PDF</button>
    </div>

    <div class="invoice-container">
        
        <!-- PAID STAMP (Visual only) -->
        <div class="stamp">VOUCHER</div>

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
                <h1>VOUCHER RECEIPT</h1>
                {{-- <div class="receipt-id">Voucher No#: {{ $expense->expense_no }}</div> --}}
            </div>
        </header>

        <!-- 2. DONOR & RECEIPT DETAILS -->
        <section class="info-section">
            <div class="donor-info">
                <div class="box-title">Voucher No#: {{ $expense->expense_no }}</div>
                <div class="info-content">
                    <p><strong>Expense Head:</strong> {{ $expense->expense_cat_id ? $expense->expcategory->expense_cat_name : '' }}</p>
                    <p><strong>Receiver Name:</strong> {{ $expense->receiver_name ? $expense->receiver_name : '' }}</p>
                    <p><strong>Voucher Amount:</strong> {{ $expense->expense_amount ? $expense->expense_amount : '0.00' }}</p>
                    <p><strong>Voucher Remarks:</strong> {{ $expense->expense_remarks ? $expense->expense_remarks : '' }}</p>
                </div>
            </div>

            <div class="payment-meta">
                <div class="box-title">Voucher Date:  {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M, Y') }} </div>
                <div class="info-content">
                    <p><strong>Prepared  Date:</strong> {{ \Carbon\Carbon::parse($expense->created_at)->format('d M, Y') }}</p>
                    <p><strong>Prepared By:</strong>  {{ $expense->createdUser->name ?? 'N/A' }}</p>
                    <p><strong>Expense Account:</strong> {{ $expense->account->account_name }} - {{ $expense->account->account_no }}</p>
                </div>
            </div>
        </section>

        <!-- 4. PAYMENT METHOD & TOTAL -->
        <section class="summary-section">
            <div class="payment-method-box">
                <div class="box-title" style="border:none; color:#333;">Receiver Account Information</div>
                <!-- Dynamic Payment Info Goes Here -->
                <span><strong>Method:</strong> {{ $expense->pay_method_id ? $expense->paymentmethod->pay_method_name : $expense->pay_method_id }}</span>
                <span><strong>Sender No:</strong> {{ $expense->mobile_account_no ? $expense->mobile_account_no : '' }}</span>
                <span><strong>TrxID:</strong> {{ $expense->transaction_no ? $expense->transaction_no : '' }}</span>
            </div>

            <div class="total-box">
                <div class="total-label">Grand Total Amount</div>
                <div class="total-amount">৳ {{ number_format($expense->expense_amount, 2) }}</div>
                <div style="font-size: 12px; color: #1f1e1e; margin-top: 5px;">
                    <strong> ({{ amountInWords($expense->expense_amount) }}) </strong>
                </div>
            </div>
        </section>
        
        <!-- 5. FOOTER -->
        <footer class="footer">
            <div class="signature-area">
                 <div class="signature">
                    <div class="sign-line">Cashier</div>
                </div>
                <div class="signature">
                    <!-- <img src="sig.png" alt="Signature" height="40"> -->
                    <div class="sign-line">Secretary</div>
                </div>
                 <div class="signature">
                    <div class="sign-line">President</div>
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