<section class="new_arrival_2 mt_95">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-sm-9">
                <div class="section_heading_2 section_heading">
                    <h3>Our <span>New</span> Arrival Products</h3>
                </div>
            </div>
            <div class="col-xl-6 col-sm-3">
                <div class="view_all_btn_area">
                    {{-- Adjust route name as per your web.php --}}
                    <a class="view_all_btn" href="#">View all</a>
                </div>
            </div>
        </div>

        <div class="row mt_15">
            @forelse($products as $product)
            {{--
                    Preserving the 'col-xl-1-5' class from your template 
                    which likely creates a 5-column layout 
                --}}
            <div class="col-xl-1-5 col-6 col-md-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                <livewire:frontend.components.product
                    :product="$product"
                    :wire:key="'new-arrival-'.$product->id" />
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-light text-center" role="alert">
                    No new arrivals at the moment. Check back soon!
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>