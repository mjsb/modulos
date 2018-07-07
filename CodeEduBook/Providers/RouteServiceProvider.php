<?php

namespace CodeEduBook\Providers;

use CodeEduBook\Criteria\FindByAuthor;
use CodeEduBook\Repositories\LivroRepository;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $rootUrlNamespace = '\CodeEduBook\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @param  Router $router
     * @return void
     */
    public function before(Router $router)
    {
        //
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(Router $router)
    {
        \Route::group([
            'middleware' => 'web',
            'namespace' => $this->rootUrlNamespace
        ], function (){
            require __DIR__ . '/../Http/routes.php';
        });
    }

    public function boot ()
    {
        parent::boot();

        \Route::bind('livro',function ($value){
            $livroRepository = app(LivroRepository::class);
            //autorização
            $livroRepository->pushCriteria(new FindByAuthor());
            return $livroRepository->find($value);
        });
    }


}
