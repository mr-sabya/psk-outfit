<section class="brand_2 mt_85">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-sm-9">
                <div class="section_heading_2 section_heading">
                    <h3>Our Top <span>Brands</span></h3>
                </div>
            </div>
            <div class="col-xl-6 col-sm-3">
                <div class="view_all_btn_area">
                    {{-- Link to a page listing all brands --}}
                    <a class="view_all_btn" href="#">View all</a>
                </div>
            </div>
        </div>

        <div class="row mt_40">
            <div class="col-12">
                <ul>
                    @forelse($brands as $brand)
                    <li class="wow fadeInUp">
                        {{-- Link to Shop filtered by this brand --}}
                        <a href="#" title="{{ $brand->name }}">

                            {{--
                                    Using the accessor getLogoUrlAttribute().
                                    Added a fallback image in case logo is missing.
                                --}}
                            <img src="{{ $brand->logo_url ?? asset('assets/frontend/images/brand1.png') }}"
                                alt="{{ $brand->name }}"
                                class="img-fluid">
                        </a>
                    </li>
                    @empty
                    <li class="wow fadeInUp">
                        <span>No brands found.</span>
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</section>