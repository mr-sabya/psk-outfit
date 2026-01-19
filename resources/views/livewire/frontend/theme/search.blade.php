<li x-data="{ isOpen: false }" class="search_li" @click.outside="isOpen = false">
    <!-- Search Icon Toggle -->
    <a href="javascript:void(0)" @click="isOpen = !isOpen" class="search_icon_trigger">
        <i class="far fa-search"></i>
    </a>

    <!-- The Search Form Popover -->
    <div
        class="search_form_container"
        x-show="isOpen"
        x-transition
        style="display: none;">
        <form wire:submit.prevent="handleSearch">
            <div class="category_select_wrapper">
                <select
                    class=""
                    wire:model="category"
                    id="search_category_select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input_wrapper">
                <input
                    type="text"
                    wire:model.blur="search"
                    placeholder="Search your product..."
                    x-init="$watch('isOpen', value => value && setTimeout(() => $el.focus(), 100))">
                <button type="submit"><i class="far fa-search"></i></button>
            </div>
        </form>
    </div>
</li>