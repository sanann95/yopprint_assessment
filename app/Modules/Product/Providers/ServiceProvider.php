<?php

namespace App\Modules\Product\Providers;

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
        // app()->register(EventServiceProvider::class);
    }

    protected function bindServices(){
        $this->app->bind('products-service', 'App\Modules\Product\Services\ProductsService');
        $this->app->bind('product-service', 'App\Modules\Product\Services\ProductService');
    }
}