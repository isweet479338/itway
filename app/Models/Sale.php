<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'date',
        'subtotal',
        'discount',
        'tax',
        'total',
        'by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the customer that owns the sale.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the sale items for the sale.
     */
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Get the products through sale items.
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, SaleItem::class, 'sale_id', 'id', 'id', 'product_id');
    }

    /**
     * Scope a query to only include sales from a specific date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include sales for a specific customer.
     */
    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    /**
     * Scope a query to only include sales created by a specific user.
     */
    public function scopeCreatedBy($query, $user)
    {
        return $query->where('by', $user);
    }

    /**
     * Get the formatted total amount.
     */
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total, 2);
    }

    /**
     * Get the formatted subtotal amount.
     */
    public function getFormattedSubtotalAttribute()
    {
        return '$' . number_format($this->subtotal, 2);
    }

    /**
     * Get the formatted discount amount.
     */
    public function getFormattedDiscountAttribute()
    {
        return '$' . number_format($this->discount, 2);
    }

    /**
     * Get the formatted tax amount.
     */
    public function getFormattedTaxAttribute()
    {
        return '$' . number_format($this->tax, 2);
    }

    /**
     * Get the sale number (formatted ID).
     */
    public function getSaleNumberAttribute()
    {
        return 'SALE-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Calculate and update totals based on sale items.
     */
    public function calculateTotals()
    {
        $this->subtotal = $this->saleItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $this->discount = $this->saleItems->sum('discount');
        $this->tax = ($this->subtotal - $this->discount) * 0.10; // 10% tax
        $this->total = $this->subtotal - $this->discount + $this->tax;

        $this->save();
    }

    /**
     * Get the total quantity of items in this sale.
     */
    public function getTotalQuantityAttribute()
    {
        return $this->saleItems->sum('quantity');
    }

    /**
     * Check if sale has any discounts.
     */
    public function hasDiscount()
    {
        return $this->discount > 0;
    }

    /**
     * Get the discount percentage of the sale.
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->subtotal > 0) {
            return round(($this->discount / $this->subtotal) * 100, 2);
        }
        return 0;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-calculate totals when creating/updating
        static::saving(function ($sale) {
            // You can add any business logic here before saving
        });
    }
}
