<?php

namespace CodeEduUser\Http\Controllers;

use CodeEduUser\Http\Requests\UserDeleteRequest;
use CodeEduUser\Http\Requests\UserRequest;
use CodeEduUser\Repositories\RoleRepository;
use CodeEduUser\Repositories\UserRepository;
use Illuminate\Http\Request;
use CodeEduUser\Annotations\Mapping as Permission;

/**
 * @Permission\Controller(name="user-admin", description="Administração de usuários")
 */

class UsersController extends Controller
{

    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * UsersController constructor.
     * @param UserRepository $repository
     */

    public function __construct(UserRepository $repository, RoleRepository $roleRepository)
    {
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     * @Permission\Action(name="list", description="Ver listagem de usuários")
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $search = $request->get('search');
        #$this->repository->pushCriteria(new FindByNameCriteria($search));
        $users = $this->repository->paginate(10);
        return view('codeeduuser::users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     * @Permission\Action(name="Store", description="Cria usuário")
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roleRepository->all()->pluck('name','id');
        return view('codeeduuser::users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @Permission\Action(name="Store", description="Cria usuário")
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->repository->create($request->all());
        $url = $request->get('redirect_to', route('codeeduuser.users.index'));
        $request->session()->flash('message', 'Usuário cadastrado com sucesso!');
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
     * @Permission\Action(name="Update", description="Atualiza usuário")
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->repository->find($id);
        $roles = $this->roleRepository->all()->pluck('name','id');
        return view('codeeduuser::users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     * @Permission\Action(name="Update", description="Atualiza usuário")
     * @param UserRequest|Request $request
     * @param \CodeEduUser\Models\User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UserRequest $request, $id)
    {
        $data = $request->except(['password']);
        $this->repository->update($data,$id);
        $url = $request->get('redirect_to', route('codeeduuser.users.index'));
        $request->session()->flash('message', 'Usuário alterado com sucesso!');
        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     * @Permission\Action(name="Delete", description="Exclui usuário")
     * @param UserDeleteRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDeleteRequest $request, $id)
    {
        $this->repository->delete($id);
        \Session::flash('message', 'Usuário excluido com sucesso!');
        return redirect()->to(\URL::previous());
    }
}
