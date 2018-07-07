<?php

namespace CodeEduBook\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\CodeEduBook\Repositories\CapituloRepository::class, \CodeEduBook\Repositories\CapituloRepositoryEloquent::class);
        $this->app->bind(\CodeEduBook\Repositories\CategoriaRepository::class, \CodeEduBook\Repositories\CategoriaRepositoryEloquent::class);
        $this->app->bind(\CodeEduBook\Repositories\LivroRepository::class, \CodeEduBook\Repositories\LivroRepositoryEloquent::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
