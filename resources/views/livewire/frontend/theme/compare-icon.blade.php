<li wire:ignore.self>
    <a href="{{ route('compare') }}" wire:navigate>
        <b>
            <img src="{{ asset('assets/frontend/images/compare_black.svg') }}" alt="Compare" class="img-fluid">
        </b>
        @if($count > 0)
        <span>{{ $count }}</span>
        @endif
    </a>
</li>