<div class="row">
    @if (session()->has('success'))
    <div class="col-12">
        <div class="alert alert-success">{{ session('success') }}</div>
    </div>
    @endif

    @foreach(['home-banner-1', 'home-banner-2', 'home-banner-3'] as $slug)
    <div class="col-md-4">
        <div class="card card-round shadow-sm">
            <div class="card-header bg-light">
                <div class="card-title text-uppercase font-weight-bold">{{ str_replace('-', ' ', $slug) }}</div>
            </div>
            <div class="card-body">
                <div class="mb-3 text-center border rounded p-2 bg-light">
                    @if(isset($new_images[$slug]))
                    <img src="{{ $new_images[$slug]->temporaryUrl() }}" class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                    @else
                    <img src="{{ asset('storage/' . $banners[$slug]['image_path']) }}" class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                    @endif
                </div>

                <div class="form-group mb-2">
                    <label class="small font-weight-bold">Change Image
                        <span class="text-primary">
                            {{ $slug == 'home-banner-1' ? '(420 × 480 px)' : ($slug == 'home-banner-2' ? '(640 × 400 px)' : '(510 × 645 px)') }}
                        </span>
                    </label>
                    <input type="file" wire:model="new_images.{{ $slug }}" class="form-control form-control-sm">
                </div>

                <div class="form-group mb-2">
                    <label class="small font-weight-bold">Title</label>
                    <input type="text" wire:model="banners.{{ $slug }}.title" class="form-control">
                </div>

                <!-- Banner Text Field -->
                <div class="form-group mb-2">
                    <label class="small font-weight-bold">Description Text</label>
                    <textarea wire:model="banners.{{ $slug }}.banner_text" class="form-control" rows="2" placeholder="e.g. Up to 50% Off"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="small font-weight-bold">Link (URL)</label>
                    <input type="text" wire:model="banners.{{ $slug }}.link" class="form-control">
                </div>

                <button wire:click="save('{{ $slug }}')" class="btn btn-primary w-100" wire:loading.attr="disabled">
                    <span wire:loading.remove><i class="fas fa-save"></i> Update Banner</span>
                    <span wire:loading><i class="fas fa-spinner fa-spin"></i> Saving...</span>
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>