<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loan Preview</title>
        <!-- ✅ CSRF HEADER -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-card {
            background: #ffffff;
            width: 100%;
            max-width: 620px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 25px;
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .preview-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        table tr {
            border-bottom: 1px solid #eee;
        }

        table td {
            padding: 10px 8px;
        }

        table td:first-child {
            font-weight: bold;
            color: #555;
            width: 40%;
        }

        table td:last-child {
            text-align: right;
            color: #111;
            font-weight: 600;
        }

        .status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .pending { background: #fff3cd; color: #856404; }
        .approved { background: #d4edda; color: #155724; }
        .declined { background: #f8d7da; color: #721c24; }

        .action-buttons {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            border: none;
            padding: 10px 22px;
            border-radius: 30px;
            font-size: 14px;
            cursor: pointer;
            transition: 0.3s ease;
            color: #fff;
        }

        .btn-approve {
            background: linear-gradient(45deg, #28a745, #218838);
        }

        .btn-approve:hover {
            transform: scale(1.05);
        }

        .btn-decline {
            background: linear-gradient(45deg, #dc3545, #bd2130);
        }

        .btn-decline:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>

<div class="preview-card">
    <div class="preview-title">Project Loan Preview</div>

    <table>
        <tr>
            <td>Date</td>
            <td>{{ $loan->loan_date }}</td>
        </tr>
        <tr>
            <td>Loan Project</td>
            <td>{{ $loan->loanProject->project_title }}</td>
        </tr>
        <tr>
            <td>Loan Account</td>
            <td>{{ $loan->loanAccount->account_name }}</td>
        </tr>
        <tr>
            <td>Loan Amount</td>
            <td>{{ number_format($loan->loan_amount, 2) }} BDT</td>
        </tr>

        <tr>
            <td>Loan Account Balance</td>
            <td>{{ number_format($accountBalance, 2) }} BDT</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <span class="status {{ $loan->status }}">
                    {{ ucfirst($loan->status) }}
                </span>
            </td>
        </tr>
    </table>
    <div style="padding-top: 10px">
        @foreach($projectAccountBalances as $balance)
        
            <span>{{ $balance->account_name }}</span>
            <span>{{ number_format($balance->balance, 2) }} BDT</span>
        
        @endforeach
    </div>
    <div class="action-buttons">
        <button class="btn btn-approve" onclick="approveLoan({{ $loan->loan_transactions_id }})">
            ✅ Approve
        </button>

        <button class="btn btn-decline" onclick="declineLoan({{ $loan->loan_transactions_id }})">
            ❌ Decline
        </button>
    </div>
</div>

<script>
function approveLoan(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to approve this transfer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Approve'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/loan-approve/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    Swal.fire('Approved!', '', 'success');
                    setTimeout(() => {
                        if (window.opener) {
                            window.opener.location.reload();
                        }

                        window.close();
                    }, 1200);
                }
            });
        }
    });
}

function declineLoan(id) {
    Swal.fire({
        title: 'Decline Reason',
        input: 'textarea',
        inputPlaceholder: 'Enter remarks...',
        inputAttributes: {
            required: true
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        preConfirm: (remarks) => {
            if (!remarks) {
                Swal.showValidationMessage('Remarks is required!');
            }
            return remarks;
        }
    }).then((result) => {
        if (result.isConfirmed) {

            fetch(`/admin/loan-decline/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    remarks: result.value
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    Swal.fire('Declined!', data.message, 'success');

                    setTimeout(() => {
                        if (window.opener) {
                            window.opener.location.reload();
                        }

                        window.close();
                    }, 1200);
                }
            })
            .catch(err => {
                Swal.fire('Error!', 'Something went wrong!', 'error');
            });
        }
    });
}
</script>

</body>
</html>
