<!--
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 10/11/2017
 * Time: 12:10
 */
-->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Novo capítulo - Livro: {{$livro->title}}</h3>

            {!! Form::open(['route' => ['capitulos.store','livro' => $livro->id], 'class' => 'form']) !!}

                @include('codeedubook::capitulos._form')

                {!! Html::openFormGroup() !!}
                    {!! Button::primary('Criar capítulo')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}

        </div>
    </div>
@endsection