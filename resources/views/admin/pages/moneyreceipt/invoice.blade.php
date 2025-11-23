<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Money Receipt Invoice</title>
  
  <style>
    body {
      font-family: "Segoe UI", Roboto, Arial, sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    .invoice-box {
      max-width: 850px;
      margin: auto;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      padding: 40px;
      border: 1px solid #e5e7eb;
    }

    .invoice-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    border-bottom: 3px solid #2563eb;
    padding-bottom: 10px;
    margin-bottom: 20px;
    position: relative;
}

.header-left img {
    max-height: 100px;
}

.header-center {
    flex: 1;
    text-align: center;
    position: relative;
}

.header-center h2 {
    font-size: 32px;
    font-weight: 700;
    margin: 0;
    color: #1e293b;
    letter-spacing: 1px;
    padding: 10px 20px;
    background: #e0f2fe;
    display: inline-block;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.header-right {
    text-align: right;
    font-size: 14px;
    line-height: 1.5;
}

.header-right h1 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #2563eb;
}

.header-right p {
    margin: 2px 0;
    color: #475569;
}

.header-right a {
    color: #2563eb;
    text-decoration: none;
}


/* Invoice Details Row */
.invoice-details-row {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.invoice-details-row p {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

.invoice-details-row p span {
    font-weight: normal;
}

/* Bill To Section */
.bill-to {
    margin-bottom: 20px;
}

.bill-to h4 {
    margin: 0 0 5px 0;
    font-size: 16px;
    color: #333;
    font-weight: 700;
}

.bill-to p {
    margin: 2px 0;
    color: #555;
    font-size: 14px;
}

    /* Payment Info */
    .payment {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2px;
    }
    .payment th {
      background: #2563eb;
      color: #fff;
      font-weight: 600;
      padding: 12px 15px;
      text-align: left;
      font-size: 14px;
    }
    .payment td {
      padding: 12px 15px;
      border: 1px solid #e5e7eb;
      font-size: 14px;
    }
    /* payment method */
    .paymentmethod{
        margin: 0px 0;
        color: #555;
        font-size: 14px;
    }

    /* Thank You */
    .thank-you {
      text-align: center;
      font-size: 14px;
      margin: 2px 0;
      padding-top: 5px;
      font-weight: 600;
      color: #2563eb;
    }

    /* Footer */
    .footer {
      text-align: center;
      font-size: 13px;
      color: #6b7280;
      border-top: 1px solid #e5e7eb;
      margin-top: 2px;
      padding-top: 5px;
    }

    /* Buttons */
    .action-buttons {
      text-align: center;
      margin-top: 20px;
    }
    .btn {
      display: inline-block;
      padding: 10px 20px;
      margin: 5px;
      border-radius: 8px;
      text-decoration: none;
      color: #fff;
      font-size: 14px;
      cursor: pointer;
      transition: background 0.3s ease;
      border: none;
    }
    .btn-print {
      background: #16a34a;
    }
    .btn-print:hover {
      background: #15803d;
    }
    .btn-close {
      background: #dc2626;
    }
    .btn-close:hover {
      background: #b91c1c;
    }

    .btn-share {
  background: #25D366;
  color: #fff;
  padding: 8px 16px;
  border-radius: 8px;
  text-decoration: none;
  font-size: 14px;
  display: inline-block;
  margin-top: 8px;
}
.btn-share:hover {
  background: #1ebe5a;
}

    /* Print Styles */
    @media print {
      body {
        background: #fff;
        padding: 0;
      }
      .invoice-box {
        box-shadow: none;
        border: none;
        margin: 0;
        padding: 0;
        max-width: 100%;
      }
      .action-buttons {
        display: none !important;
      }
    }
  </style>
</head>
<body>
  <div class="invoice-box">
    <!-- Header -->
   <div class="invoice-header">
    <!-- Left: Logo -->
    <div class="header-left">
        <img src="{{ asset('logo.png') }}" alt="Organization Logo">
    </div>

    <!-- Center: Invoice -->
    <div class="header-center">
        <h2>Invoice</h2>
    </div>

    <!-- Right: Company Info -->
    <div class="header-right">
        <h1>Ovijatrik</h1>
        <p>Charity Organization</p>
        <p>Islambagh, Dinajpur, Bangladesh</p>
        <p>01717 017645 | ovijatrik.org</p>
    </div>
</div>

<!-- Invoice Details Row -->
    <div class="invoice-details-row">
        <p>Invoice No: <span>{{ $invoiceInfo->mr_no }}</span></p>
        <p>Date: <span>{{ \Carbon\Carbon::parse($invoiceInfo->payment_date)->format('d M, Y') }}</span></p>
    </div>

 <!-- Bill To Section -->
    <div class="bill-to">
        <h4>Bill To:</h4>
        <p>{{ $invoiceInfo->member ? $invoiceInfo->member->name : $invoiceInfo->donar_name }}</p>
        <p>{{ $invoiceInfo->member ? $invoiceInfo->member->phone_no : $invoiceInfo->donar_phone }}</p>
        <p>{{ $invoiceInfo->member ? $invoiceInfo->member->email : $invoiceInfo->donar_email }}</p>
        <p>{{ $invoiceInfo->member ? $invoiceInfo->member->member_id : $invoiceInfo->member_id }}</p>
    </div>

    <!-- Payment Info -->
    <table class="payment">
      <tr>
        <th>Description</th>
        <th>Amount</th>
      </tr>
      <tr>
        <td>{{ $invoiceInfo->project_id ? $invoiceInfo->project->project_title : ''}}</td>
        <td>{{ number_format($invoiceInfo->payment_amount, 2) }} BDT</td>
      </tr>
    </table>
    <!-- Payment Method -->
    <div class="paymentmethod">
      <p><span>Payment Method:</span> {{ $invoiceInfo->pay_method_id ? $invoiceInfo->paymentmethod->pay_method_name : $invoiceInfo->pay_method_id }}</p>
    </div>    
    <!-- Thank You -->
    <div class="thank-you">
     <span>Thank you! <br> Your donation is making a real difference in the community.</span>
    </div>

    <!-- Footer -->
    <div class="footer">
      &copy; {{ date('Y') }} Ovijatrik Charity Organization | All Rights Reserved
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="action-buttons">
     <button type="button" id="whatsapp-share" class="btn btn-share">
        📤 Share via WhatsApp
    </button>
    <button class="btn btn-print" onclick="window.print()">🖨️ Print</button>
    <button class="btn btn-close" onclick="window.close()">❌ Close</button>
  </div>

  <script>
 document.addEventListener("DOMContentLoaded", function() {
    let invoiceNo = "{{ $invoiceInfo->mr_id }}";
    let date = "{{ \Carbon\Carbon::parse($invoiceInfo->payment_date)->format('d M, Y') }}";
    let name = "{{ $invoiceInfo->member ? $invoiceInfo->member->name : $invoiceInfo->donar_name }}";
    let amount = "{{ number_format($invoiceInfo->payment_amount, 2) }} BDT";

    let message = `📄 *Receipt Details*%0A` +
                  `Invoice No: ${invoiceNo}%0A` +
                  `Date: ${date}%0A` +
                  `Name: ${name}%0A` +
                  `Amount: ${amount}%0A` +
                  `✅ Thank you for your support to Ovijatrik!`;

    let url = "https://wa.me/?text=" + message;

    document.getElementById("whatsapp-share").addEventListener("click", function() {
        window.open(url, "_blank");
    });
});
</script>

</body>
</html>
