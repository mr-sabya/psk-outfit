<section class="features mt_20">
    <div class="container">
        <div class="row">
            @forelse ($features as $feature)
            <div class="col-xl-3 col-md-6 wow fadeInUp" wire:key="feature-{{ $feature->id }}">
                <div class="features_item purple">
                    <div class="icon">
                        {{--
                                Logic to handle image paths:
                                1. If it starts with 'assets', it's a seeded static image.
                                2. Otherwise, it's an uploaded file in the 'storage' folder.
                            --}}
                        @php
                        $iconUrl = Str::startsWith($feature->icon, 'assets')
                        ? asset($feature->icon)
                        : asset('storage/' . $feature->icon);
                        @endphp

                        <img src="{{ $iconUrl }}" alt="{{ $feature->title }}">
                    </div>
                    <div class="text">
                        <h3>{{ $feature->title }}</h3>
                        @if($feature->subtitle)
                        <p>{{ $feature->subtitle }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            {{-- Optional: Fallback content if no features are active --}}
            <div class="col-12 text-center py-4">
                <p class="text-muted">No features currently listed.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>