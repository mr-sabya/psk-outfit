<section class="related_products mt_90 mb_70 wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="section_heading_2 section_heading">
                    <h3><span>Related</span> Products</h3>
                </div>
            </div>
        </div>

        {{-- Slider Container --}}
        {{-- Note: Ensure your JS slider initializes on this class 'flash_sell_2_slider' --}}
        <div class="row mt_25 flash_sell_2_slider">
            @forelse($relatedProducts as $product)
            {{-- The col-xl-1-5 class is likely used by your CSS/JS for layout --}}
            <div class="col-xl-1-5">
                {{-- Pass the product object to your reusable Product Card component --}}
                <livewire:frontend.components.product
                    :product="$product"
                    :wire:key="'related-'.$product->id" />
            </div>
            @empty
            <div class="col-12">
                <p class="text-muted">No related products found.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>