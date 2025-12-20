<div>
    @if($showModal)
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;" wire:click.self="$set('showModal', false)">
        <div class="modal-content bg-white p-4 shadow-lg" style="max-width: 400px; border-radius: 8px;">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="mb-0">Add to Wishlist</h5>
                <button class="btn-close" wire:click="$set('showModal', false)"></button>
            </div>
            <div class="list-group">
                @foreach($wishlists as $list)
                <button wire:click="selectList({{ $list->id }})" class="list-group-item list-group-item-action">
                    {{ $list->name }}
                </button>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>