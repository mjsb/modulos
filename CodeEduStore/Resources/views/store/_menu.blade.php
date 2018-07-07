@inject('categoriaRepository','CodeEduStore\Repositories\CategoriaRepository')
<aside class="col-md-3">
    <a href="#" class="list-group-item disabled">Categorias</a>
    @foreach($categoriaRepository->all() as $categoria)
        <a href="{{route('store.categoria',['categoria' => $categoria->id])}}" class="list-group-item">{{$categoria->name}}</a>
    @endforeach
</aside>