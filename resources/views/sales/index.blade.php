<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Sales Management') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('sales.dashboard') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                    📊 Dashboard
                </a>
                <a href="{{ route('sales.create') }}"
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-200">
                    + New Sale
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        💰
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Sales Today</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            ${{ number_format(\App\Models\Sale::whereDate('date', today())->sum('total'), 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        📋
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Orders Today</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Sale::whereDate('date', today())->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                        📈
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">This Month</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            ${{ number_format(\App\Models\Sale::whereMonth('date', now()->month)->sum('total'), 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-500">
                        👥
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Customers</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ \App\Models\Customer::count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">🔍 Search & Filter Sales</h3>

                <form method="GET" action="{{ route('sales.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                                Search
                            </label>
                            <input type="text"
                                   id="search"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Customer name, email, or sale ID..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Date From -->
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">
                                Date From
                            </label>
                            <input type="date"
                                   id="date_from"
                                   name="date_from"
                                   value="{{ request('date_from') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Date To -->
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">
                                Date To
                            </label>
                            <input type="date"
                                   id="date_to"
                                   name="date_to"
                                   value="{{ request('date_to') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Customer Filter -->
                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Customer
                            </label>
                            <select id="customer_id"
                                    name="customer_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Customers</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                            {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex space-x-3">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md transition duration-200">
                            🔍 Filter
                        </button>
                        <a href="{{ route('sales.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition duration-200">
                            🔄 Reset
                        </a>
                        <a href="{{ route('sales.report') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                           class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-2 rounded-md transition duration-200">
                            📊 Generate Report
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">
                        Sales List ({{ $sales->total() }} {{ Str::plural('sale', $sales->total()) }})
                    </h3>

                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Show:</span>
                        <select onchange="window.location.href=this.value"
                                class="text-sm border border-gray-300 rounded px-2 py-1">
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 15]) }}" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 25]) }}" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                </div>
            </div>

            @if($sales->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sale Details
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created By
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sales as $sale)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-blue-600">
                                                        #{{ $sale->id }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $sale->sale_number }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $sale->total_quantity }} {{ Str::plural('item', $sale->total_quantity) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $sale->customer->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $sale->customer->email }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $sale->date->format('M d, Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $sale->created_at->format('h:i A') }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $sale->formatted_total }}
                                        </div>
                                        @if($sale->has_discount)
                                            <div class="text-sm text-red-500">
                                                -{{ $sale->formatted_discount }} ({{ $sale->discount_percentage }}%)
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $sale->by }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-2">
                                            <!-- View -->
                                            <a href="{{ route('sales.show', $sale) }}"
                                               class="text-blue-600 hover:text-blue-900 p-1 rounded transition duration-200"
                                               title="View Details">
                                                👁️
                                            </a>

                                            <!-- Edit -->
                                            {{-- <a href="{{ route('sales.edit', $sale) }}"
                                               class="text-yellow-600 hover:text-yellow-900 p-1 rounded transition duration-200"
                                               title="Edit Sale">
                                                ✏️
                                            </a> --}}

                                            <!-- Print Invoice -->
                                            <a href="{{ route('sales.invoice', $sale) }}"
                                               target="_blank"
                                               class="text-green-600 hover:text-green-900 p-1 rounded transition duration-200"
                                               title="Print Invoice">
                                                🖨️
                                            </a>

                                            <!-- Delete -->
                                            <button onclick="deleteSale({{ $sale->id }})"
                                                    class="text-red-600 hover:text-red-900 p-1 rounded transition duration-200"
                                                    title="Delete Sale">
                                                🗑️
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $sales->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📊</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No sales found</h3>
                    <p class="text-gray-500 mb-4">
                        @if(request()->hasAny(['search', 'date_from', 'date_to', 'customer_id']))
                            No sales match your current filters. Try adjusting your search criteria.
                        @else
                            Get started by creating your first sale.
                        @endif
                    </p>
                    <div class="space-x-3">
                        @if(request()->hasAny(['search', 'date_from', 'date_to', 'customer_id']))
                            <a href="{{ route('sales.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200">
                                Clear Filters
                            </a>
                        @endif
                        <a href="{{ route('sales.create') }}"
                           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-200">
                            Create First Sale
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <span class="text-red-600 text-2xl">⚠️</span>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Sale</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to delete this sale? This action cannot be undone.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmDelete"
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 transition duration-200">
                        Delete
                    </button>
                    <button onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 transition duration-200">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
let saleToDelete = null;

function deleteSale(saleId) {
    saleToDelete = saleId;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    saleToDelete = null;
    document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (saleToDelete) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/sales/${saleToDelete}`;

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add method override for DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
        window.location.reload();
    }
});

// Quick date filters
function setDateFilter(days) {
    const dateFrom = new Date();
    dateFrom.setDate(dateFrom.getDate() - days);

    const dateFromInput = document.getElementById('date_from');
    const dateToInput = document.getElementById('date_to');

    dateFromInput.value = dateFrom.toISOString().split('T')[0];
    dateToInput.value = new Date().toISOString().split('T')[0];

    // Submit form
    dateFromInput.form.submit();
}

// Add quick filter buttons (you can uncomment if needed)
// document.addEventListener('DOMContentLoaded', function() {
//     const filterSection = document.querySelector('.space-y-4');
//     const quickFilters = document.createElement('div');
//     quickFilters.className = 'flex space-x-2 text-sm';
//     quickFilters.innerHTML = `
//         <span class="text-gray-500">Quick filters:</span>
//         <button type="button" onclick="setDateFilter(1)" class="text-blue-500 hover:underline">Today</button>
//         <button type="button" onclick="setDateFilter(7)" class="text-blue-500 hover:underline">Last 7 days</button>
//         <button type="button" onclick="setDateFilter(30)" class="text-blue-500 hover:underline">Last 30 days</button>
//     `;
//     filterSection.appendChild(quickFilters);
// });
</script>
@endpush

@push('styles')
<style>
    .hover\:scale-105:hover {
        transform: scale(1.05);
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>
@endpush

</x-app-layout>
