<?php

namespace CodeEduBook\Repositories;

use App\Criteria\CriteriaTrashedInterface;
use App\Repositories\RepositoryRestoreInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface LivroRepository.
 *
 * @package namespace App\Repositories;
 */
interface LivroRepository extends RepositoryInterface, RepositoryCriteriaInterface, CriteriaTrashedInterface, RepositoryRestoreInterface
{
    //
}
