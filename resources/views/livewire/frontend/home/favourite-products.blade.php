<section class="favourite_product_2 mt_100">
    <div class="container">
        <div class="row">
            <!-- Left Banner Area -->
            <div class="col-xl-3 col-lg-4 wow fadeInLeft">
                <div class="bundle_product_banner">
                    <img src="{{ url('assets/frontend/images/favourite_pro_2_banner_img.png') }}" alt="bundle" class="img-fluid">
                    <div class="text">
                        <h4>This Spring On Apple <span>Up To 50K Off</span></h4>
                        <p>Limited Time Offer</p>
                        <a class="common_btn" href="#">
                            shop now
                            <i class="fas fa-long-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Product Slider Area -->
            <div class="col-xl-9 col-lg-8">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="section_heading_2 section_heading">
                            <h3>Our <span>Favorite</span> Style Product</h3>
                        </div>
                    </div>

                    {{--
                        wire:ignore is crucial here because this div is initialized 
                        by a JS Slider (likely Slick or Owl). 
                    --}}
                    <div class="row mt_40 favourite_product_2_slider" wire:ignore>
                        @foreach($products as $product)
                        <div class="col-xl-3 wow fadeInUp">
                            <livewire:frontend.components.product
                                :product="$product"
                                :isColor="false"
                                :wire:key="'fav-prod-'.$product->id" />
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>