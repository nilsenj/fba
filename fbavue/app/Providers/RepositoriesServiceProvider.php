<?php
/**
 * Copyright (c) 2016. Property of Combird. All Rights reserved 
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoriesServiceProvider
 * @package App\Providers
 */
class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $models = [
            'Basket',
            'Item'
        ];

        foreach ($models as $repo) {
            $this->app->bind(
                "FBA\\Repositories\\{$repo}Repository",
                "FBA\\Repositories\\{$repo}RepositoryEloquent"
            );
        }
    }
}
