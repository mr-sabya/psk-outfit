<?php

namespace App\Livewire\Frontend\Product;

use App\Livewire\Frontend\Traits\CartTrait;
use App\Livewire\Frontend\Traits\WishlistTrait;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Show extends Component
{
    use CartTrait, WishlistTrait;

    public $product;
    public $slug;
    public $groupedAttributes = [];
    public $selectedAttributes = [];
    public $selectedVariant = null;
    public $quantity = 1;

    protected $listeners = ['wishlistUpdated' => '$refresh'];

    public function mount($slug)
    {
        $this->slug = $slug;

        $this->product = Product::with([
            'images',
            'vendor',
            'reviews.user',
            'variants.attributeValues.attribute',
            'variants.images',
            'categories',
            'tags',
            'specifications.key',
            'bundleProducts' // <--- Eager load bundles
        ])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        if ($this->product->isVariable()) {
            $this->groupVariantAttributes();

            $firstVariant = $this->product->variants->where('is_active', true)->first();
            if ($firstVariant) {
                foreach ($firstVariant->attributeValues as $val) {
                    $this->selectedAttributes[$val->attribute_id] = $val->id;
                }
                $this->selectedVariant = $firstVariant;
            }
        }
    }

    // --- NEW: Add Entire Bundle to Cart ---
    // --- Inside Show.php ---

    public function buyBundleNow()
    {
        if (!auth()->check()) return $this->redirect(route('login'), navigate: true);

        // Empty cart for "Buy Now" behavior
        CartItem::where('user_id', auth()->id())->delete();

        // 1. Add Main Product (Itself is the main)
        $this->handleAddToCart($this->product->id, 1, [], $this->product->effective_price, true, $this->product->id);

        // 2. Add Bundled Products (Link them to this main product)
        foreach ($this->product->bundleProducts as $bundleItem) {
            $this->handleAddToCart(
                $bundleItem->id,
                1,
                [],
                $bundleItem->pivot->special_price,
                true,
                $this->product->id
            );
        }

        return $this->redirect(route('checkout'), navigate: true);
    }

    public function selectAttribute($attributeId, $valueId)
    {
        $this->selectedAttributes[$attributeId] = $valueId;
        $this->findMatchingVariant();
    }

    public function findMatchingVariant()
    {
        $this->selectedVariant = $this->product->variants->first(function ($variant) {
            if (!$variant->is_active) return false;
            $variantValueIds = $variant->attributeValues->pluck('id')->toArray();
            $intersection = array_intersect($this->selectedAttributes, $variantValueIds);
            return count($intersection) === count($this->selectedAttributes)
                && count($intersection) === count($this->groupedAttributes);
        });
    }

    public function incrementQty()
    {
        $this->quantity++;
    }
    public function decrementQty()
    {
        if ($this->quantity > 1) $this->quantity--;
    }

    public function groupVariantAttributes()
    {
        $groups = [];
        foreach ($this->product->variants as $variant) {
            if (!$variant->is_active) continue;
            foreach ($variant->attributeValues as $value) {
                $attrId = $value->attribute->id;
                if (!isset($groups[$attrId])) {
                    $groups[$attrId] = [
                        'id' => $attrId,
                        'name' => $value->attribute->name,
                        'display_type' => $value->attribute->display_type,
                        'values' => collect()
                    ];
                }
                if (!$groups[$attrId]['values']->contains('id', $value->id)) {
                    $groups[$attrId]['values']->push($value);
                }
            }
        }
        $this->groupedAttributes = $groups;
    }

    public function addToCart()
    {
        if ($this->product->isVariable() && count($this->selectedAttributes) < count($this->groupedAttributes)) {
            session()->flash('error', 'Please select all options.');
            return;
        }

        $options = [];
        foreach ($this->selectedAttributes as $attrId => $valId) {
            $val = AttributeValue::find($valId);
            $attr = Attribute::find($attrId);
            $options[$attr->name] = $val->value;
        }

        $this->handleAddToCart($this->product->id, $this->quantity, $options);
    }

    public function buyNow()
    {
        if ($this->product->isVariable() && count($this->selectedAttributes) < count($this->groupedAttributes)) {
            session()->flash('error', 'Please select all options.');
            return;
        }
        $this->addToCart();
        return $this->redirect(route('checkout'), navigate: true);
    }

    public function addToCompare($productId)
    {
        $compare = Session::get('compare', []);
        if (count($compare) >= 5) {
            session()->flash('error', 'Limit reached.');
            return;
        }
        if (!in_array($productId, $compare)) {
            $compare[] = $productId;
            Session::put('compare', $compare);
            $this->dispatch('compareUpdated');
        }
    }

    public function render()
    {
        return view('livewire.frontend.product.show');
    }
}
