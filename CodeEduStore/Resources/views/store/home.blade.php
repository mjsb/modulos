@extends('layouts.app')
@section('banner')
    @include('codeedustore::store._banner')
@endsection
@section('menu')
    @include('codeedustore::store._menu')
@endsection
@section('content')
    <div class="content col-md-9">
        <h2>Mais vendidos</h2>
        <div class="col-md-12">
            @foreach($produtos as $produto)
                <div class="col-md-3 book-home">
                    <a href="{{route('store.show-produto',['slug' => $produto->slug])}}" class="book-thumbnail">
                        <img src="{{asset($produto->thumbnail_small_relative)}}" alt="{{$produto->title}}" />
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection