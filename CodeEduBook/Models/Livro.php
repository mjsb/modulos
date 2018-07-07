<?php

namespace CodeEduBook\Models;

use CodeEduBook\Events\LivroPreIndexEvent;
use CodeEduBook\Models\Categoria;
use CodeEduUser\Models\User;
use Bootstrapper\Interfaces\TableInterface;
use Collective\Html\Eloquent\FormAccessible;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Livro extends Model implements TableInterface
{
    use FormAccessible;
    use SoftDeletes;
    use BookStorageTrait;
    use BookThumbnailTrait;
    use Sluggable;
    use SluggableScopeHelpers;
    use Searchable;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'subtitle',
        'price',
        'author_id',
        'dedication',
        'description',
        'website',
        'percent_complete',
        'published'
    ];

    /*public function searchable ()
    {
        return 'menu_indice_livro';
    }*/

    public function toSearchableArray ()
    {
        $array = $this->toArray();

        $event = new LivroPreIndexEvent($this);
        event($event);

        $array = array_merge($array, ['ranking' => $event->getRanking()]);
        return $array;

    }

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */

    public function author(){
        return $this->belongsTo(\CodeEduUser\Models\User::class);
    }

    public function categorias() {
        return $this->belongsToMany(Categoria::class, "livro_categoria")->withTrashed();
    }

    public function capitulos() {
        return $this->hasMany(Capitulo::class);
    }

    public function formCategoriasAttribute() {
        return $this->categorias->pluck('id')->all();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getTableHeaders()
    {
        // TODO: Implement getTableHeaders() method.
        return ['#', 'Título', 'Autor', 'Preço'];
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
            case 'Título':
                if(file_exists($this->zip_file)){
                    $route = route('livros.download', ['id' => $this->id]);
                    return "<a href=\"{$route}\" target=\"_blank\">{$this->title}</a>";
                } else {
                    return $this->title;
                }
            case 'Autor':
                return $this->author->name;
            case 'Preço':
                return $this->price;
        }
    }
}
