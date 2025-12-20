<div class="blog_item">
    <a href="{{ route('blog.show', $post->slug) }}" wire:navigate class="blog_img">
        {{-- Use the getImageUrlAttribute from your model --}}
        <img src="{{ $post->image_url ?? url('assets/frontend/images/blog_img_1.png') }}"
            alt="{{ $post->title }}"
            class="img-fluid w-100">
    </a>
    <div class="blog_text">
        <ul class="top">
            <li>
                <span>
                    <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="user" class="img-fluid w-100">
                </span>
                Admin {{-- Or $post->author->name if you add a user relationship --}}
            </li>
            <li>
                <span>
                    <img src="{{ url('assets/frontend/images/calender.png') }}" alt="Calendar" class="img-fluid w-100">
                </span>
                {{ $post->published_at->format('d M Y') }}
            </li>
        </ul>
        <a class="title" href="{{ route('blog.show', $post->slug) }}" wire:navigate>
            {{ $post->title }}
        </a>

        {{-- Optional: Show excerpt if needed --}}
        {{-- <p>{{ Str::limit($post->excerpt, 100) }}</p> --}}

        <ul class="bottom">
            <li>
                <a href="{{ route('blog.show', $post->slug) }}" wire:navigate>
                    read more <i class="fas fa-long-arrow-right"></i>
                </a>
            </li>
            <li>
                <span>
                    <i class="far fa-comment-dots"></i>
                    {{-- Placeholder for comments count --}}
                    0 Comments
                </span>
            </li>
        </ul>
    </div>
</div>