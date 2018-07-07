<?php

namespace CodeEduStore\Models;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Database\Eloquent\Model;

class Store extends Model implements TableInterface
{

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */

    public function getValueForHeader($header)
    {

    }
}
