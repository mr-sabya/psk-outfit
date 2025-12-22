<?php

namespace App\Livewire\Frontend\Components;

use App\Livewire\Frontend\Traits\CartTrait;
use App\Livewire\Frontend\Traits\WishlistTrait;
use Livewire\Component;
use App\Models\Product as ProductModel; // Alias to avoid conflict with Component name
use Illuminate\Support\Facades\Session;

class Product extends Component
{
    use CartTrait, WishlistTrait;
    public ProductModel $product;
    public $isColor = true;

    // Listen for changes so the heart icon updates instantly
    protected $listeners = ['wishlistUpdated' => '$refresh'];

    /**
     * Mount the component.
     * 
     * @param int|ProductModel $product You can pass the ID or the Model instance
     * @param bool $isColor
     */
    public function mount($product, $isColor = true)
    {
        // If an integer ID is passed, fetch the model. 
        // If the Model is passed directly (e.g. in a loop), use it.
        $this->product = $product instanceof ProductModel
            ? $product
            : ProductModel::with(['reviews', 'variants.attributeValues'])->findOrFail($product);

        $this->isColor = $isColor;
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

    public function addToCart()
    {
        // For simple cards, we usually add 1 qty with no variants
        $this->handleAddToCart($this->product->id);
    }

    public function render()
    {
        return view('livewire.frontend.components.product');
    }
}
