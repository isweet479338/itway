<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $sale->sale_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
            .print-break {
                page-break-after: always;
            }
            .shadow {
                box-shadow: none !important;
            }
            .bg-gray-50 {
                background-color: #f9fafb !important;
            }
            .border {
                border: 1px solid #d1d5db !important;
            }
        }

        .invoice-container {
            max-width: 8.5in;
            margin: 0 auto;
            background: white;
        }

        .company-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .invoice-number {
            font-size: 2rem;
            font-weight: bold;
            color: #1f2937;
        }

        .amount-due {
            font-size: 2.5rem;
            font-weight: bold;
            color: #059669;
        }

        .table-header {
            background-color: #f3f4f6;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .line-item:nth-child(even) {
            background-color: #f9fafb;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 6rem;
            color: rgba(0, 0, 0, 0.05);
            z-index: -1;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Print Buttons (Hidden when printing) -->
    <div class="no-print fixed top-4 right-4 z-50 space-x-2">
        <button onclick="window.print()"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg transition duration-200">
            🖨️ Print Invoice
        </button>
        <button onclick="window.close()"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-lg transition duration-200">
            ❌ Close
        </button>
        <a href="{{ route('sales.show', $sale) }}"
           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg transition duration-200 inline-block">
            📋 View Details
        </a>
    </div>

    <!-- Watermark -->
    <div class="watermark no-print">INVOICE</div>

    <!-- Invoice Container -->
    <div class="invoice-container mx-auto my-8 shadow-2xl">
        <!-- Company Header -->
        <div class="company-header text-white p-8 rounded-t-lg">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Your Company Name</h1>
                    <p class="text-lg opacity-90">Professional Services & Solutions</p>
                </div>
                <div class="text-right">
                    <div class="bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                        <p class="text-sm opacity-80">Invoice</p>
                        <p class="invoice-number text-white">{{ $sale->sale_number }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Content -->
        <div class="bg-white p-8">
            <!-- Invoice Header Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Company Info -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3">From:</h3>
                    <div class="text-gray-600 space-y-1">
                        <p class="font-medium">Your Company Name</p>
                        <p>123 Business Street</p>
                        <p>City, State 12345</p>
                        <p>Phone: (555) 123-4567</p>
                        <p>Email: info@company.com</p>
                        <p>Website: www.company.com</p>
                    </div>
                </div>

                <!-- Customer Info -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3">Bill To:</h3>
                    <div class="text-gray-600 space-y-1">
                        <p class="font-medium text-gray-800">{{ $sale->customer->name }}</p>
                        <p>{{ $sale->customer->email }}</p>
                        @if($sale->customer->phone)
                            <p>{{ $sale->customer->phone }}</p>
                        @endif
                        @if($sale->customer->address)
                            <p>{{ $sale->customer->address }}</p>
                        @endif
                        @if($sale->customer->city || $sale->customer->state || $sale->customer->zip)
                            <p>
                                {{ $sale->customer->city }}{{ $sale->customer->city && ($sale->customer->state || $sale->customer->zip) ? ', ' : '' }}
                                {{ $sale->customer->state }} {{ $sale->customer->zip }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Invoice Details -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3">Invoice Details:</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Invoice Number:</span>
                            <span class="font-medium">{{ $sale->sale_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Invoice Date:</span>
                            <span class="font-medium">{{ $sale->date->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Due Date:</span>
                            <span class="font-medium">{{ $sale->date->addDays(30)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Terms:</span>
                            <span class="font-medium">Net 30</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Created By:</span>
                            <span class="font-medium">{{ $sale->by }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="mb-8">
                <h3 class="font-semibold text-gray-800 mb-4 text-lg">Invoice Items</h3>
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="table-header text-gray-700">
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Description</th>
                                <th class="px-4 py-3 text-center">Qty</th>
                                <th class="px-4 py-3 text-right">Unit Price</th>
                                <th class="px-4 py-3 text-right">Discount</th>
                                <th class="px-4 py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->saleItems as $index => $item)
                                <tr class="line-item border-t border-gray-200">
                                    <td class="px-4 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                                        @if($item->product->description)
                                            <div class="text-sm text-gray-500 mt-1">{{ $item->product->description }}</div>
                                        @endif
                                        @if($item->product->sku)
                                            <div class="text-xs text-gray-400 mt-1">SKU: {{ $item->product->sku }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center font-medium">{{ $item->quantity }}</td>
                                    <td class="px-4 py-4 text-right font-medium">${{ number_format($item->price, 2) }}</td>
                                    <td class="px-4 py-4 text-right">
                                        @if($item->discount > 0)
                                            <span class="text-red-600">-${{ number_format($item->discount, 2) }}</span>
                                        @else
                                            <span class="text-gray-400">$0.00</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right font-semibold">${{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totals Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Payment Info / Notes -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-3">Payment Information</h3>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm">
                        <p><strong>Bank Name:</strong> Your Bank Name</p>
                        <p><strong>Account Name:</strong> Your Company Name</p>
                        <p><strong>Account Number:</strong> 1234567890</p>
                        <p><strong>Routing Number:</strong> 987654321</p>
                        <p><strong>SWIFT Code:</strong> ABCD1234</p>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-800 mb-2">Notes & Terms</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p>• Payment is due within 30 days of invoice date</p>
                            <p>• Late payments may incur a 1.5% monthly service charge</p>
                            <p>• Please include invoice number with payment</p>
                            <p>• Thank you for your business!</p>
                        </div>
                    </div>
                </div>

                <!-- Invoice Totals -->
                <div>
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="font-semibold text-gray-800 mb-4">Invoice Summary</h3>

                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">${{ number_format($sale->subtotal, 2) }}</span>
                            </div>

                            @if($sale->discount > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Total Discount:</span>
                                    <span class="font-medium text-red-600">-${{ number_format($sale->discount, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax (10%):</span>
                                <span class="font-medium">${{ number_format($sale->tax, 2) }}</span>
                            </div>

                            <hr class="border-gray-300">

                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-800">Total Amount:</span>
                                <span class="amount-due">${{ number_format($sale->total, 2) }}</span>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="mt-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                💰 Payment Pending
                            </span>
                        </div>
                    </div>

                    <!-- QR Code Section (Optional) -->
                    <div class="mt-6 text-center">
                        <div class="bg-white border-2 border-gray-200 p-4 rounded-lg inline-block">
                            <div class="w-24 h-24 bg-gray-100 rounded flex items-center justify-center mx-auto mb-2">
                                <span class="text-gray-400 text-xs">QR Code</span>
                            </div>
                            <p class="text-xs text-gray-500">Scan to pay online</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-12 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Questions?</h4>
                        <p class="text-sm text-gray-600">
                            Contact us at <a href="mailto:billing@company.com" class="text-blue-600 hover:underline">billing@company.com</a>
                            or call <a href="tel:+15551234567" class="text-blue-600 hover:underline">(555) 123-4567</a>
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">
                            Generated on {{ now()->format('M d, Y \a\t h:i A') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            Invoice ID: {{ $sale->id }} | Page 1 of 1
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Strip -->
        <div class="company-header text-white p-4 rounded-b-lg text-center">
            <p class="text-sm opacity-90">
                Thank you for choosing our services! We appreciate your business.
            </p>
        </div>
    </div>

    <!-- Print Styles -->
    <script>
        // Auto-focus print dialog when opened in new window
        window.addEventListener('load', function() {
            if (window.location.search.includes('print=1')) {
                setTimeout(() => window.print(), 500);
            }
        });

        // Print function with custom options
        function printInvoice() {
            const printWindow = window.open(window.location.href + '?print=1', '_blank');
            printWindow.addEventListener('load', function() {
                printWindow.print();
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+P or Cmd+P for print
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
            // Escape to close
            if (e.key === 'Escape') {
                window.close();
            }
        });
    </script>
</body>
</html>
