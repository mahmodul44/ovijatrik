<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Transfer Invoice</title>
  <style>
    body {
      font-family: "Segoe UI", Roboto, Arial, sans-serif;
      background: #f9fafb;
      margin: 0;
      padding: 30px;
      color: #1f2937;
    }

    .invoice-box {
      max-width: 900px;
      margin: auto;
      background: #fff;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 6px 25px rgba(0,0,0,0.08);
      padding: 40px 50px;
      border: 1px solid #e5e7eb;
    }

    /* Header */
    .invoice-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      border-bottom: 3px solid #2563eb;
      padding-bottom: 20px;
      margin-bottom: 25px;
    }

    .header-left img {
      max-height: 80px;
    }

    .header-center h2 {
      font-size: 28px;
      font-weight: 700;
      margin: 0;
      color: #1e293b;
      letter-spacing: 1px;
      background: #e0f2fe;
      padding: 8px 20px;
      border-radius: 8px;
      box-shadow: inset 0 1px 3px rgba(0,0,0,0.08);
      display: inline-block;
    }

    .header-right {
      text-align: right;
      font-size: 14px;
      line-height: 1.6;
    }
    .header-right h1 {
      margin: 0;
      font-size: 24px;
      font-weight: 700;
      color: #2563eb;
    }
    .header-right p {
      margin: 2px 0;
      color: #4b5563;
    }

    /* Invoice Details */
    .invoice-details-row {
      display: flex;
      justify-content: space-between;
      background: #f3f4f6;
      padding: 12px 18px;
      border-radius: 6px;
      margin-bottom: 25px;
    }
    .invoice-details-row p {
      margin: 0;
      font-size: 15px;
      font-weight: 600;
      color: #111827;
    }
    .invoice-details-row span {
      font-weight: normal;
      color: #374151;
    }

    /* Payment Table */
    .payment {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    .payment th {
      background: #2563eb;
      color: #fff;
      font-weight: 600;
      padding: 14px 15px;
      text-align: left;
      font-size: 14px;
    }
    .payment td {
      padding: 12px 15px;
      border: 1px solid #e5e7eb;
      font-size: 14px;
      background: #fafafa;
    }
    .payment tr:nth-child(even) td {
      background: #f9fafb;
    }

    /* Footer */
    .footer {
      text-align: center;
      font-size: 13px;
      color: #6b7280;
      border-top: 1px solid #e5e7eb;
      padding-top: 12px;
      margin-top: 25px;
    }

    /* Buttons */
    .action-buttons {
      text-align: center;
      margin-top: 25px;
    }
    .btn {
      display: inline-block;
      padding: 10px 22px;
      margin: 5px;
      border-radius: 8px;
      text-decoration: none;
      color: #fff;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
      border: none;
    }
    .btn:hover {
      transform: translateY(-2px);
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
      <div class="header-left">
        <img src="{{ asset('logo.png') }}" alt="Organization Logo">
      </div>
      <div class="header-center">
        <h2>Transfer Invoice</h2>
      </div>
      <div class="header-right">
        <h1>Ovijatrik</h1>
        <p>Charity Organization</p>
        <p>Islambagh, Dinajpur, Bangladesh</p>
        <p>01717 017645 | ovijatrik.org</p>
      </div>
    </div>

    <!-- Invoice Details -->
    <div class="invoice-details-row">
      <p>Invoice No: <span>{{ $invoiceInfo->transfer_no }}</span></p>
      <p>Date: <span>{{ \Carbon\Carbon::parse($invoiceInfo->transfer_date)->format('d M, Y') }}</span></p>
    </div>

    <!-- Payment Info -->
    <table class="payment">
      <tr>
        <th>From Project</th>
        <td>{{ $invoiceInfo->fromProject->project_title }}</td>
      </tr>
      <tr>
        <th>To Project</th>
        <td>{{ $invoiceInfo->toProject->project_title }}</td>
      </tr>
      <tr>
        <th>Amount</th>
        <td>{{ number_format($invoiceInfo->transfer_amount, 2) }} BDT</td>
      </tr>
      <tr>
        <th>Remarks</th>
        <td>{{ $invoiceInfo->transfer_remarks }}</td>
      </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
      &copy; {{ date('Y') }} Ovijatrik Charity Organization | All Rights Reserved
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="action-buttons">
    <button class="btn btn-print" onclick="window.print()">🖨️ Print</button>
    <button class="btn btn-close" onclick="window.close()">❌ Close</button>
  </div>
</body>
</html>
