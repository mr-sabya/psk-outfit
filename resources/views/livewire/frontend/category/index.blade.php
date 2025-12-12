<section class="category_page category_2 mt_75 mb_95">
    <div class="container">
        <div class="row">
            @forelse ($categories as $category)
            <div class="col-xl-2 col-6 col-sm-4 col-md-3 wow fadeInUp">
                {{--
                        Pass the category object to the child component.
                        wire:key is important for Livewire to track lists.
                    --}}
                <livewire:frontend.components.category
                    :category="$category"
                    :wire:key="'cat-page-'.$category->id" />
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <h3>No categories found.</h3>
            </div>
            @endforelse
        </div>

        <div class="row">
            <div class="pagination_area mt_50 d-flex justify-content-center">
                {{--
                    This generates the pagination links automatically using 
                    the 'bootstrap' theme defined in the component.
                --}}
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</section>