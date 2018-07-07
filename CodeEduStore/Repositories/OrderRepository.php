<?php

namespace CodeEduStore\Repositories;

use CodeEduStore\Models\ProductStore;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderRepository.
 *
 * @package namespace App\Repositories;
 */
interface OrderRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    public function process($token,$user,ProductStore $productStore);

}
