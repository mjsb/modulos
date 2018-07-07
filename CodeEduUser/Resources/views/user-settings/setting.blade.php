<!--
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 02/03/2018
 * Time: 16:24
 */
-->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Redefinir senha</h3>

            {!! Form::open(['route' => 'codeeduuser.user_settings.update', 'class' => 'form', 'method' => 'PUT']) !!}

                {{--{!! Form::hidden('redirect_to', URL::previous()) !!}
                {!! Html::openFormGroup('name', $errors) !!}
                {!! Form::label('name', 'Nome', ['class' => 'control-label']) !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                {!! Form::error('name', $errors) !!}
                {!! Html::closeFormGroup() !!}

                {!! Html::openFormGroup('email', $errors) !!}
                {!! Form::label('email', 'E-mail', ['class' => 'control-label']) !!}
                {!! Form::text('email', null, ['class' => 'form-control']) !!}
                {!! Form::error('email', $errors) !!}
                {!! Html::closeFormGroup() !!}--}}

                {!! Html::openFormGroup('password', $errors) !!}
                {!! Form::label('password', 'Senha', ['class' => 'control-label']) !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
                {!! Form::error('password', $errors) !!}
                {!! Html::closeFormGroup() !!}

                {!! Html::openFormGroup() !!}
                {!! Form::label('password_confirmation', 'Confirme a senha', ['class' => 'control-label']) !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                {!! Html::closeFormGroup() !!}

                {!! Html::openFormGroup('name', $errors) !!}
                {!! Button::primary('Salvar')->submit() !!}
                {!! Html::closeFormGroup() !!}

            {!! Form::close() !!}

        </div>
    </div>
@endsection