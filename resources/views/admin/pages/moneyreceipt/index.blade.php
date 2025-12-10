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
                Money Receipts </span>
            </li>
        </ol>
    </nav>

    <a href="{{ route('moneyreceipt.create') }}"
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
        <table id="projectTable" class="min-w-full text-sm text-center border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gradient-to-r from-blue-100 to-blue-200 dark:from-gray-900 dark:to-gray-800 text-gray-700 dark:text-gray-200 uppercase text-xs font-semibold tracking-wider">
        <tr>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-5%" style="text-align: center">#</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-10%" style="text-align: center">Date</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-20%" style="text-align: center">Invoice No</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-20%" style="text-align: center">Project</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-20%" style="text-align: center">Doner</th>
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-20%" style="text-align: center">Amount</th>
            {{-- <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-10%" style="text-align: center">Status</th> --}}
            <th class="px-6 py-3 border border-gray-200 dark:border-gray-600 w-15%" style="text-align: center">Action</th>
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
                                {{ $value->project_id ? $value->project_title : '' }}
                            </td>
                            <td class="px-6 py-4 border border-r border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 text-left">
                                {{ $value->member_id ? $value->member_name : $value->donar_name }}
                            </td>
                            <td class="px-6 py-4 border border-r border-gray-200 dark:border-gray-700 font-medium text-gray-900 dark:text-gray-100 text-right">
                                ৳ {{ number_format($value->payment_amount, 2) }}
                            </td>
                            {{-- <td class="px-6 py-4 border border-r border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 text-center">
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ getStatusLabel($value->status)['class'] }}">
                                    {{ getStatusLabel($value->status)['label'] }}
                                </span>
                            </td> --}}
                            <td style="text-align: center" class="px-6 py-4 border border-r flex gap-3 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 text-center text-sm">
                                <!-- Preview -->
                                <button onclick="openPreviewWindow('{{ route('moneyreceipt.invoicedownload', $value->mr_id) }}')" 
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
                                <a href="{{ route('moneyreceipt.edit', $value->mr_id) }}"
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
                                <form action="{{ route('moneyreceipt.destroy', $value->mr_id) }}" 
                                    method="POST" 
                                    class="deleteProjectForm inline-block">
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


@push('scripts')
<script>
    $(document).ready(function () {
        $('#projectTable').DataTable({
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

   $('.deleteProjectForm').on('submit', function (e) {
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
</script>
@endpush
@endsection
