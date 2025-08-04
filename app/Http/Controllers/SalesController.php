<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    /**
     * Display a listing of sales.
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer'])
            ->latest('date');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('id', 'like', "%{$search}%");
        }

        // Date filter
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Customer filter
        if ($request->has('customer_id') && !empty($request->customer_id)) {
            $query->where('customer_id', $request->customer_id);
        }

        $sales = $query->paginate(15);
        $customers = Customer::orderBy('name')->get();

        return view('sales.index', compact('sales', 'customers'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('sales.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created sale in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = 0;
            $totalDiscount = 0;

            foreach ($request->products as $product) {
                $quantity = (float) $product['quantity'];
                $price = (float) $product['price'];
                $discount = (float) ($product['discount'] ?? 0);

                $subtotal += $quantity * $price;
                $totalDiscount += $discount;
            }

            $tax = ($subtotal - $totalDiscount) * 0.10; // 10% tax
            $total = $subtotal - $totalDiscount + $tax;

            // Create sale
            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'date' => $request->order_date,
                'subtotal' => $subtotal,
                'discount' => $totalDiscount,
                'tax' => $tax,
                'total' => $total,
                'by' => Auth::check() ? Auth::user()->name : 'System',
            ]);

            // Create sale items (assuming you have a sale_items table)
            foreach ($request->products as $product) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'discount' => $product['discount'] ?? 0,
                    'total' => ($product['quantity'] * $product['price']) - ($product['discount'] ?? 0),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale created successfully!',
                'sale_id' => $sale->id,
                'redirect' => route('sales.show', $sale->id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create sale: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified sale.
     */
    public function show(Sale $sale)
    {
        $sale->load(['customer', 'saleItems.product']);

        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified sale.
     */
    public function edit(Sale $sale)
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $sale->load(['customer', 'saleItems.product']);

        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    /**
     * Update the specified sale in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = 0;
            $totalDiscount = 0;

            foreach ($request->products as $product) {
                $quantity = (float) $product['quantity'];
                $price = (float) $product['price'];
                $discount = (float) ($product['discount'] ?? 0);

                $subtotal += $quantity * $price;
                $totalDiscount += $discount;
            }

            $tax = ($subtotal - $totalDiscount) * 0.10; // 10% tax
            $total = $subtotal - $totalDiscount + $tax;

            // Update sale
            $sale->update([
                'customer_id' => $request->customer_id,
                'date' => $request->order_date,
                'subtotal' => $subtotal,
                'discount' => $totalDiscount,
                'tax' => $tax,
                'total' => $total,
            ]);

            // Delete existing sale items and create new ones
            $sale->saleItems()->delete();

            foreach ($request->products as $product) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'discount' => $product['discount'] ?? 0,
                    'total' => ($product['quantity'] * $product['price']) - ($product['discount'] ?? 0),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale updated successfully!',
                'redirect' => route('sales.show', $sale->id)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update sale: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified sale from storage (soft delete).
     */
    public function destroy(Sale $sale)
    {
        try {
            $sale->delete(); // This will soft delete if using SoftDeletes trait

            return response()->json([
                'success' => true,
                'message' => 'Sale deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete sale: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show sales statistics/dashboard.
     */
    public function dashboard(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        // Basic stats
        $totalSales = Sale::whereBetween('date', [$dateFrom, $dateTo])->sum('total');
        $totalOrders = Sale::whereBetween('date', [$dateFrom, $dateTo])->count();
        $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        // Top customers
        $topCustomers = Sale::select('customer_id', DB::raw('SUM(total) as total_spent'))
            ->with('customer')
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->groupBy('customer_id')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        // Sales by date
        $salesByDate = Sale::select(
            DB::raw('DATE(date) as sale_date'),
            DB::raw('SUM(total) as daily_total'),
            DB::raw('COUNT(*) as daily_count')
        )
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        // Recent sales
        $recentSales = Sale::with(['customer'])
            ->latest('created_at')
            ->limit(10)
            ->get();

        return view('sales.dashboard', compact(
            'totalSales',
            'totalOrders',
            'avgOrderValue',
            'topCustomers',
            'salesByDate',
            'recentSales',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Generate sale report.
     */
    public function report(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));
        $customerId = $request->get('customer_id');

        $query = Sale::with(['customer', 'saleItems.product'])
            ->whereBetween('date', [$dateFrom, $dateTo]);

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        $sales = $query->orderBy('date', 'desc')->get();
        $customers = Customer::orderBy('name')->get();

        // Summary calculations
        $summary = [
            'total_sales' => $sales->sum('total'),
            'total_orders' => $sales->count(),
            'total_discount' => $sales->sum('discount'),
            'total_tax' => $sales->sum('tax'),
            'avg_order_value' => $sales->count() > 0 ? $sales->sum('total') / $sales->count() : 0,
        ];

        return view('sales.report', compact('sales', 'customers', 'summary', 'dateFrom', 'dateTo', 'customerId'));
    }

    /**
     * Print sale invoice.
     */
    public function printInvoice(Sale $sale)
    {
        $sale->load(['customer', 'saleItems.product']);

        return view('sales.invoice', compact('sale'));
    }
}

