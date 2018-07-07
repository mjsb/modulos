<?php

namespace CodeEduBook\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindByBook
 * @package CodeEduBook\Criteria
 */

class OrderByOrder implements CriteriaInterface {

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply ($model, RepositoryInterface $repository){
        return $model->orderBy('order','asc');
    }
}
