<li>
    <a href="#" wire:navigate>
        <b>
            <img src="{{ url('assets/frontend/images/love_black.svg') }}" alt="Wishlist" class="img-fluid">
        </b>
        {{-- Only show the badge if count is greater than 0 (optional) --}}
        @if($count > 0)
        <span>{{ $count }}</span>
        @else
        <span>0</span>
        @endif
    </a>
</li>