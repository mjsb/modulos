<?php

namespace CodeEduBook\Http\Controllers;

use CodeEduBook\Criteria\OrderByOrder;
use CodeEduBook\Http\Requests\CapituloCreateRequest;
use CodeEduBook\Http\Requests\CapituloUpdateRequest;
use CodeEduBook\Models\Livro;
use CodeEduBook\Repositories\LivroRepository;
use CodeEduBook\Criteria\FindByAuthor;
use CodeEduBook\Criteria\FindByBook;
use CodeEduBook\Repositories\CapituloRepository;
use Illuminate\Http\Request;
use CodeEduUser\Annotations\Mapping as Permission;

/**
 * @Permission\Controller(name="book-admin", description="Administração de livros")
 */
class CapitulosController extends Controller
{
    /**
     * @var CapituloRepository
     */
    private $repository;
    /**
     * @var LivroRepository
     */
    private $livroRepository;

    public function __construct(CapituloRepository $repository, LivroRepository $livroRepository)
    {
        $this->repository = $repository;
        $this->livroRepository = $livroRepository;
        $this->livroRepository->pushCriteria(new FindByAuthor());
    }

    /**
     * Display a listing of the resource.
     * @Permission\Action(name="list", description="Listar livros")
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, Livro $livro)
    {
        $search = $request->get('search');
        $this->repository->pushCriteria(new FindByBook($livro->id))->pushCriteria(new OrderByOrder());
        $capitulos = $this->repository->paginate(10);
        return view('codeedubook::capitulos.index', compact('capitulos', 'search', 'livro'));
    }

    /**
     * Show the form for creating a new resource.
     * @Permission\Action(name="store", description="Cadastrar livros")
     * @return \Illuminate\Http\Response
     */
    public function create(Livro $livro)
    {
        return view('codeedubook::capitulos.create', compact('livro'));

    }

    /**
     * Store a newly created resource in storage.
     * @Permission\Action(name="store", description="Cadastrar livros")
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(CapituloCreateRequest $request, Livro $livro)
    {
        $data = $request->all();
        $data['livro_id'] = $livro->id;
        $this->repository->create($data);
        $url = $request->get('redirect_to', route('capitulos.index',['livro' => $livro->id]));
        $request->session()->flash('message', 'Capitulo cadastrado com sucesso!');
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
     * @Permission\Action(name="update", description="Atualizar livros")
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Livro $livro, $capituloId)
    {
        $this->repository->pushCriteria(new FindByBook($livro->id));
        $capitulo = $this->repository->find($capituloId);
        return view('codeedubook::capitulos.edit', compact('capitulo','livro'));

    }

    /**
     * Update the specified resource in storage.
     * @Permission\Action(name="update", description="Atualizar livros")
     * @param CapituloUpdateRequest|Request $request
     * @param Livro $livro
     * @param $capituloId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */

    public function update(CapituloUpdateRequest $request, Livro $livro, $capituloId)
    {
        $this->repository->pushCriteria(new FindByBook($livro->id));
        $data = $request->except(['livro_id']);
        $this->repository->update($data,$capituloId);
        $url = $request->get('redirect_to', route('capitulos.index',['livro' => $livro->id]));
        $request->session()->flash('message', 'Capítulo alterado com sucesso!');
        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     * @Permission\Action(name="delete", description="Excluir livros")
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Livro $livro, $capituloId)
    {
        $this->repository->pushCriteria(new FindByBook($livro->id));
        $this->repository->delete($capituloId);
        \Session::flash('message', 'Capitulo excluído com sucesso!');
        return redirect()->route('livros.index');
    }
}
