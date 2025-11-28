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
            padding: 40px 0;
        }

        /* --- INVOICE CONTAINER (A4 Size) --- */
        .invoice-container {
            max-width: 800px; /* A4 width approx */
            margin: 0 auto;
            background: var(--white);
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
            border-top: 6px solid var(--theme-color);
        }

        /* --- HEADER (Smart Banner) --- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .company-details h2 {
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
            text-align: right;
        }

        .invoice-title h1 {
            font-size: 32px;
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
            margin-bottom: 20px;
        }

        .invoice-table th {
            background-color: var(--theme-color);
            color: white;
            text-align: left;
            padding: 12px 15px;
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
            border-top: 1px solid #eee;
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
            top: 180px;
            right: 50px;
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
            margin-bottom: 20px;
        }
        .btn {
            background: #333;
            color: white;
            padding: 10px 20px;
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
                <h2>Ovijatrik</h2>
                <p>
                    Islambagh, Dinajpur, Dhaka, Bangladesh<br>
                    Reg No: OVJ-88923 | Contact: +880 1717 017645<br>
                    Email: ovijatrik.dinajpur@gmail.com
                </p>
            </div>
            <div class="invoice-title">
                <h1>MONEY RECEIPT</h1>
                <div class="receipt-id">Receipt #: {{ $invoiceInfo->fls_receipt_no }}</div>
            </div>
        </header>

        <!-- 2. DONOR & RECEIPT DETAILS -->
        <section class="info-section">
            <div class="donor-info">
                <div class="box-title">Received From (Donor)</div>
                <div class="info-content">
                    <p><strong>Name:</strong> {{ $invoiceInfo->member ? $invoiceInfo->member->name : $invoiceInfo->donar_name }}</p>
                    <p><strong>Member ID:</strong> MEM-0092</p>
                    <p><strong>Phone:</strong> +880 1712-345678</p>
                    <p><strong>Email:</strong> karim.donor@email.com</p>
                </div>
            </div>

            <div class="payment-meta">
                <div class="box-title">Receipt Details</div>
                <div class="info-content">
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoiceInfo->fls_receipt_date)->format('d M, Y') }}</p>
                    <p><strong>Time:</strong> 10:30 AM</p>
                    <p><strong>Collected By:</strong> Admin Desk</p>
                    <p><strong>Status:</strong> <span style="color:green; font-weight:bold;">Successful</span></p>
                </div>
            </div>
        </section>

        <!-- 3. DONATION TABLE -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th width="50%">Description / Purpose</th>
                    <th width="20%" class="text-center">Type</th>
                    <th width="20%" class="text-right">Amount (BDT)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>{{ $invoiceInfo->project_id ? $invoiceInfo->project->project_title : ''}}</td>
                    <td class="text-center">One-time</td>
                    <td class="text-right">{{ number_format($invoiceInfo->fls_receipt_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- 4. PAYMENT METHOD & TOTAL -->
        <section class="summary-section">
            <div class="payment-method-box">
                <div class="box-title" style="border:none; color:#333;">Payment Information</div>
                <!-- Dynamic Payment Info Goes Here -->
                <span><strong>Method:</strong> {{ $invoiceInfo->pay_method_id ? $invoiceInfo->paymentmethod->pay_method_name : $invoiceInfo->pay_method_id }}</span>
                <span><strong>Sender No:</strong> 01712-xxx678</span>
                <span><strong>TrxID:</strong> 9H8J2KL99</span>
                <span><strong>Ref:</strong> WinterDonation</span>
            </div>

            <div class="total-box">
                <div class="total-label">Grand Total Amount</div>
                <div class="total-amount">৳ {{ number_format($invoiceInfo->fls_receipt_amount, 2) }}</div>
                <div style="font-size: 12px; color: #666; margin-top: 5px;">
                    (Seven Thousand Taka Only)
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