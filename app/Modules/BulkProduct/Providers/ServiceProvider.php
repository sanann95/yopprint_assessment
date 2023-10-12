<?php

namespace App\Modules\BulkProduct\Providers;

class ServiceProvider extends \Illuminate\Support\ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->registerProviders();
        $this->bindServices();
        // $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadMigrationsFrom(dirname(__DIR__) . '/database/migrations');
    }

    protected function registerProviders(){
        app()->register(EventServiceProvider::class);
    }

    protected function bindServices(){
        $this->app->bind('bulk-product-service', 'App\Modules\BulkProduct\Services\BulkProductService');
        $this->app->bind('bulk-product-import-service', 'App\Modules\BulkProduct\Services\ImportService');
    }
}