<?php

namespace CodeEduUser\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(\CodeEduUser\Repositories\UserRepository::class, \CodeEduUser\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\CodeEduUser\Repositories\RoleRepository::class, \CodeEduUser\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\CodeEduUser\Repositories\PermissionRepository::class, \CodeEduUser\Repositories\PermissionRepositoryEloquent::class);
    }
}
