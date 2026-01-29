@extends('layouts.main')
@section('content')
<div class="p-3 max-w-7xl mx-auto">

    <!-- Breadcrumb & Add Button -->
    <div class="flex justify-between items-center mb-2">
     <nav class="text-sm" aria-label="Breadcrumb">
        <ol class="list-reset flex items-center gap-2">
        <!-- Dashboard -->
        <li>
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-1 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9.75L12 3l9 6.75M4.5 10.5V21h15V10.5" />
                </svg>
                Dashboard
            </a>
        </li>

        <!-- Separator -->
        <li>
            <span class="text-gray-400 dark:text-gray-500 mx-1">/</span>
        </li>

        <!-- Current Page -->
        <li class="relative">
            <span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 text-xs font-medium shadow-sm">
                Member Receipts </span>
            </li>
        </ol>
    </nav>

    <a href="{{ route('memberreceipt.create') }}"
        class="inline-flex items-center gap-1 bg-blue-600 dark:bg-blue-500 
                text-white text-sm px-3 py-1.5 rounded-full shadow-sm 
                hover:bg-blue-700 dark:hover:bg-blue-600 
                transition-colors duration-300 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add New
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div id="success-message"
            class="bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 
                   text-green-800 dark:text-green-200 px-4 py-2 rounded mb-4 text-center shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Money Receipt Table -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <table id="memberreceiptTable" class="min-w-full text-sm text-center border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gradient-to-r from-blue-100 to-blue-200 dark:from-gray-900 dark:to-gray-800 text-gray-700 dark:text-gray-200 uppercase text-xs font-semibold tracking-wider">
        <tr>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-5%" style="text-align: center">#</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-10%" style="text-align: center">Date</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-12%" style="text-align: center">Invoice No</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-23%" style="text-align: center">Member Name</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-10%" style="text-align: center">Phone</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-10%" style="text-align: center">Month</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-10%" style="text-align: center">Amount</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-10%" style="text-align: center">Action</th>
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                @if ($moneyreceipts)
                    @foreach($moneyreceipts as $index => $value)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($value->payment_date)->format('d-m-Y') }}</td>
                            <td class="px-6 py-4 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $value->mr_no }}</td>
                            <td class="px-6 py-4 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 text-left">
                              {{ $value->memberID }} - {{ $value->member_name }} 
                            </td>
                            <td class="px-6 py-4 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 text-center">
                                {{ $value->member_phone }}
                            </td>
                            <td class="px-6 py-4 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 text-center">
                            @php
                               $months = json_decode($value->selected_months, true);
                            @endphp

                           {{-- Months --}}
                           @if($months)
                            <div>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($months as $m)
                                        @php
                                            $formatted = \Carbon\Carbon::createFromFormat('Y-m', $m)->format('M Y');
                                        @endphp
                                        
                                        <span class="px-2 py-0.5 rounded-md text-xs font-semibold 
                                                    bg-blue-100 text-blue-700
                                                    dark:bg-blue-900 dark:text-blue-200 shadow-sm">
                                            {{ $formatted }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            </td>
                            <td class="px-6 py-4 border border-r border-gray-200 dark:border-gray-700 font-medium text-gray-900 dark:text-gray-100 text-right">
                                ৳ {{ number_format($value->payment_amount, 2) }}
                            </td>
                           
                            <td style="text-align: center" class="px-6 py-4 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 text-center">
                                <!-- Preview -->
                                <button onclick="openPreviewWindow('{{ route('memberreceipt.invoicedownload', $value->mr_id) }}')" 
                                    title="Preview"
                                    class="inline-flex items-center justify-center w-7 h-7 text-blue-600 bg-blue-50 rounded hover:bg-blue-100 mr-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="w-4 h-4" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke="currentColor" 
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 
                                            4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                @if($value->status == -1)
                                    <!-- Edit -->
                                <a href="{{ route('memberreceipt.edit', $value->mr_id) }}"
                                    title="Edit"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded 
                                            bg-indigo-50 hover:bg-indigo-100 text-indigo-600 
                                            dark:bg-indigo-900 dark:hover:bg-indigo-800 
                                            dark:text-indigo-400 dark:hover:text-indigo-300 mr-1">
                                        
                                        <!-- Pencil / Edit Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="w-4 h-4" 
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke="currentColor" 
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                                d="M16.862 3.487a2.25 2.25 0 113.182 3.182l-10.95 10.95a4.5 4.5 0 01-1.897 1.13l-3.39.97a.75.75 0 01-.927-.927l.97-3.39a4.5 4.5 0 011.13-1.897l10.95-10.95z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                                d="M19.5 7.5l-3-3" />
                                        </svg>
                                    </a>

                                <!-- Delete -->
                                <form action="{{ route('memberreceipt.destroy', $value->mr_id) }}" 
                                    method="POST" 
                                    class="deleteMemberReceiptForm inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        title="Delete"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-900 dark:hover:bg-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="w-4 h-4"
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke="currentColor" 
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                        </svg>
                                    </button>
                                </form>

                                @endif
                                <button type="button" 
                                onclick="shareReceipt('{{ $value->mr_no }}', '{{ \Carbon\Carbon::parse($value->payment_date)->format('d M, Y') }}', '{{ $value->member->name ?? 'N/A' }}', '{{ $value->member->member_id ?? 'N/A' }}', '{{ $value->project->project_title ?? 'General Donation' }}', '{{ number_format($value->payment_amount, 2) }}', '{{ $value->paymentmethod->pay_method_name ?? 'Cash' }}','{{ $value->selected_months }}')"
                                class="text-blue-600 hover:text-blue-900 mx-1" title="Share as Image">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center px-6 py-4 text-gray-500 dark:text-gray-400">No records found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>

<div id="share-invoice-wrapper" class="absolute -left-[9999px] top-0">
    <div id="hidden-share-card" class="w-[450px] bg-white p-6 border-t-8 border-green-600 font-sans">
        <div class="flex justify-between items-start mb-6 border-bottom pb-4 border-gray-100">
            <div>
                <h2 class="text-green-700 text-2xl font-bold uppercase tracking-tight"> <img src="{{ asset($abouts->logo_dark) }}" alt="Logo" style="width: 150px;"> </h2>
                <p class="text-[10px] text-green-700 leading-tight">Ovijatrik Social Walfare Organization</p>
                <p class="text-[9px] text-gray-500 leading-tight">Reg No: Dinaj/2581/2024</p>
                <p class="text-[9px] text-gray-500 leading-tight">Islambagh, Sadar, Dinajpur, Bangladesh</p>
            </div>
            <div class="text-right">
                <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-2 rounded">MEMBERSHIP DONATION RECEIPT</span>
                <p id="s_mr_no" class="text-xs font-bold mt-1 text-gray-700"></p>
            </div>
        </div>

        <div class="space-y-3 mb-6">
            <div class="flex justify-between text-sm border-b border-dashed pb-1">
                <span class="text-gray-500">Date:</span>
                <span id="s_date" class="font-semibold"></span>
            </div>
            <div class="flex justify-between text-sm border-b border-dashed pb-1">
                <span class="text-gray-500">Donor Name:</span>
                <span id="s_name" class="font-semibold text-green-700"></span>
            </div>
            <div class="flex justify-between text-sm border-b border-dashed pb-1">
                <span class="text-gray-500">Member ID:</span>
                <span id="s_mid" class="font-semibold"></span>
            </div>
            <div class="flex justify-between text-sm border-b border-dashed pb-1">
                <span class="text-gray-500">Purpose:</span>
                <span id="s_purpose" class="font-semibold"></span>
            </div>
            <div class="flex justify-between text-sm border-b border-dashed pb-1">
                <span class="text-gray-500">Payment:</span>
                <span id="s_method" class="font-semibold uppercase"></span>
            </div>
            <div class="flex justify-between text-sm border-b border-dashed pb-1">
                <span class="text-gray-500">Payment Month:</span>
                <span id="s_pay_month" class="font-semibold uppercase"></span>
            </div>
        </div>

        <div class="bg-green-50 p-4 rounded-lg text-center mb-6">
            <p class="text-xs text-green-600 uppercase font-bold tracking-widest mb-1">Total Received</p>
            <h1 id="s_amount" class="text-3xl font-black text-green-800"></h1>
        </div>

        <div class="text-center border-t pt-4 border-gray-100">
            <p class="text-[10px] text-gray-400 italic mb-2">Thank you for your generous contribution.</p>
            <p class="text-[9px] font-bold text-gray-500 tracking-tighter uppercase">www.ovijatrik.org</p>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
@push('scripts')
<script>
    $(document).ready(function () {
        $('#memberreceiptTable').DataTable({
            paging: true,
            searching: true,
            responsive: true,
            language: {
                searchPlaceholder: "",
                search: "",
            },
            columnDefs: [
            { orderable: false, targets: [ 2, 3, 4, 5, 6] } 
            ]
        });
    });

   $('.deleteMemberReceiptForm').on('submit', function (e) {
    e.preventDefault();

    const form = $(this);
    const url = form.attr('action');

    Swal.fire({
        title: 'Are you sure?',
        text: "This receipt will be permanently deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'Failed to delete receipt.',
                        'error'
                    );
                }
            });
        }
    });
});

    function openPreviewWindow(url) {
        let width = 800;
        let height = 600;
        let left = (screen.width / 2) - (width / 2);
        let top = (screen.height / 2) - (height / 2);

        window.open(
            url,
            'previewWindow',
            `width=${width},height=${height},top=${top},left=${left},scrollbars=yes,resizable=no`
        );
    }

async function shareReceipt(mrNo, date, name, mermberid, purpose, amount, method, monthJson) {
    document.getElementById('s_mr_no').innerText = '#' + mrNo;
    document.getElementById('s_date').innerText = date;
    document.getElementById('s_name').innerText = name;
    document.getElementById('s_mid').innerText = mermberid;
    document.getElementById('s_purpose').innerText = purpose;
    document.getElementById('s_method').innerText = method;
    document.getElementById('s_amount').innerText = '৳ ' + amount;
    let displayMonth = 'N/A';
    try {
        if (monthJson) {
            let months = JSON.parse(monthJson); 
            
            if (Array.isArray(months) && months.length > 0) {
                months.sort();

                if (months.length === 1) {
                    displayMonth = formatMonthLabel(months[0]);
                } else {
                    let startMonth = formatMonthLabel(months[0]);
                    let endMonth = formatMonthLabel(months[months.length - 1]);
                    displayMonth = `${startMonth} - ${endMonth}`;
                }
            }
        }
    } catch (e) {
        console.error("Month parsing error:", e);
        displayMonth = 'N/A';
    }

    document.getElementById('s_pay_month').innerText = displayMonth;

    const element = document.getElementById("hidden-share-card");

    Swal.fire({
        title: 'Please Wait...',
        text: 'Preparing receipt image',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    try {
        const canvas = await html2canvas(element, { scale: 2 });
        const imageData = canvas.toDataURL("image/png");
        
        canvas.toBlob(async (blob) => {
            Swal.close(); 

            Swal.fire({
                title: 'Share Receipt',
                html: `
                    <div class="flex flex-col gap-3 p-2">
                        <button id="copyBtn" class="w-full bg-blue-600 text-white py-2 rounded font-bold hover:bg-blue-700">📋 Copy to Clipboard</button>
                        <button id="waBtn" class="w-full bg-green-600 text-white py-2 rounded font-bold hover:bg-green-700">💬 Share on WhatsApp</button>
                        <button id="dlBtn" class="w-full bg-gray-600 text-white py-2 rounded font-bold hover:bg-gray-700">📥 Download Image</button>
                    </div>
                `,
                showConfirmButton: false,
                showCloseButton: true,
                didOpen: () => {
                 
                    document.getElementById('copyBtn').addEventListener('click', async () => {
                        try {
                            const item = new ClipboardItem({ "image/png": blob });
                            await navigator.clipboard.write([item]);
                            Swal.fire({ icon: 'success', title: 'Copied!', text: 'Now paste (Ctrl+V) in Messenger/WhatsApp', timer: 2000, showConfirmButton: false });
                        } catch (err) {
                            Swal.fire('Error', 'Copying failed. Please use Download.', 'error');
                        }
                    });

              
                    document.getElementById('waBtn').addEventListener('click', () => {
                        const text = `Money Receipt: ${mrNo}\nDonor: ${name}\nAmount: ${amount} BDT`;
                        window.open(`https://web.whatsapp.com/send?text=${encodeURIComponent(text)}`, '_blank');
                    });

               
                    document.getElementById('dlBtn').addEventListener('click', () => {
                        const link = document.createElement('a');
                        link.download = `Receipt_${mrNo}.png`;
                        link.href = imageData;
                        link.click();
                    });
                }
            });
        });
    } catch (error) {
        Swal.fire('Error', 'Something went wrong!', 'error');
        console.error(error);
    }
}

function formatMonthLabel(monthStr) {
    const date = new Date(monthStr + '-01'); 
    return date.toLocaleString('default', { month: 'short', year: 'numeric' });
}
</script>
@endpush
@endsection
