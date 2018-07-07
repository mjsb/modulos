<?php

namespace CodeEduUser\Http\Controllers;

use CodeEduUser\Criteria\FindPermissionsGroupCriteria;
use CodeEduUser\Criteria\FindPermissionsResourceCriteria;
use CodeEduUser\Http\Requests\PermissionRequest;
use CodeEduUser\Http\Requests\RoleDeleteRequest;
use CodeEduUser\Http\Requests\RoleRequest;
use CodeEduUser\Repositories\PermissionRepository;
use CodeEduUser\Repositories\RoleRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use CodeEduUser\Annotations\Mapping as Permission;

/**
 * @Permission\Controller(name="role-admin", description="Administração de funções de usuário")
 */

class RolesController extends Controller
{

    /**
     * @var \CodeEduUser\Repositories\RoleRepository
     */
    private $repository;
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * RolesController constructor.
     * @param RoleRepository $repository
     * @param PermissionRepository $permissionRepository
     */

    public function __construct(RoleRepository $repository, PermissionRepository $permissionRepository)
    {
        $this->repository = $repository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @Permission\Action(name="list", description="Listar funções de usuários")
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $roles = $this->repository->paginate(10);
        return view('codeeduuser::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @Permission\Action(name="Store", description="Cadastrar funções de usuários")
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('codeeduuser::roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @Permission\Action(name="Store", description="Cadastrar funções de usuários")
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $this->repository->create($request->all());
        $url = $request->get('redirect_to', route('codeeduuser.roles.index'));
        $request->session()->flash('message', 'Função cadastrada com sucesso!');
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
     *
     * @Permission\Action(name="Update", description="Atualizar funções de usuários")
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = $this->repository->find($id);
        return view('codeeduuser::roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @Permission\Action(name="Update", description="Atualizar funções de usuários")
     * @param RoleRequest|Request $request
     * @param \CodeEduUser\Models\Role $role
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(RoleRequest $request, $id)
    {
        $data = $request->except('permissions');
        $this->repository->update($data,$id);
        $url = $request->get('redirect_to', route('codeeduuser.roles.index'));
        $request->session()->flash('message', 'Função alterada com sucesso!');
        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @Permission\Action(name="Delete", description="Excluir funções de usuários")
     * @param RoleDeleteRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoleDeleteRequest $request, $id)
    {
        try{
            $this->repository->delete($id);
            \Session::flash('message', 'Função excluída com sucesso!');
        }catch (QueryException $ex){
            \Session::flash('error', 'Essa Função não pode ser excluída! Ela esta atrelada a um ou mais usuários.');
        }
        return redirect()->to(\URL::previous());
    }

    public function editPermission($id){

        $role = $this->repository->find($id);

        $this->permissionRepository->pushCriteria(new FindPermissionsResourceCriteria());
        $permissions = $this->permissionRepository->all();

        $this->permissionRepository->resetCriteria();
        $this->permissionRepository->pushCriteria(new FindPermissionsGroupCriteria());
        $permissionsGroup = $this->permissionRepository->all(['name','description']);

        return view('codeeduuser::roles.permissions', compact('role','permissions','permissionsGroup'));
    }


    /**
     * @Permission\Action(name="Update", description="Atualizar funções de usuários")
     * @param PermissionRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePermission(PermissionRequest $request, $id){
        $data = $request->get('permissions',[]);
        $this->repository->updatePermissions($data,$id);
        $url = $request->get('redirect_to', route('codeeduuser.roles.index'));
        $request->session()->flash('message', 'Permissões alteradas com sucesso!');
        return redirect()->to($url);
    }
}
