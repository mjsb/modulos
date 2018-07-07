<!--
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 10/11/2017
 * Time: 12:00
 */
-->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Editar capítulo - Livro: {{$livro->title}}</h3>

            {!! Form::model($capitulo, ['route' => ['capitulos.update', 'livro' => $livro->id, 'capitulo' => $capitulo->id], 'class' => 'form', 'method' => 'PUT']) !!}

                @include('codeedubook::capitulos._form')

                {!! Html::openFormGroup() !!}
                    {{--{!! Form::submit('Salvar capitulo', ['class' => 'btn btn-primary']) !!}--}}
                    {!! Button::primary('Salvar capítulo')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}

        </div>
    </div>
@endsection