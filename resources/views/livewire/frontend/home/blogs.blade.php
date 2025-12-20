<section class="blog_2 pt_95">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-sm-9">
                <div class="section_heading_2 section_heading">
                    <h3>Our <span>News</span> & Articles</h3>
                </div>
            </div>
            <div class="col-xl-6 col-sm-3">
                <div class="view_all_btn_area">
                    <!-- Update this link to your actual blog index route -->
                    <a class="view_all_btn" href="{{ url('/blog') }}">View all</a>
                </div>
            </div>
        </div>
        <div class="row mt_15">
            @foreach($posts as $post)
            <div class="col-lg-4 col-xxl-3 col-md-6 wow fadeInUp" data-wow-duration="1s">
                <!-- Passing the $post object to the child component -->
                <livewire:frontend.components.blog :post="$post" :key="$post->id" />
            </div>
            @endforeach
        </div>
    </div>
</section>