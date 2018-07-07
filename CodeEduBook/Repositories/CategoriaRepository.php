<?php

namespace CodeEduBook\Repositories;

use App\Criteria\CriteriaTrashedInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CategoriaRepository.
 *
 * @package namespace App\Repositories;
 */
interface CategoriaRepository extends RepositoryInterface, CriteriaTrashedInterface
{
    //
    public function listsWithMutators($column, $key = null);

}
