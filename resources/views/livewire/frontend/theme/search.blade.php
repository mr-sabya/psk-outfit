<div>
    <form wire:submit.prevent="handleSearch">
        <select
            class="select_2"
            wire:model="category"
            id="search_category_select">
            <option value="">All Categories</option>
            @foreach($categories as $category)
            <option value="{{ $category->slug }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <div class="input">
            <input
                type="text"
                wire:model.blur="search"
                placeholder="Search your product...">
            <button type="submit"><i class="far fa-search"></i></button>
        </div>
    </form>

    <script>
        // If your theme uses Select2, we need this to tell Livewire when the value changes
        $(document).ready(function() {
            $('#search_category_select').on('change', function(e) {
                let data = $(this).val();
                $wire.set('category', data);
            });
        });
    </script>
</div>