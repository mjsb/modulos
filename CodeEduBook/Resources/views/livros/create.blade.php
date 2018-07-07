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
            <h3>Novo livro</h3>

            {!! Form::open(['route' => 'livros.store', 'class' => 'form']) !!}

                @include('livros._form')

                {!! Html::openFormGroup() !!}
                    {{--{!! Form::submit('Cadastrar livro', ['class' => 'btn btn-primary']) !!}--}}
                    {!! Button::primary('Cadastrar livro')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}

        </div>
    </div>
@endsection