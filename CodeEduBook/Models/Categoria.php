<?php

namespace CodeEduBook\Models;

use Bootstrapper\Interfaces\TableInterface;
use CodeEduBook\Models\Livro;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model implements TableInterface
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [ 'name'];

    public function livros() {
        return $this->belongsToMany(Livro::class, "livro_categoria");
    }

    public function getNameTrashedAttribute(){

        return $this->trashed() ? "{$this->name} ( INATIVA )": $this->name;

    }

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */

    public function getTableHeaders()
    {
        // TODO: Implement getTableHeaders() method.
        return ['#', 'Nome'];
    }

    /**
     * Get the value for a given header. Note that this will be the value
     * passed to any callback functions that are being used.
     *
     * @param string $header
     * @return mixed
     */
    public function getValueForHeader($header)
    {
        // TODO: Implement getValueForHeader() method.
        switch ($header){
            case '#':
                return $this->id;
            case 'Nome':
                return $this->name;

        }
    }
}
