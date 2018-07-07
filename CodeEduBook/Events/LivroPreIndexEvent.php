<?php

namespace CodeEduBook\Events;


use CodeEduBook\Models\Livro;

class LivroPreIndexEvent
{
    /**
     * @var Livro
     */
    private $livro;
    private $ranking = 0;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Livro $livro)
    {
        //
        $this->livro = $livro;
    }

    /**
     * @return Livro
     */
    public function getLivro ()
    {
        return $this->livro;
    }

    /**
     * @return int
     */
    public function getRanking ()
    {
        return $this->ranking;
    }

    /**
     * @param int $ranking
     * @return LivroPreIndexEvent
     */
    public function setRanking ($ranking)
    {
        $this->ranking = $ranking;
        return $this;
    }


}
