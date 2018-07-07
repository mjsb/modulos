<?php

namespace CodeEduBook\Http\Controllers;

use App\Http\Controllers\Controller;
use CodeEduBook\Repositories\LivroRepository;
use Illuminate\Http\Request;
use CodeEduUser\Annotations\Mapping as Permission;

/**
 * @Permission\Controller(name="book-trashed-admin", description="Administração de livros excluídos")
 */
class LivrosTrashedController extends Controller
{
    /**
     * @var \CodeEduBook\Repositories\LivroRepository
     */
    private $repository;

    public function __construct(LivroRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @Permission\Action(name="list", description="Listar livros excluídos")
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $search = $request->get('search');
        $this->repository->onlyTrashed();
        $livros = $this->repository->paginate(10);
        return view('codeedubook::trashed.livros.index', compact('livros', 'search'));

    }

    /**
     * @Permission\Action(name="list", description="Listar livros excluídos")
     */

    public function show($id) {

        $this->repository->onlyTrashed();
        $livro = $this->repository->find($id);
        return view('codeedubook::trashed.livros.show', compact('livro'));

    }

    /**
     * @Permission\Action(name="restore", description="Restaurar livros excluídos")
     */

    public function update(Request $request, $id) {

        $this->repository->onlyTrashed();
        $this->repository->restore($id);

        $url = $request->get('redirect_to', route('trashed.livros.index'));
        $request->session()->flash('message', 'Livro restaurado com sucesso!');
        return redirect()->to($url);

    }
}
