<section class="blog_right_sidebar blog_2 mt_75 mb_100">
    <div class="container">
        <div class="row">
            <!-- Main Blog List -->
            <div class="col-xl-9 col-lg-8">
                <div class="row">
                    @forelse($posts as $post)
                    <div class="col-xl-4 col-md-6 wow fadeInUp" wire:key="post-{{ $post->id }}">
                        <!-- Reusing the Blog Component we created earlier -->
                        <livewire:frontend.components.blog :post="$post" :key="'item-'.$post->id" />
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <p>No posts found matching your criteria.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="pagination_area">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-3 col-lg-4 col-md-8">
                <livewire:frontend.blog.sidebar />
            </div>
        </div>
    </div>
</section>