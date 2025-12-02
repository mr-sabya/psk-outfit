<ul class="{{ $className }}">
    <li>
        <a class="{{ Route::is('home') ? 'active' : '' }}" href="{{ route('home')}}" wire:navigate>Home </a>
    </li>
    <li>
        <a class="{{ Route::is('shop') ? 'active' : '' }}" href="{{ route('shop') }}" wire:navigate>Shop </a>
    </li>
    <li>
        <a class="{{ Route::is('category') ? 'active' : '' }}" href="{{ route('category') }}" wire:navigate>Categories </a>
    </li>
    <li>
        <a class="{{ Route::is('flash-deals') ? 'active' : '' }}" href="{{ route('flash-deals') }}" wire:navigate>Flash Deals </a>
    </li>
    <li>
        <a class="{{ Route::is('blog') ? 'active' : '' }}" href="{{ route('blog') }}" wire:navigate>Blog </a>
    </li>
    <li>
        <a class="{{ Route::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}" wire:navigate>Contact </a>
    </li>
</ul>