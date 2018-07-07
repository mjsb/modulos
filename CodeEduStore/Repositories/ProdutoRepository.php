<?php

namespace CodeEduStore\Repositories;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CategoriaRepository.
 *
 * @package namespace App\Repositories;
 */
interface ProdutoRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    public function home();
    public function findByCategoria($id);
    public function findBySlug($slug);
    public function makeProductStore($id);
    public function like($search);

}
