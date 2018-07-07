<?php

namespace CodeEduBook\Repositories;

use CodeEduBook\Repositories\CapituloRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeEduBook\Models\Capitulo;

/**
 * Class CapituloRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CapituloRepositoryEloquent extends BaseRepository implements CapituloRepository
{

    protected $fieldSearchable = [
        'title' => 'like',
        'author.name' => 'like',
        'categorias.name' => 'like'
    ];

    /*public function create(array $attributes)
    {
        $model = parent::create($attributes);
        $model->categorias()->sync($attributes['categorias']);
        return $model;
    }

    public function update(array $attributes, $id)
    {
        $model = parent::update($attributes, $id);
        $model->categorias()->sync($attributes['categorias']);
    }*/


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Capitulo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
