<section class="trending_product_2 mt_90">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="section_heading_2 section_heading mb_15">
                    <h3><span>Trending</span> Products</h3>
                </div>
            </div>
        </div>
        <div class="row wow fadeInUp">
            <div class="col-12">
                <div class="product_tabs">

                    @forelse($tabs as $tab)
                    {{--
                           data-pws-tab: Unique ID for the tab content
                           data-pws-tab-name: The text displayed on the tab button
                        --}}
                    <div data-pws-tab="{{ $tab['id'] }}" data-pws-tab-name="{{ $tab['name'] }}">
                        <div class="row">
                            @forelse($tab['products'] as $product)
                            <div class="col-xl-1-5 col-6 col-md-4 col-xl-3">
                                {{-- Pass the product model to the child component --}}
                                <livewire:frontend.components.product
                                    :product="$product"
                                    :wire:key="'trend-'.$tab['id'].'-'.$product->id" />
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <p class="text-muted">Coming soon...</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-light text-center">
                            No trending categories found. Please mark categories as 'Show on Homepage' in admin.
                        </div>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</section>