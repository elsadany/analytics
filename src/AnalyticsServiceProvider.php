<?php

namespace Elsadany\Analytics;

use Illuminate\Support\ServiceProvider;

class AnalyticsServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        if (!file_exists(base_path('config') . '/analyticsConfig.php')) {
            $this->publishes([__DIR__ . '/config' => base_path('config')]);
        }
        include __DIR__ . '/routes.php';
        $this->app->make('Elsadany\Analytics\AnalyticsController');



        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/backend/googleAnalytics'),
        ]);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
