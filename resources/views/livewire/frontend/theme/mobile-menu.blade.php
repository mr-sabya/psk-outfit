<div class="mobile_menu_area">
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
                class="fal fa-times"></i></button>
        <div class="offcanvas-body">

            <ul class="mobile_currency">
                <li>
                    <select class="select_js language">
                        <option>English</option>
                        <option>Arabic</option>
                        <option>Hindi</option>
                        <option>Chinese</option>
                    </select>
                </li>
                <li>
                    <select class="select_js">
                        <option>$USD</option>
                        <option>€EUR</option>
                        <option>¥JPY</option>
                        <option>£GBP</option>
                        <option>₹INR</option>
                    </select>
                </li>
            </ul>

            <ul class="mobile_menu_header d-flex flex-wrap">
                <li>
                    <a href="compare.html">
                        <b> <img src="{{ url('assets/frontend/images/compare_black.svg') }}" alt="Wishlist" class="img-fluid"> </b>
                        <span>2</span>
                    </a>
                </li>
                <li>
                    <a href="wishlist.html">
                        <b> <img src="{{ url('assets/frontend/images/love_black.svg') }}" alt="Wishlist" class="img-fluid"></b>
                        <span>4</span>
                    </a>
                </li>
                <li>
                    <a href="cart.html">
                        <b><img src="{{ url('assets/frontend/images/cart_black.svg') }}" alt="cart" class="img-fluid"></b>
                        <span>5</span>
                    </a>
                </li>
                <li>
                    <a href="dashboard.html">
                        <b><img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="cart" class="img-fluid"></b>
                    </a>
                </li>
            </ul>

            <form class="mobile_menu_search">
                <input type="text" placeholder="Search">
                <button type="submit"><i class="far fa-search"></i></button>
            </form>

            <div class="mobile_menu_item_area">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Categories</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">menu</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab" tabindex="0">
                        <ul class="main_mobile_menu">
                            <li class="mobile_dropdown">
                                <a href="#">Men's Fashion</a>
                                <ul class="inner_menu">
                                    <li><a href="shop.html">jeans pant</a></li>
                                    <li><a href="shop.html">formal shirt</a></li>
                                    <li><a href="shop.html">2 quater</a></li>
                                    <li><a href="shop.html">denim jacket</a></li>
                                    <li><a href="shop.html">t-shirt</a></li>
                                    <li><a href="shop.html">polo-shirt</a></li>
                                    <li><a href="shop.html">formal pant</a></li>
                                </ul>
                            </li>
                            <li class="mobile_dropdown">
                                <a href="#">women's Fashion</a>
                                <ul class="inner_menu">
                                    <li><a href="shop.html">sharee</a></li>
                                    <li><a href="shop.html">kurti</a></li>
                                    <li><a href="shop.html">plazoo</a></li>
                                    <li><a href="shop.html">lagins</a></li>
                                    <li><a href="shop.html">tops</a></li>
                                    <li><a href="shop.html">scart</a></li>
                                    <li><a href="shop.html">denim jeans</a></li>
                                    <li><a href="shop.html">Gown</a></li>
                                </ul>
                            </li>
                            <li class="mobile_dropdown">
                                <a href="#">kids fashion</a>
                                <ul class="inner_menu">
                                    <li><a href="shop.html">t-shirt</a></li>
                                    <li><a href="shop.html">partu dress</a></li>
                                    <li><a href="shop.html">sharee</a></li>
                                    <li><a href="shop.html">kurti</a></li>
                                </ul>
                            </li>
                            <li class="mobile_dropdown">
                                <a href="#">western wear</a>
                                <ul class="inner_menu">
                                    <li><a href="shop.html">western party dress</a></li>
                                    <li><a href="shop.html">kurti</a></li>
                                    <li><a href="shop.html">denim pant</a></li>
                                    <li><a href="shop.html">casual jacket</a></li>
                                </ul>
                            </li>
                            <li class="mobile_dropdown">
                                <a href="#">Denim collection</a>
                                <ul class="inner_menu">
                                    <li><a href="shop.html">shirt</a></li>
                                    <li><a href="shop.html">pant</a></li>
                                    <li><a href="shop.html">jacket</a></li>
                                    <li><a href="shop.html">blazer</a></li>
                                </ul>
                            </li>
                            <li class="mobile_dropdown">
                                <a href="#">sport wear</a>
                                <ul class="inner_menu">
                                    <li><a href="shop.html">shoes</a></li>
                                    <li><a href="shop.html">trouser</a></li>
                                    <li><a href="shop.html">meat</a></li>
                                    <li><a href="shop.html">Outdoors</a></li>
                                    <li><a href="shop.html">Sports Pant</a></li>
                                </ul>
                            </li>
                            <li class="mobile_dropdown">
                                <a href="#">beauty products</a>
                                <ul class="inner_menu">
                                    <li><a href="shop.html">Concealer Palette</a></li>
                                    <li><a href="shop.html">Highlighter Palette</a></li>
                                    <li><a href="shop.html">SkinPure Avocado Gel</a></li>
                                    <li><a href="shop.html">Blush Palette</a></li>
                                    <li><a href="shop.html">Face Wash</a></li>
                                    <li><a href="shop.html">Lip Balm</a></li>
                                </ul>
                            </li>
                            <li class="mobile_dropdown">
                                <a href="#">fashion jewellery</a>
                                <ul class="inner_menu">
                                    <li><a href="shop.html">Necklace</a></li>
                                    <li><a href="shop.html">ear ring</a></li>
                                    <li><a href="shop.html">fingure ring</a></li>
                                    <li><a href="shop.html">bratchlet</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                        aria-labelledby="pills-profile-tab" tabindex="0">
                       
                        <livewire:frontend.theme.menu-item className="main_mobile_menu" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>