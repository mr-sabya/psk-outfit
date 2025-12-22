<?php

namespace App\Livewire\Frontend\Product;

use App\Livewire\Frontend\Traits\CartTrait;
use App\Livewire\Frontend\Traits\WishlistTrait;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Show extends Component
{
    use CartTrait, WishlistTrait;

    public $product;
    public $slug;

    // Stores grouped attributes for the UI
    public $groupedAttributes = [];

    // Stores the user's selection: [AttributeID => ValueID]
    public $selectedAttributes = [];

    // The specific variant object found based on selection
    public $selectedVariant = null;

    // Quantity input
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
            'categories', // Added for efficiency
            'tags',       // Added for efficiency
            'specifications.key' // <--- ADD THIS LINE
        ])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        if ($this->product->isVariable()) {
            $this->groupVariantAttributes();

            // Optional: Auto-select the first active variant
            $firstVariant = $this->product->variants->where('is_active', true)->first();
            if ($firstVariant) {
                foreach ($firstVariant->attributeValues as $val) {
                    $this->selectedAttributes[$val->attribute_id] = $val->id;
                }
                $this->selectedVariant = $firstVariant;
            }
        }
    }

    /**
     * Handle user clicking an attribute option
     */
    public function selectAttribute($attributeId, $valueId)
    {
        // 1. Update selection
        $this->selectedAttributes[$attributeId] = $valueId;

        // 2. Try to find a matching variant
        $this->findMatchingVariant();
    }

    public function findMatchingVariant()
    {
        // We need to find a variant that has ALL the selected attribute values
        $this->selectedVariant = $this->product->variants->first(function ($variant) {

            if (!$variant->is_active) return false;

            // Get IDs of all attribute values attached to this variant
            $variantValueIds = $variant->attributeValues->pluck('id')->toArray();

            // Check if our selected values are a subset of the variant's values
            // We use array_intersect to see if all selected IDs exist in the variant
            $intersection = array_intersect($this->selectedAttributes, $variantValueIds);

            // It's a match if the count of intersection equals the count of selection
            // AND the selection count matches the number of attributes required
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
        if ($this->quantity > 1) {
            $this->quantity--;
        }
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
        // 1. Validate variants if required
        if ($this->product->isVariable() && count($this->selectedAttributes) < count($this->groupedAttributes)) {
            session()->flash('error', 'Please select all options.');
            return;
        }

        // 2. Map IDs to readable names for the cart
        $options = [];
        foreach ($this->selectedAttributes as $attrId => $valId) {
            $val = AttributeValue::find($valId);
            $attr = Attribute::find($attrId);
            $options[$attr->name] = $val->value;
        }

        $this->handleAddToCart($this->product->id, $this->quantity, $options);
    }

    public function addToCompare($productId)
    {
        $compare = Session::get('compare', []);

        if (count($compare) >= 5) {
            session()->flash('error', 'You can only compare up to 5 products.');
            return;
        }

        if (!in_array($productId, $compare)) {
            $compare[] = $productId;
            Session::put('compare', $compare);
            // THIS LINE triggers the CompareIcon component to refresh
            $this->dispatch('compareUpdated');
            session()->flash('success', 'Product added to compare list.');
        }
    }

    public function render()
    {
        return view('livewire.frontend.product.show');
    }
}
