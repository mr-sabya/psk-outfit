<?php

namespace App\Livewire\Frontend\Components;

use App\Livewire\Frontend\Traits\CartTrait;
use Livewire\Component;
use App\Models\Product as ProductModel; // Alias to avoid conflict with Component name

class Product extends Component
{
    use CartTrait;
    public ProductModel $product;
    public $isColor = true;

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