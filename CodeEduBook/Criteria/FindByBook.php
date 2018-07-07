<?php

namespace CodeEduBook\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindByBook
 * @package CodeEduBook\Criteria
 */

class FindByBook implements CriteriaInterface {

    private $bookId;

    /**
     * FindByBook constructor.
     * @param $bookId
     */
    public function __construct ($bookId)
    {
        $this->bookId = $bookId;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply ($model, RepositoryInterface $repository)
    {
        return $model->where('livro_id', $this->bookId);
    }
}
