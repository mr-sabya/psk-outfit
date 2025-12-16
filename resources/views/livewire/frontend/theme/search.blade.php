<form action="#">
    <select class="select_2">
        <option>All Categories</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    <div class="input">
        <input type="text" placeholder="Search your product...">
        <button type="submit"><i class="far fa-search"></i></button>
    </div>
</form>