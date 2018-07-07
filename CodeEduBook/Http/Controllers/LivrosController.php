<?php

namespace CodeEduBook\Http\Controllers;

use CodeEduBook\Criteria\FindByAuthor;
use CodeEduBook\Http\Requests\LivrosCoverRequest;
use CodeEduBook\Http\Requests\LivrosCreateRequest;
use CodeEduBook\Http\Requests\LivrosUpdateRequest;
use CodeEduBook\Jobs\GenerateBook;
use CodeEduBook\Models\Livro;
use CodeEduBook\Notifications\BookExported;
use CodeEduBook\Pub\BookCoverUpload;
#use CodeEduBook\Pub\BookExport;
use CodeEduBook\Repositories\CategoriaRepository;
use CodeEduBook\Repositories\LivroRepository;
use Illuminate\Http\Request;
use CodeEduUser\Annotations\Mapping as Permission;

/**
 * @Permission\Controller(name="book-admin", description="Administração de livros")
 */
class LivrosController extends Controller
{
    /**
     * @var LivroRepository
     */
    private $repository;
    /**
     * @var CategoriaRepository
     */
    private $categoriaRepository;

    public function __construct(LivroRepository $repository, CategoriaRepository $categoriaRepository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(new FindByAuthor());
        $this->categoriaRepository = $categoriaRepository;
    }

    /**
     * Display a listing of the resource.
     * @Permission\Action(name="list", description="Listar livros")
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $search = $request->get('search');
        $livros = $this->repository->paginate(10);
        return view('codeedubook::livros.index', compact('livros', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     * @Permission\Action(name="store", description="Cadastrar livros")
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = $this->categoriaRepository->lists('name','id');
        return view('codeedubook::livros.create', compact('categorias'));

    }

    /**
     * Store a newly created resource in storage.
     * @Permission\Action(name="store", description="Cadastrar livros")
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LivrosCreateRequest $request)
    {
        $data = $request->all();
        $data['author_id'] = \Auth::user()->id;
        $this->repository->create($data);
        $url = $request->get('redirect_to', route('livros.index'));
        $request->session()->flash('message', 'Livro cadastrado com sucesso!');
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
    public function edit(Livro $livro)
    {
        $this->categoriaRepository->withTrashed();
        $categorias = $this->categoriaRepository->listsWithMutators('name_trashed','id');
        return view('codeedubook::livros.edit', compact('livro','categorias'));

    }

    /**
     * Update the specified resource in storage.
     * @Permission\Action(name="update", description="Atualizar livros")
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(LivrosUpdateRequest $request, Livro $livro)
    {
        $data = $request->except(['author_id']);
        $data['published'] = $request->get('published',false);
        $this->repository->update($data, $livro->id);
        $url = $request->get('redirect_to', route('livros.index'));
        $request->session()->flash('message', 'Livro alterado com sucesso!');
        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     * @Permission\Action(name="delete", description="Excluir livros")
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Livro $livro)
    {
        $this->repository->delete($livro->id);
        \Session::flash('message', 'Livro excluído com sucesso!');
        return redirect()->to(\URL::previous());
    }

    /**
     * @Permission\Action(name="cover", description="Capa do livro")
     * @param Livro $livro
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function coverForm(Livro $livro){
        return view('codeedubook::livros.cover', compact('livro'));
    }

    /**
     * @Permission\Action(name="cover", description="Capa do livro")
     */
    public function coverStore(LivrosCoverRequest $request, Livro $livro, BookCoverUpload $upload){

        $upload->upload($livro,$request->file('file'));
        $url = $request->get('redorect_to',route('livros.index'));
        $request->session()->flash('message','Capa adicionada com sucesso!');
        return redirect()->to($url);

    }

    public function export(Livro $livro){
        /*$bookExport = app(BookExport::class);
        $bookExport->export($livro);
        $bookExport->compress($livro);*/

        //dispatch(new GenerateBook($livro));
        \Auth::user()->notify(new BookExported(\Auth::user(), $livro));
        return redirect()->route('livros.index');
    }

    public function download(Livro $livro){
        return response()->download($livro->zip_file);
    }

    public function downloadCommon($id){
        $livro = $this->repository->find($id);
        if(\Gate::allows('livro-download',$livro->id)){
            return $this->download($livro);
        }
        abort(404);
    }
}
