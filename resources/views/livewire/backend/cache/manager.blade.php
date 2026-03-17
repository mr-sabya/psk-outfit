<div class="">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark text-gradient">System Maintenance</h3>
            <p class="text-muted mb-0">Manage application performance and clear compiled cache files.</p>
        </div>
        <div wire:loading>
            <div class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                System Busy...
            </div>
        </div>
    </div>

    @if (session()->has('success'))
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
        <i class="fas fa-check-circle me-3 fs-4"></i>
        <div>
            <strong class="d-block">Success!</strong>
            {{ session('success') }}
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        <!-- Danger Zone / Global Action -->
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="background: linear-gradient(45deg, #ffffff 70%, #fff5f5 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="fw-bold text-danger"><i class="fas fa-radiation me-2"></i> The Nuclear Option</h5>
                            <p class="text-muted mb-md-0">This will clear everything: config, routes, views, and application cache. Use this to resolve unexpected behavior after a deployment.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <button
                                wire:click="clearCache('all')"
                                wire:loading.attr="disabled"
                                class="btn btn-danger btn-lg px-5 shadow-sm rounded-pill">
                                <span wire:loading.remove wire:target="clearCache('all')">
                                    <i class="fas fa-rocket me-2"></i> Optimize & Clear
                                </span>
                                <span wire:loading wire:target="clearCache('all')">
                                    <span class="spinner-border spinner-border-sm" role="status"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Surgical Actions -->
        <!-- Config Cache -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary-subtle text-primary rounded-3 p-3 me-3">
                            <i class="fas fa-cogs fs-4"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Configuration</h6>
                    </div>
                    <p class="small text-muted mb-4">Clears the cached `.env` and config files. Required after updating environment variables.</p>
                    <button wire:click="clearCache('config')" wire:loading.attr="disabled" class="btn btn-outline-primary btn-sm w-100 rounded-pill">
                        Clear Config
                    </button>
                </div>
            </div>
        </div>

        <!-- View Cache -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info-subtle text-info rounded-3 p-3 me-3">
                            <i class="fas fa-code fs-4"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Compiled Views</h6>
                    </div>
                    <p class="small text-muted mb-4">Clears compiled Blade templates. Use this if your UI changes aren't appearing.</p>
                    <button wire:click="clearCache('view')" wire:loading.attr="disabled" class="btn btn-outline-info btn-sm w-100 rounded-pill">
                        Clear Views
                    </button>
                </div>
            </div>
        </div>

        <!-- Route Cache -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning-subtle text-warning rounded-3 p-3 me-3">
                            <i class="fas fa-route fs-4"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Route Cache</h6>
                    </div>
                    <p class="small text-muted mb-4">Clears the registered route list. Helpful if you just added new URLs that 404.</p>
                    <button wire:click="clearCache('route')" wire:loading.attr="disabled" class="btn btn-outline-warning btn-sm w-100 rounded-pill">
                        Clear Routes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Footer -->
    <div class="mt-5 p-3 bg-light rounded-3 border">
        <div class="d-flex align-items-start">
            <i class="fas fa-lightbulb text-warning me-3 mt-1"></i>
            <div>
                <span class="fw-bold d-block">Pro Tip:</span>
                <span class="text-muted small">In a production environment, it is highly recommended to run <code>php artisan optimize</code> after clearing cache to ensure your application stays fast.</span>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .08) !important;
        }

        .transition {
            transition: all 0.3s ease-in-out;
        }

        .bg-primary-subtle {
            background-color: #e7f1ff;
        }

        .bg-info-subtle {
            background-color: #e0f7fa;
        }

        .bg-warning-subtle {
            background-color: #fff3e0;
        }

        .text-gradient {
            background: linear-gradient(90deg, #212529, #495057);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</div>