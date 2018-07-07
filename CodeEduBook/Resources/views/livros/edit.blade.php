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
            <h3>Editar livro</h3>

            {!! Form::model($livro, ['route' => ['livros.update', 'livros' => $livro->id], 'class' => 'form', 'method' => 'PUT']) !!}

                @include('livros._form')

                {!! Html::openFormGroup() !!}
                    {{--{!! Form::submit('Salvar livro', ['class' => 'btn btn-primary']) !!}--}}
                    {!! Button::primary('Salvar livro')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}

        </div>
    </div>
@endsection