<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $settings = DB::table('settings')
                    ->get()
                    ->keyBy('key')
                    ->transform( function ($setting) {
                        return $setting->value;
                    })
                    ->toArray();;

    // Insert settings array to Config file
        config([
            'settings' => $settings
        ]);
    // Access app.name and set its value from the inserted settings array
        config([
            'app.name' => config('settings.app_name'),
        ]);

    }
}
