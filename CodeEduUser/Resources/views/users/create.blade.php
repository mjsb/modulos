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
            <h3>Novo usuário</h3>

            {!! Form::open(['route' => 'codeeduuser.users.store', 'class' => 'form']) !!}

                @include('codeeduuser::users._form')

                {!! Html::openFormGroup('name', $errors) !!}
                    {!! Button::primary('Criar usuário')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}

        </div>
    </div>
@endsection