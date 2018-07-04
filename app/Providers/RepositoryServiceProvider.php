<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces;
use App\Repositories;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(
                Interfaces\BookmarksRepositoryInterface::class, Repositories\EloquentBookmarksRepository::class
        );
        $this->app->singleton(
                Interfaces\WebshrinkerSimpleCategoriesRepositoryInterface::class, Repositories\EloquentWebshrinkerSimpleCategoriesRepository::class
        );
        $this->app->singleton(
                Interfaces\WebshrinkerIabCategoriesRepositoryInterface::class, Repositories\EloquentWebshrinkerIabCategoriesRepository::class
        );
    }

}
