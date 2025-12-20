<div>
    <div class="blog_details_right wow fadeInRight">

        <!-- Search Form -->
        <div class="sidebar_search">
            <form action="">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search...">
                <button type="button"><i class="far fa-search"></i></button>
            </form>
        </div>

        <!-- Popular Blogs -->
        <div class="blog_details_right_header sidebar_blog">
            <h3>Popular Blog</h3>
            @foreach($popularPosts as $pPost)
            <div class="popular_blog d-flex flex-wrap">
                <div class="popular_blog_img">
                    <img src="{{ $pPost->image_url ?? url('assets/frontend/images/blog_img_1.png') }}" alt="img" class="img-fluid w-100">
                </div>
                <div class="popular_blog_text">
                    <p>
                        <span><img src="{{ url('assets/frontend/images/calender.png') }}" alt="icon" class="img-fluid w-100"></span>
                        {{ $pPost->published_at->format('M d, Y') }}
                    </p>
                    <a class="title" href="{{ route('blog.show', $pPost->slug) }}" wire:navigate>
                        {{ Str::limit($pPost->title, 40) }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Categories -->
        <div class="blog_details_right_header">
            <h3>Categories</h3>
            <ul class="sidebar_blog_category">
                @foreach($categories as $category)
                <li>
                    <a href="#">
                        <p>{{ $category->name }}</p>
                        <span>({{ sprintf('%02d', $category->blog_posts_count) }})</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Tags -->
        <div class="blog_details_right_header">
            <h3>Popular Tags</h3>
            <ul class="blog_details_tag d-flex flex-wrap">
                @foreach($tags as $tag)
                <li><a href="#">{{ $tag->name }}</a></li>
                @endforeach
            </ul>
        </div>

        <!-- Sidebar Ad/Banner -->
        <div class="blog_details_right_header">
            <div class="blog_seidebar_add">
                <img src="{{ url('assets/frontend/images/blog_sidebar_add_img.png') }}" alt="blog add" class="img-fluid w-100">
                <div class="text">
                    <h4>Will help enhance your beauty.</h4>
                    <a class="common_btn" href="{{ url('/shop') }}">shop now <i class="fas fa-long-arrow-right"></i></a>
                </div>
            </div>
        </div>

    </div>
</div>