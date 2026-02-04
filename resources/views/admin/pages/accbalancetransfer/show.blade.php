<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Balance Transfer Receipt</title>
    <style>
        * {
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: #f3f4f6;
    padding: 5px;
}

.receipt-container {
    max-width: 700px;
    margin: auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}
/* Company Header */
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #036056; padding-bottom: 10px; margin-bottom: 10px; }
        .company-info h1 { margin: 0; color: #036056; font-size: 18px; letter-spacing: -1px; }
        .company-info p { margin: 2px 0; font-size: 12px; color: #666; }
        .logo-container {
            margin: 0px 0;
        }

        .header-logo {
            max-height: 80px; 
            width: auto;     
            display: block;   
        }

.status {
    text-align: center;
    padding: 5px;
    border-radius: 8px;
    font-weight: 600;
    margin-bottom: 10px;
}

.status.success {
    background: #dcfce7;
    color: #166534;
}

.section {
    margin-bottom: 10px;
}

.section h4 {
    margin-bottom: 10px;
    color: #374151;
}

.row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    padding: 5px 0;
}

.card {
    padding: 12px;
    border-radius: 10px;
}

.card.danger {
    background: #fee2e2;
    color: #7f1d1d;
}

.card.success {
    background: #dcfce7;
    color: #14532d;
}

.remarks {
    background: #f9fafb;
    padding: 10px;
    border-radius: 8px;
    font-size: 14px;
}

.receipt-footer {
    text-align: center;
    margin-top: 30px;
    font-size: 13px;
    color: #555;
}

.actions {
    margin-top: 15px;
}

.actions button {
    padding: 10px 18px;
    margin: 5px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 14px;
}

.actions button:first-child {
    background: #2563eb;
    color: white;
}

.actions button:last-child {
    background: #16a34a;
    color: white;
}

/* PRINT MODE */
@media print {
    body {
        background: white;
    }
    .actions {
        display: none;
    }
}

    </style>
</head>
<body>

<div class="receipt-container">

    <!-- HEADER -->
    <div class="header">
        <div class="company-info">
            <div class="logo-container">
                <img src="{{ asset($abouts->logo_dark) }}" alt="OVIJATRIK Logo" class="header-logo">
            </div>
            <h1>Ovijatrik Social Walfare Organization</h1>
            <p>Reg No: Dinaj/2581/2024</p>
            <p>Islambagh, Sadar, Dinajpur, Bangladesh</p>
            <p>Phone: +880 1717-017645 | Email: ovijatrik.dinajpur@gmail.com</p>
        </div>
        <div class="report-title">
            <h2>Account Balance <br> Transfer Receipt</h2>
            
        </div>
    </div>

    <div class="status success">
        ✔ Balance Transfer Successful
    </div>

    <!-- TRANSFER INFO -->
    <div class="section">
        <h4>Transfer Information</h4>
        <div class="row">
            <span>Transfer No</span>
            <strong>{{ $transferPreview->acc_transfer_no }}</strong>
        </div>
        <div class="row">
            <span>Transfer Date</span>
            <strong>{{ \Carbon\Carbon::parse($transferPreview->acc_transfer_date)->format('d M Y') }}</strong>
        </div>
        <div class="row">
            <span>Fiscal Year</span>
            <strong>{{ $transferPreview->fiscal_year }}</strong>
        </div>
    </div>

    <!-- FROM ACCOUNT -->
    <div class="section">
        <h4>Debited From</h4>
        <div class="card danger">
            <div class="row">
                <span>Bank</span>
                <strong>{{ $transferPreview->fromAccount->bank_name }}</strong>
            </div>
            <div class="row">
                <span>Account No</span>
                <strong>{{ $transferPreview->fromAccount->account_no }}</strong>
            </div>
            <div class="row">
                <span>Amount</span>
                <strong>৳ {{ $transferPreview->transfer_amount }}</strong>
            </div>
            <div class="row">
                <span>Reference</span>
                <strong>{{ $transferPreview->from_reference }}</strong>
            </div>
        </div>
    </div>

    <!-- TO ACCOUNT -->
    <div class="section">
        <h4>Credited To</h4>
        <div class="card success">
            <div class="row">
                <span>Bank</span>
                <strong>{{ $transferPreview->toAccount->bank_name }}</strong>
            </div>
            <div class="row">
                <span>Account No</span>
                <strong>{{ $transferPreview->toAccount->account_no }}</strong>
            </div>
            <div class="row">
                <span>Amount</span>
                <strong>৳ {{ $transferPreview->transfer_amount }}</strong>
            </div>
            <div class="row">
                <span>Reference</span>
                <strong>{{ $transferPreview->to_reference }}</strong>
            </div>
        </div>
    </div>

    <!-- REMARKS -->
    <div class="section">
        <h4>Remarks</h4>
        <p class="remarks">
            {{ $transferPreview->transfer_remarks }}
        </p>
    </div>

    <!-- FOOTER -->
    <div class="receipt-footer">
        <p class="note">This is a system generated receipt. No signature required.</p>
        <div class="actions">
            <button onclick="window.print()">Print</button>
            <button onclick="window.close()">Close</button>
        </div>
    </div>

</div>

</body>
</html>
