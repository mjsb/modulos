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
            <h3>Editar função</h3>

            {!! Form::model($role, ['route' => ['codeeduuser.roles.update', 'user' => $role->id], 'class' => 'form', 'method' => 'PUT']) !!}

                @include('codeeduuser::roles._form')

                {!! Html::openFormGroup('name', $errors) !!}
                    {!! Button::primary('Salvar função')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}

        </div>
    </div>
@endsection