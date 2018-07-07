<!--
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 09/11/2017
 * Time: 18:50
 */
-->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Nova categoria</h3>
            {{--@if($errors->any())
                <ul class="alert alert-danger list-inline">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif--}}
            {!! Form::open(['route' => 'categorias.store', 'class' => 'form']) !!}

                @include('categorias._form')

                {!! Html::openFormGroup('name', $errors) !!}
                    {{--{!! Form::submit('Criar categoria', ['class' => 'btn btn-primary']) !!}--}}
                    {!! Button::primary('Criar categoria')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}

        </div>
    </div>
@endsection