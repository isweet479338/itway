<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Sale Details - {{ $sale->sale_number }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Created on {{ $sale->created_at->format('M d, Y \a\t h:i A') }} by {{ $sale->by }}
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('sales.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200">
                    ← Back to Sales
                </a>
                <a href="{{ route('sales.edit', $sale) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md transition duration-200">
                    ✏️ Edit Sale
                </a>
                <a href="{{ route('sales.invoice', $sale) }}"
                   target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-200">
                    🖨️ Print Invoice
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <!-- Sale Status & Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        🧾
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Sale Number</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $sale->sale_number }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        💰
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Amount</p>
                        <p class="text-lg font-semibold text-green-600">{{ $sale->formatted_total }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                        📦
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Items</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $sale->total_quantity }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full {{ $sale->hasDiscount() ? 'bg-red-100 text-red-500' : 'bg-gray-100 text-gray-500' }}">
                        🏷️
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Discount</p>
                        <p class="text-lg font-semibold {{ $sale->hasDiscount() ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $sale->formatted_discount }}
                            @if($sale->hasDiscount())
                                <span class="text-sm">({{ $sale->discount_percentage }}%)</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-6 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Sale Items -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Sale Items</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Product
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit Price
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Discount
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subtotal
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sale->saleItems as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                                        <span class="text-white font-bold text-sm">
                                                            {{ strtoupper(substr($item->product->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->product->name }}
                                                    </div>
                                                    @if($item->product->description)
                                                        <div class="text-sm text-gray-500">
                                                            {{ Str::limit($item->product->description, 50) }}
                                                        </div>
                                                    @endif
                                                    @if($item->product->sku)
                                                        <div class="text-xs text-gray-400">
                                                            SKU: {{ $item->product->sku }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                            ${{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm">
                                            @if($item->discount > 0)
                                                <span class="text-red-600 font-medium">-${{ number_format($item->discount, 2) }}</span>
                                            @else
                                                <span class="text-gray-400">$0.00</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                            ${{ number_format($item->quantity * $item->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-bold text-green-600">
                                            ${{ number_format($item->total, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sale Timeline / Activity Log -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Sale Timeline</h3>
                    </div>
                    <div class="p-6">
                        <div class="flow-root">
                            <ul class="-mb-8">
                                <li>
                                    <div class="relative pb-8">
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                    ✅
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        Sale created by <span class="font-medium text-gray-900">{{ $sale->by }}</span>
                                                    </p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $sale->created_at->toISOString() }}">
                                                        {{ $sale->created_at->format('M d, Y h:i A') }}
                                                    </time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                @if($sale->updated_at != $sale->created_at)
                                    <li>
                                        <div class="relative pb-8">
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                        ✏️
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">
                                                            Sale was last updated
                                                        </p>
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                        <time datetime="{{ $sale->updated_at->toISOString() }}">
                                                            {{ $sale->updated_at->format('M d, Y h:i A') }}
                                                        </time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif

                                <li>
                                    <div class="relative">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center ring-8 ring-white">
                                                    ⏳
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        Payment pending
                                                    </p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    Status
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-12 w-12">
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                                    <span class="text-white font-bold">
                                        {{ strtoupper(substr($sale->customer->name, 0, 2)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">{{ $sale->customer->name }}</h4>
                                <p class="text-sm text-gray-500">Customer</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center">
                                <span class="text-gray-400 mr-3">📧</span>
                                <a href="mailto:{{ $sale->customer->email }}"
                                   class="text-blue-600 hover:underline">
                                    {{ $sale->customer->email }}
                                </a>
                            </div>

                            @if($sale->customer->phone)
                                <div class="flex items-center">
                                    <span class="text-gray-400 mr-3">📞</span>
                                    <a href="tel:{{ $sale->customer->phone }}"
                                       class="text-blue-600 hover:underline">
                                        {{ $sale->customer->phone }}
                                    </a>
                                </div>
                            @endif

                            @if($sale->customer->address)
                                <div class="flex items-start">
                                    <span class="text-gray-400 mr-3 mt-1">📍</span>
                                    <div class="text-gray-600">
                                        <p>{{ $sale->customer->address }}</p>
                                        @if($sale->customer->city || $sale->customer->state || $sale->customer->zip)
                                            <p>
                                                {{ $sale->customer->city }}{{ $sale->customer->city && ($sale->customer->state || $sale->customer->zip) ? ', ' : '' }}
                                                {{ $sale->customer->state }} {{ $sale->customer->zip }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="#"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View Customer Profile →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sale Summary -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Sale Summary</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sale Date:</span>
                                <span class="font-medium">{{ $sale->date->format('M d, Y') }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Items Count:</span>
                                <span class="font-medium">{{ $sale->saleItems->count() }} {{ Str::plural('product', $sale->saleItems->count()) }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Quantity:</span>
                                <span class="font-medium">{{ $sale->total_quantity }}</span>
                            </div>

                            <hr class="border-gray-200">

                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">{{ $sale->formatted_subtotal }}</span>
                            </div>

                            @if($sale->discount > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Discount:</span>
                                    <span class="font-medium text-red-600">-{{ $sale->formatted_discount }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax (10%):</span>
                                <span class="font-medium">{{ $sale->formatted_tax }}</span>
                            </div>

                            <hr class="border-gray-300">

                            <div class="flex justify-between text-lg">
                                <span class="font-semibold text-gray-800">Total Amount:</span>
                                <span class="font-bold text-green-600">{{ $sale->formatted_total }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('sales.edit', $sale) }}"
                           class="w-full flex items-center justify-center px-4 py-2 border border-yellow-300 rounded-md text-sm font-medium text-yellow-700 bg-yellow-50 hover:bg-yellow-100 transition duration-200">
                            ✏️ Edit Sale
                        </a>

                        <a href="{{ route('sales.invoice', $sale) }}"
                           target="_blank"
                           class="w-full flex items-center justify-center px-4 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 transition duration-200">
                            🖨️ Print Invoice
                        </a>

                        <button onclick="shareSale()"
                                class="w-full flex items-center justify-center px-4 py-2 border border-blue-300 rounded-md text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition duration-200">
                            🔗 Share Sale
                        </button>

                        <button onclick="deleteSale({{ $sale->id }})"
                                class="w-full flex items-center justify-center px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 transition duration-200">
                            🗑️ Delete Sale
                        </button>
                    </div>
                </div>

                <!-- Related Sales -->
                @php
                    $relatedSales = \App\Models\Sale::where('customer_id', $sale->customer_id)
                        ->where('id', '!=', $sale->id)
                        ->latest()
                        ->limit(5)
                        ->get();
                @endphp

                @if($relatedSales->count() > 0)
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Recent Sales to This Customer</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @foreach($relatedSales as $relatedSale)
                                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $relatedSale->sale_number }}</p>
                                            <p class="text-xs text-gray-500">{{ $relatedSale->date->format('M d, Y') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-green-600">{{ $relatedSale->formatted_total }}</p>
                                            <a href="{{ route('sales.show', $relatedSale) }}"
                                               class="text-xs text-blue-600 hover:underline">
                                                View →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
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

function shareSale() {
    const url = window.location.href;
    const saleNumber = '{{ $sale->sale_number }}';

    if (navigator.share) {
        navigator.share({
            title: `Sale ${saleNumber}`,
            text: `Check out this sale details`,
            url: url
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(url).then(() => {
            alert('Sale link copied to clipboard!');
        });
    }
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
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // E for edit
    if (e.key === 'e' && !e.ctrlKey && !e.metaKey) {
        if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
            window.location.href = '{{ route("sales.edit", $sale) }}';
        }
    }

    // P for print
    if (e.key === 'p' && !e.ctrlKey && !e.metaKey) {
        if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
            e.preventDefault();
            window.open('{{ route("sales.invoice", $sale) }}', '_blank');
        }
    }

    // Escape to go back
    if (e.key === 'Escape') {
        window.location.href = '{{ route("sales.index") }}';
    }
});
</script>
@endpush

@push('styles')
<style>
    .gradient-avatar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .product-avatar {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .customer-avatar {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    /* Timeline line adjustments */
    .flow-root ul li:last-child .absolute {
        display: none;
    }
</style>
@endpush

</x-app-layout>
