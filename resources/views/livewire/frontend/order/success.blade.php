<section class="payment_success mt_100 mb_100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10 col-lg-8 col-xxl-5 wow fadeInUp">
                <div class="payment_success_text text-center">
                    <div class="img mb-4">
                        <img src="{{ asset('assets/frontend/images/payment_success_img.png') }}" alt="payment" class="img-fluid">
                    </div>
                    <h3 class="mb-3">Your Order is Successful!</h3>
                    <p class="mb-4">
                        We appreciate your purchase! We can't wait to deliver your items to you.
                        Your Order ID is <b>{{ $orderNumber }}</b>.
                        Your order is being processed and we will keep you informed about its progress.
                    </p>
                    <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
                        <a href="{{ route('home') }}" wire:navigate class="common_btn go_btn">
                            Go to Home
                        </a>
                        <!-- Linking to the Track Order component we built earlier -->
                        <a href="{{ route('order.track', ['order_number' => str_replace('#', '', $orderNumber)]) }}"
                            wire:navigate class="common_btn">
                            Track Order
                            <i class="fas fa-long-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .payment_success_text .img {
            max-width: 250px;
            margin: 0 auto;
        }

        .payment_success_text h3 {
            font-size: 30px;
            font-weight: 700;
        }

        .payment_success_text p b {
            color: #ff3c00;
            font-size: 18px;
        }

        .go_btn {
            background: #000 !important;
        }

        .go_btn:hover {
            background: #ff3c00 !important;
        }
    </style>

</section>