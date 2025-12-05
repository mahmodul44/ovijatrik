@extends('layouts.main')
@section('content')
<div class="p-4 max-w-7xl mx-auto">

    <!-- Breadcrumb -->
    <div class="flex justify-between items-center mb-6">
        <nav class="text-sm text-gray-600 dark:text-gray-300">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Dashboard</a>
                </li>
                <li>/</li>
                <li class="text-gray-800 dark:text-gray-200 font-medium">Pending List</li>
            </ol>
        </nav>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div id="success-message"
             class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-4 py-2 rounded-lg mb-4 text-center shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700">
        <table id="pendingloanprojectTable" class="min-w-full text-sm text-gray-700 dark:text-gray-300">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Receipt No</th>
                    <th class="px-6 py-3 text-left">From Project</th>
                    <th class="px-6 py-3 text-left">To Project</th>
                    <th class="px-6 py-3 text-left">Amount</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($loanproject as $index => $value)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($value->loan_date)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4 truncate max-w-xs">{{ $value->loan_transaction_no }}</td>
                        <td class="px-6 py-4 truncate max-w-xs">{{ $value->loanProject->project_title }}</td>
                        <td class="px-6 py-4 truncate max-w-xs">{{ $value->loanAccount->account_name }} {{ $value->loanAccount->account_no }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">{{ $value->loan_amount }}</td>
                        <td class="px-6 py-4 text-center space-x-2 flex justify-center">
                        <button onclick="openPreviewWindow('{{ route('loan.preview', $value->loan_transactions_id) }}')"
                                class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full shadow transition"
                                title="Preview">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" 
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 
                                             0 8.268 2.943 9.542 7-1.274 4.057-5.065 
                                             7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                        </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center px-6 py-4 text-gray-500 dark:text-gray-400">
                            No records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>

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

function viewLaonDetails(Id) {

}

function closeModal() {
    document.getElementById('moneyreceiptModal').classList.add('hidden');
    document.getElementById('moneyreceiptModal').classList.remove('flex');
}

</script>
@endpush
@endsection
