<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sale_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'discount',
        'total',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Get the sale that owns the sale item.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Get the product that owns the sale item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the formatted price.
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Get the formatted discount.
     */
    public function getFormattedDiscountAttribute()
    {
        return '$' . number_format($this->discount, 2);
    }

    /**
     * Get the formatted total.
     */
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total, 2);
    }

    /**
     * Get the line total before discount.
     */
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    /**
     * Get the formatted subtotal.
     */
    public function getFormattedSubtotalAttribute()
    {
        return '$' . number_format($this->subtotal, 2);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-calculate total when creating/updating
        static::saving(function ($saleItem) {
            $saleItem->total = ($saleItem->quantity * $saleItem->price) - $saleItem->discount;
        });

        // Update parent sale totals when sale item changes
        static::saved(function ($saleItem) {
            $saleItem->sale->calculateTotals();
        });

        static::deleted(function ($saleItem) {
            $saleItem->sale->calculateTotals();
        });
    }
}
