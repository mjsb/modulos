<?php

namespace CodeEduUser\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeEduUser\Models\Role;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{

    public function updatePermissions (array $permissions, $id)
    {
        $model = $this->find($id);
        $model->permissions()->detach();
        if(count($permissions)){
            $model->permissions()->sync($permissions);
        }
        return $model;
    }

    /*public function update(array $attributes, $id)
    {
        $model = parent::update($attributes, $id);
        if(isset($attributes['permissions'])){
            $model->permissions()->sync($attributes['permissions']);
        }
        return $model;
    }*/

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
