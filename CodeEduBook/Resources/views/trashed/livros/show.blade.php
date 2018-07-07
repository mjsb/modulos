@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>{{ $livro->title }}</h3>
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Subtítulo</strong>
                </li>
                <li class="list-group-item">{{ $livro->subtitle }}</li>
                <li class="list-group-item">
                    <strong>Preço</strong>
                </li>
                <li class="list-group-item">{{ $livro->price }}</li>
                <li class="list-group-item">
                    <strong>Categorias</strong>
                </li>
                <li class="list-group-item">{{ $livro->categorias->implode('name_trashed', ', ') }}</li>
            </ul>
        </div>
    </div>
@endsection