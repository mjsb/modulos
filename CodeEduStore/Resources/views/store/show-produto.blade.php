@extends('layouts.app')

@section('content')
    <section class="container info">
        <article class="col-md-4">
            <h2>{{$produto->title}}</h2>
            <div class="author">
                <img src="http://www.gravatar.com/avatar/{{md5($produto->author->email)}} ?s=30" alt="categoria.blade.php"/>
                <p>{{$produto->author->name}}</p>
            </div>
            <p>{{$produto->description}}</p>
        </article>
        <div class="col-md-4 text-center">
            <img src="{{asset($produto->thumbnail_relative)}}" alt="{{$produto->title}}"/>
            {{--<h2>Categoria: {{$categoria->name}}</h2>--}}
            <div class="col-md-12">
                <div class="progress progress-book">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$produto->percent_complete}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$produto->percent_complete}}%">
                        <span class="sr-only">{{$produto->percent_complete}}%</span>
                    </div>
                </div>
                <p>Livro com {{$produto->percent_complete}}% completo</p>
            </div>
        </div>
        <aside class="col-md-4 text-center">
            <div class="col-md-5 col-lg-offset-1">
                <p class="price">US$ {{$produto->price}}</p>
            </div>
            <div class="pull-right">
                <a href="{{route('store.checkout',['produto' => $produto->id])}}" class="btn btn-success btn-cpr">Comprar</a>
            </div>
            <div class="col-md-12">
                <hr>
                <p>
                    @foreach($produto->capitulos as $capitulo)
                        {{$capitulo->name}}<br>
                    @endforeach
                </p>
            </div>
        </aside>
    </section>
@endsection