<?php

namespace CodeEduBook\Models;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Database\Eloquent\Model;

class Capitulo extends Model implements TableInterface
{
    protected $fillable = [
        'name',
        'content',
        'order',
        'livro_id'
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }

    /**
     * @return array
     */
    public function getTableHeaders(){
        return ['#','Nome','Ordem'];
    }

    /**
     * @param $header
     * @return mixed
     */
    public function getValueForHeader($header){
        switch ($header){
            case '#':
                return $this->id;
            case 'Nome':
                return $this->name;
            case 'Ordem':
                return $this->order;
        }
    }
}
