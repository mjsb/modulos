<?php

namespace CodeEduBook\Http\Controllers;

use App\Criteria\FindByNameCriteria;
#use CodeEduBook\Models\Categoria;
use CodeEduBook\Http\Requests\CategoriasRequest;
use CodeEduBook\Repositories\CategoriaRepository;
use Illuminate\Http\Request;
use CodeEduUser\Annotations\Mapping as Permission;

/**
 * @Permission\Controller(name="category-admin", description="Administração de categorias")
 */

class CategoriasController extends Controller
{

    /**
     * @var CategoriaRepository
     */
    private $repository;

    /**
     * CategoriasController constructor.
     * @param CategoriaRepository $repository
     */

    public function __construct(CategoriaRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     * @Permission\Action(name="list", description="Listar categorias")
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $search = $request->get('search');
        $this->repository->pushCriteria(new FindByNameCriteria($search));
        $categorias = $this->repository->paginate(10);
        return view('codeedubook::categorias.index', compact('categorias', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     * @Permission\Action(name="store", description="Cadastrar categorias")
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('codeedubook::categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     * @Permission\Action(name="store", description="Cadastrar categorias")
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriasRequest $request)
    {
        $this->repository->create($request->all());
        $url = $request->get('redirect_to', route('categorias.index'));
        $request->session()->flash('message', 'Categoria cadastrada com sucesso!');
        return redirect()->to($url);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* public function show($id)
     {
         //
     }*/

    /**
     * Show the form for editing the specified resource.
     * @Permission\Action(name="update", description="Atualizar categorias")
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = $this->repository->find($id);
        return view('codeedubook::categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     * @Permission\Action(name="update", description="Atualizar categorias")
     * @param CategoriasRequest|Request $request
     * @param \CodeEduBook\Models\Categoria $categoria
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(CategoriasRequest $request, $id)
    {
        $this->repository->update($request->all(),$id);
        $url = $request->get('redirect_to', route('categorias.index'));
        $request->session()->flash('message', 'Categoria alterada com sucesso!');
        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     * @Permission\Action(name="delete", description="Excluir categorias")
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        \Session::flash('message', 'Categoria excluida com sucesso!');
        return redirect()->to(\URL::previous());
    }
}
