<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Load all NON-PRIVATE settings from DB
         * and cast their values using the model accessors.
         */
        $settings = cache()->rememberForever('global_settings', function () {
            return Setting::public() // Only non-private
                ->get()
                ->mapWithKeys(function ($setting) {
                    return [$setting->key => $setting->value]; // value is auto-casted by your model
                })
                ->toArray();
        });

        /**
         * Share settings with all Blade views
         */
        View::share('settings', $settings);

        /**
         * Make available through config()
         */
        config(['global_settings' => $settings]);
    }
}
