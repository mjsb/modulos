<?php

namespace CodeEduBook\Providers;

use CodeEduBook\Models\Livro;
use CodeEduBook\Policies\BookPolicy;
use CodeEduStore\Repositories\OrderRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Livro::class => BookPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        \Gate::define('livro-download', function ($user, $bookId){
            $orderRepository = app(OrderRepository::class);
            $order = $orderRepository->findByField('orderable_id', $bookId)->first();
            return $order ? true : false;
        });
    }
}
