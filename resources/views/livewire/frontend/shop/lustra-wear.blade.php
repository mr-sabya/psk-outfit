<section class="lustrai_collection_page mt_50 mb_100">
    <div class="container">
        <!-- CATEGORY HEADER / LOGO SECTION -->
        <div class="row justify-content-center mb_50">
            <div class="col-md-6 text-center">
                <div class="category_branding d-flex flex-column align-items-center">
                    <div style="width: 250px;">
                        @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}"
                            alt="{{ $category->name }}"
                            class="mb-3">
                    </div>
                    @endif
                    <h1 class="fw-bold text-uppercase" style="letter-spacing: 2px;">{{ $category->name }}</h1>
                    <div class="category_description mt-2 text-muted">
                        {!! $category->description !!}
                    </div>
                    <!-- facebook page link -->
                    <a href="https://www.facebook.com/share/17oQYcdCDS/?mibextid=wwXIfr" target="_blank" class="mt-3">
                        <i class="fab fa-facebook fa-2x" style="color: #3b5998;"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- TOOLBAR -->
        <div class="product_page_top border-top pt-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} pieces</p>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end gap-3 mt-3 mt-md-0">
                        <select class="form-select w-auto" wire:model.live="sortBy">
                            <option value="new">Latest Collection</option>
                            <option value="low_high">Price: Low to High</option>
                            <option value="high_low">Price: High to Low</option>
                        </select>
                        <select class="form-select w-auto" wire:model.live="perPage">
                            <option value="12">Show 12</option>
                            <option value="24">Show 24</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- PRODUCT GRID -->
        <div class="row mt_30">
            @forelse($products as $product)
            <div class="col-xxl-3 col-6 col-md-4 col-lg-6 col-xl-4 wow fadeInUp">
                <livewire:frontend.components.product
                    :product="$product"
                    :wire:key="'lustrai-'.$product->id" />
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">Currently, no products are available in this collection.</h4>
            </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="row mt_50">
            <div class="col-12 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>


    <style>
        .lustrai_collection_page {
            background-color: #fff;
        }

        .category_branding h1 {
            font-size: 2.5rem;
            color: #1a1a1a;
        }

        .form-select {
            border-radius: 0;
            border: 1px solid #e5e5e5;
            font-size: 14px;
            padding: 10px 30px 10px 15px;
        }

        .form-select:focus {
            border-color: #000;
            box-shadow: none;
        }

        /* Smooth transition for Livewire updates */
        .row {
            transition: opacity 0.3s ease;
        }

        div[wire\:loading] {
            opacity: 0.5;
        }
    </style>

</section>