<?php

namespace CodeEduUser\Providers;

use CodeEduUser\Criteria\FindPermissionsResourceCriteria;
use CodeEduUser\Repositories\PermissionRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        #retornou true - autorizado
        #retornou false - não autorizado
        #retornou void - vai executar a habilidade em questão

        \Gate::before(function ($user, $ability){
            if($user->isAdmin()){
                return true;
            }
        });

        /*\Gate::define('user-admin', function ($user){
            return $user->isAdmin();
        });*/

        if (!app()->runningInConsole() || app()->runningUnitTests()) {

            /** @var TYPE_NAME $permissionRepository */
            $permissionRepository = app(PermissionRepository::class);
            $permissionRepository->pushCriteria(new FindPermissionsResourceCriteria());
            $permissions = $permissionRepository->all();
            foreach ($permissions as $p) {
                \Gate::define("{$p->name}/{$p->resource_name}", function ($user) use ($p) {
                    return $user->hasRole($p->roles);
                });
            }

        }
    }
}
