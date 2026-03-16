<?php

namespace App\Livewire\Backend\Product;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VariantsManager extends Component
{
    public Product $product;
    public $allAttributes;
    public $selectedValues = [];
    public $variants = [];

    public function mount(Product $product)
    {
        $this->product = $product;
        // Get attributes with their values
        $this->allAttributes = Attribute::with('values')->where('is_active', true)->get();
        $this->loadVariants();
    }

    public function loadVariants()
    {
        $this->variants = [];
        $existing = $this->product->variants()->with('attributeValues')->get();

        foreach ($existing as $variant) {
            $this->variants[] = [
                'id' => $variant->id,
                'name' => $variant->attributeValues->pluck('value')->implode(' / '),
                'value_ids' => $variant->attributeValues->pluck('id')->toArray(),
                'sku' => $variant->sku,
                'price' => $variant->price,
                'quantity' => $variant->quantity,
                'is_active' => (bool)$variant->is_active,
                'is_saved' => true
            ];
        }
    }

    public function generateVariants()
    {
        $groups = [];
        foreach ($this->selectedValues as $attrId => $values) {
            $activeInGroup = array_filter($values);
            if (!empty($activeInGroup)) {
                $groups[] = array_keys($activeInGroup);
            }
        }

        if (empty($groups)) {
            session()->flash('error', 'Please select at least one value first.');
            return;
        }

        $combinations = [[]];
        foreach ($groups as $values) {
            $temp = [];
            foreach ($combinations as $combo) {
                foreach ($values as $valueId) {
                    $temp[] = array_merge($combo, [$valueId]);
                }
            }
            $combinations = $temp;
        }

        foreach ($combinations as $combo) {
            if ($this->isComboInList($combo)) continue;

            $names = AttributeValue::whereIn('id', $combo)->pluck('value')->implode(' / ');

            $this->variants[] = [
                'id' => null,
                'name' => $names,
                'value_ids' => $combo,
                'sku' => $this->product->sku . '-' . strtoupper(Str::random(4)),
                'price' => $this->product->price,
                'quantity' => 0,
                'is_active' => true,
                'is_saved' => false
            ];
        }
    }

    private function isComboInList($combo)
    {
        foreach ($this->variants as $v) {
            if (count(array_diff($v['value_ids'], $combo)) === 0 && count($v['value_ids']) === count($combo)) {
                return true;
            }
        }
        return false;
    }

    public function deleteVariant($index)
    {
        $variantData = $this->variants[$index];

        if (isset($variantData['id']) && $variantData['id']) {
            // PERMANENT DELETE CHECK:
            // Check if this variant exists in order_items table
            $hasOrders = DB::table('order_items')->where('product_variant_id', $variantData['id'])->exists();

            if ($hasOrders) {
                session()->flash('error', "CRITICAL: Cannot delete '{$variantData['name']}'. It is linked to existing orders. Please DEACTIVATE it instead.");
                return;
            }

            ProductVariant::find($variantData['id'])->delete();
        }

        unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
        session()->flash('message', 'Variant removed permanently.');
    }

    public function save()
    {
        $this->validate([
            'variants.*.sku' => 'required',
            'variants.*.price' => 'required|numeric',
        ]);

        DB::transaction(function () {
            foreach ($this->variants as $v) {
                $variant = ProductVariant::updateOrCreate(
                    ['id' => $v['id']],
                    [
                        'product_id' => $this->product->id,
                        'sku' => $v['sku'],
                        'price' => $v['price'],
                        'quantity' => $v['quantity'],
                        'is_active' => $v['is_active'],
                    ]
                );
                $variant->attributeValues()->sync($v['value_ids']);
            }
        });

        $this->loadVariants();
        session()->flash('message', 'All variants saved successfully.');
    }

    public function render()
    {
        return view('livewire.backend.product.variants-manager');
    }
}
