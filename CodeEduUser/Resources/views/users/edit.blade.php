<!--
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 09/11/2017
 * Time: 19:22
 */
-->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Editar usuário</h3>

            {!! Form::model($user, ['route' => ['codeeduuser.users.update', 'user' => $user->id], 'class' => 'form', 'method' => 'PUT']) !!}

                @include('codeeduuser::users._form')

                {!! Html::openFormGroup('name', $errors) !!}
                    {!! Button::primary('Salvar usuário')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}

        </div>
    </div>
@endsection