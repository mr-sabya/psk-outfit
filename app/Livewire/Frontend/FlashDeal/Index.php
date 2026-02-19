<?php

namespace App\Livewire\Frontend\FlashDeal;

use App\Models\Deal;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        // Fetch all active deals that haven't expired yet
        $deals = Deal::active()
            ->with(['products' => function ($query) {
                $query->active()
                    ->with(['reviews', 'variants.attributeValues']);
            }])
            ->orderBy('display_order', 'asc')
            ->paginate(5); // Adjust pagination count as needed

        return view('livewire.frontend.flash-deal.index', [
            'deals' => $deals
        ]);
    }
}
