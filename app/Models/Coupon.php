<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CouponType;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'min_spend',
        'max_discount_amount',
        'usage_limit_per_coupon',
        'usage_count',
        'usage_limit_per_user',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'type' => CouponType::class,
        'value' => 'decimal:2',
        'min_spend' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'usage_limit_per_coupon' => 'integer',
        'usage_count' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Restrictions
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit_per_coupon')
                    ->orWhereColumn('usage_count', '<', 'usage_limit_per_coupon');
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Core Logic: Advanced Discount Calculation
    |--------------------------------------------------------------------------
    */

    /**
     * Checks basic validity (Status, Dates, Total Usage).
     */
    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->valid_from && $this->valid_from->isFuture()) return false;
        if ($this->valid_until && $this->valid_until->isPast()) return false;
        if ($this->usage_limit_per_coupon && $this->usage_count >= $this->usage_limit_per_coupon) return false;

        return true;
    }

    /**
     * Calculates the discount based on Cart Items and Restrictions.
     * Used in both Cart and Checkout.
     */
    public function calculateDiscountForCart($cartItems, $currentUserId = null): float
    {
        if (!$this->isValid()) return 0.00;

        // 1. Check User Restrictions
        if ($this->users()->exists()) {
            if (!$currentUserId || !$this->users()->where('users.id', $currentUserId)->exists()) {
                return 0.00; // User is not in the allowed list
            }
        }

        $eligibleAmount = 0;

        // Get restricted IDs once to avoid N+1 queries inside the loop
        $restrictedProductIds = $this->products()->pluck('products.id')->toArray();
        $restrictedCategoryIds = $this->categories()->pluck('categories.id')->toArray();

        $hasProductRestrictions = !empty($restrictedProductIds);
        $hasCategoryRestrictions = !empty($restrictedCategoryIds);

        // 2. Filter Cart Items for Eligibility
        foreach ($cartItems as $item) {
            $isItemEligible = false;

            // If no product/category restrictions, everything is eligible
            if (!$hasProductRestrictions && !$hasCategoryRestrictions) {
                $isItemEligible = true;
            } else {
                // Check if specific product is allowed
                if ($hasProductRestrictions && in_array($item->product_id, $restrictedProductIds)) {
                    $isItemEligible = true;
                }

                // Check if product belongs to an allowed category
                if (!$isItemEligible && $hasCategoryRestrictions) {
                    $itemCategoryIds = $item->product->categories->pluck('id')->toArray();
                    if (array_intersect($itemCategoryIds, $restrictedCategoryIds)) {
                        $isItemEligible = true;
                    }
                }
            }

            if ($isItemEligible) {
                $unitPrice = $item->price ?? $item->product->effective_price;
                $eligibleAmount += ($unitPrice * $item->quantity);
            }
        }

        if ($eligibleAmount <= 0) return 0.00;

        // 3. Apply Discount Logic
        $discountValue = 0;

        if ($this->type === CouponType::Percentage) {
            $discountValue = ($eligibleAmount * $this->value) / 100;

            // Apply cap if max_discount_amount is set
            if ($this->max_discount_amount && $discountValue > $this->max_discount_amount) {
                $discountValue = $this->max_discount_amount;
            }
        } elseif ($this->type === CouponType::FixedAmount) {
            // Fixed discount cannot exceed the cost of the eligible items
            $discountValue = min($this->value, $eligibleAmount);
        }

        return (float) round($discountValue, 2);
    }
}
