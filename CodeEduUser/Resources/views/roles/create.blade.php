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
            <h3>Nova função</h3>

            {!! Form::open(['route' => 'codeeduuser.roles.store', 'class' => 'form']) !!}

                @include('codeeduuser::roles._form')

                {!! Html::openFormGroup('name', $errors) !!}
                    {!! Button::primary('Criar função')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}

        </div>
    </div>
@endsection