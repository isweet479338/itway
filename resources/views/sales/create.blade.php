<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Order') }}
        </h2>
    </x-slot>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">Create New Order</h1>

            <!-- Success/Error Messages -->
            <div id="message-container" class="mb-4 hidden">
                <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 hidden">
                    <span class="block sm:inline" id="success-text"></span>
                </div>
                <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 hidden">
                    <span class="block sm:inline" id="error-text"></span>
                </div>
            </div>

            <form id="order-form" class="space-y-6">
                @csrf

                <!-- Customer Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Customer *
                        </label>
                        <select id="customer_id" name="customer_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Choose a customer...</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->email }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="order_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Order Date *
                        </label>
                        <input type="date" id="order_date" name="order_date" required
                               value="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Products Section -->
                <div class="border-t pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Order Items</h2>
                        <button type="button" id="add-product" onclick="addProductRow()"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                            + Add Product
                        </button>
                    </div>

                    <div id="products-container">
                        <!-- Product rows will be added here dynamically -->
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="border-t pt-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Subtotal:</span>
                                <div class="font-semibold">$<span id="subtotal">0.00</span></div>
                            </div>
                            <div>
                                <span class="text-gray-600">Total Discount:</span>
                                <div class="font-semibold text-red-600">-$<span id="total-discount">0.00</span></div>
                            </div>
                            <div>
                                <span class="text-gray-600">Tax (10%):</span>
                                <div class="font-semibold">$<span id="tax-amount">0.00</span></div>
                            </div>
                            <div class="md:col-span-1">
                                <span class="text-gray-600">Total Amount:</span>
                                <div class="text-xl font-bold text-green-600">$<span id="total-amount">0.00</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="window.history.back()"
                            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                        Cancel
                    </button>
                    <button type="submit" id="submit-btn"
                            class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md transition duration-200">
                        <span id="submit-text">Create Order</span>
                        <span id="submit-loading" class="hidden">Creating...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Product Row Template -->
<template id="product-row-template">
    <div class="product-row border border-gray-200 rounded-lg p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Product *</label>
                <select name="products[INDEX][product_id]" class="product-select w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Select product...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->sell_price }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                <input type="number" name="products[INDEX][quantity]" class="quantity-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       min="1" value="1" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unit Price *</label>
                <input type="number" name="products[INDEX][price]" class="price-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       step="0.01" min="0" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Discount ($)</label>
                <input type="number" name="products[INDEX][discount]" class="discount-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       step="0.01" min="0" value="0">
            </div>

            <div class="flex items-end">
                <button type="button" class="remove-product w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md transition duration-200">
                    Remove
                </button>
            </div>
        </div>

        <div class="mt-2 text-right">
            <span class="text-sm text-gray-600">Line Total: </span>
            <span class="line-total font-semibold text-lg">$0.00</span>
        </div>
    </div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let productIndex = 0;
    const productsContainer = document.getElementById('products-container');
    const addProductBtn = document.getElementById('add-product');
    const orderForm = document.getElementById('order-form');

    console.log('Script loaded'); // Debug log
    console.log('Add button:', addProductBtn); // Debug log

    // Add first product row on load
    addProductRow();

    // Add product row - using both click and direct function call
    if (addProductBtn) {
        addProductBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Add product clicked'); // Debug log
            addProductRow();
        });
    }

    function addProductRow() {
    console.log('Adding product row', productIndex); // Debug log

    const template = document.getElementById('product-row-template');
    if (!template) {
        console.error('Template not found');
        return;
    }

    const clone = template.content.cloneNode(true);

    // Replace INDEX with actual index in all attributes and names
    const tempDiv = document.createElement('div');
    tempDiv.appendChild(clone);
    let html = tempDiv.innerHTML;
    html = html.replace(/INDEX/g, productIndex);

    // Add the new row
    productsContainer.insertAdjacentHTML('beforeend', html);

    const newRow = productsContainer.lastElementChild;
    if (newRow) {
        attachRowEvents(newRow);
        console.log('Product row added successfully'); // Debug log
    }

    productIndex++;
    calculateTotals();
}


    function attachRowEvents(row) {
        const productSelect = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        const priceInput = row.querySelector('.price-input');
        const discountInput = row.querySelector('.discount-input');
        const removeBtn = row.querySelector('.remove-product');

        console.log('Attaching events to row elements:', {
            productSelect, quantityInput, priceInput, discountInput, removeBtn
        }); // Debug log

        // Auto-fill price when product is selected
        if (productSelect) {
            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const price = selectedOption.getAttribute('data-price');
                    if (priceInput && price) {
                        priceInput.value = price;
                        calculateRowTotal(row);
                    }
                }
            });
        }

        // Calculate totals on input changes
        [quantityInput, priceInput, discountInput].forEach(input => {
            if (input) {
                input.addEventListener('input', () => calculateRowTotal(row));
            }
        });

        // Remove row
        if (removeBtn) {
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (productsContainer.children.length > 1) {
                    row.remove();
                    calculateTotals();
                } else {
                    alert('At least one product is required.');
                }
            });
        }
    }

    function calculateRowTotal(row) {
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const discount = parseFloat(row.querySelector('.discount-input').value) || 0;

        const lineTotal = (quantity * price) - discount;
        row.querySelector('.line-total').textContent = '$' + lineTotal.toFixed(2);

        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = 0;
        let totalDiscount = 0;

        document.querySelectorAll('.product-row').forEach(row => {
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const discount = parseFloat(row.querySelector('.discount-input').value) || 0;

            subtotal += quantity * price;
            totalDiscount += discount;
        });

        const taxAmount = (subtotal - totalDiscount) * 0.10;
        const totalAmount = subtotal - totalDiscount + taxAmount;

        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('total-discount').textContent = totalDiscount.toFixed(2);
        document.getElementById('tax-amount').textContent = taxAmount.toFixed(2);
        document.getElementById('total-amount').textContent = totalAmount.toFixed(2);
    }

    // Form submission
    orderForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitLoading = document.getElementById('submit-loading');

        // Show loading state
        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        submitLoading.classList.remove('hidden');

        // Prepare form data
        const formData = new FormData(this);

        // Submit via AJAX
        fetch('{{ route("orders.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('success', data.message || 'Order created successfully!');
                orderForm.reset();
                // Reset to single product row
                productsContainer.innerHTML = '';
                productIndex = 0;
                addProductRow();
            } else {
                showMessage('error', data.message || 'An error occurred while creating the order.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('error', 'An unexpected error occurred. Please try again.');
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            submitText.classList.remove('hidden');
            submitLoading.classList.add('hidden');
        });
    });

    function showMessage(type, message) {
        const messageContainer = document.getElementById('message-container');
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');

        messageContainer.classList.remove('hidden');

        if (type === 'success') {
            successMessage.classList.remove('hidden');
            errorMessage.classList.add('hidden');
            document.getElementById('success-text').textContent = message;
        } else {
            errorMessage.classList.remove('hidden');
            successMessage.classList.add('hidden');
            document.getElementById('error-text').textContent = message;
        }

        // Auto-hide after 5 seconds
        setTimeout(() => {
            messageContainer.classList.add('hidden');
        }, 5000);
    }
});

// Global function as fallback
window.addProduct = function() {
    console.log('Global addProduct called');
    const event = new Event('DOMContentLoaded');
    if (typeof addProductRow === 'function') {
        addProductRow();
    } else {
        // Fallback manual creation
        addProductRowFallback();
    }
};

function addProductRowFallback() {
    const container = document.getElementById('products-container');
    const template = document.getElementById('product-row-template');

    if (container && template) {
        const clone = template.content.cloneNode(true);
        const tempDiv = document.createElement('div');
        tempDiv.appendChild(clone);

        let html = tempDiv.innerHTML;
        const index = container.children.length;
        html = html.replace(/INDEX/g, index);

        container.insertAdjacentHTML('beforeend', html);

        // Re-attach events to the new row
        const newRow = container.lastElementChild;
        if (newRow) {
            // Add basic event listeners
            const removeBtn = newRow.querySelector('.remove-product');
            if (removeBtn) {
                removeBtn.onclick = function() {
                    if (container.children.length > 1) {
                        newRow.remove();
                    } else {
                        alert('At least one product is required.');
                    }
                };
            }
        }
    }
}
</script>
@endpush

@push('styles')
<style>
    .product-row {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .remove-product:hover {
        transform: scale(1.05);
    }

    input:focus, select:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>
@endpush
</x-app-layout>


