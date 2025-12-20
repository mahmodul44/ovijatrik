@extends('layouts.main')
@section('content')
<div class="p-4 max-w-6xl mx-auto">

    <!-- Breadcrumb -->
    <div class="flex justify-between items-center mb-4">
        <nav class="text-sm text-gray-500 dark:text-gray-400">
            <ol class="list-reset flex">
                <li><a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline dark:text-blue-400">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700 dark:text-gray-300">My Receipts List</li>
            </ol>
        </nav>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div id="success-message"
             class="bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 px-4 py-2 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Receipt Table -->
    <div class="card-body overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <table id="myreceiptTable" class="min-w-full border border-gray-200 dark:border-gray-700 text-sm" style="text-align: center">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                <tr>
                    <th class="px-6 py-3 font-semibold border">#</th>
                    <th class="px-6 py-3 font-semibold border">Date</th>
                    <th class="px-6 py-3 font-semibold border">Inv No</th>
                    <th class="px-6 py-3 font-semibold border">Description</th>
                    <th class="px-6 py-3 font-semibold border">Amount</th>
                    <th class="px-6 py-3 font-semibold border">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @if ($moneyreceipts)
                    @foreach($moneyreceipts as $index => $value)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-center border text-gray-800 dark:text-gray-300">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-center border text-gray-800 dark:text-gray-300">{{ \Carbon\Carbon::parse($value->payment_date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-center border text-gray-800 dark:text-gray-300">{{ $value->mr_no }}</td>
                            <td class="px-6 py-4 text-left border text-gray-800 dark:text-gray-300">{{ $value->project->project_title }}</td>
                            <td class="px-6 py-4 text-right font-medium border text-gray-900 dark:text-gray-100">৳ {{ $value->payment_amount }}</td>
                            <td class="px-6 py-4 flex items-center border">
    <!-- Preview -->
    <button
        onclick="openPreviewWindow('{{ route('moneyreceipt.invoicedownload', $value->mr_id) }}')"
        class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium
               text-indigo-600 hover:text-indigo-800
               hover:bg-indigo-50 rounded-md transition">
        <!-- Eye Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M1.5 12s4-7.5 10.5-7.5S22.5 12 22.5 12s-4 7.5-10.5 7.5S1.5 12 1.5 12z"/>
            <circle cx="12" cy="12" r="3"/>
        </svg>
        Preview
    </button>

    <!-- Download -->
    <button
        onclick="downloadInvoice('{{ route('moneyreceipt.invoicedownload', $value->mr_id) }}', '{{ $value->mr_no }}')"
        class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium
               text-emerald-600 hover:text-emerald-800
               hover:bg-emerald-50 rounded-md transition">
        <!-- Download Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 3v12m0 0l4-4m-4 4l-4-4"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 17h16"/>
        </svg>
        Download
    </button>

                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#myreceiptTable').DataTable({
            paging: true,
            searching: true,
            responsive: true,
            language: {
                searchPlaceholder: "",
                search: "",
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

    function downloadInvoice(url, invoiceNo) {
    fetch(url)
        .then(response => response.text()) 
        .then(html => {
            const blob = new Blob([html],  { type: 'application/pdf' }); 
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `Invoice-${invoiceNo}.pdf`; 
            document.body.appendChild(link);
            link.click(); 
            document.body.removeChild(link);
        })
        .catch(err => console.error('Error downloading invoice:', err));
}

</script>
@endpush
@endsection
