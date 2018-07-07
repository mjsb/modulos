@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <h2>Capa de: {{$livro->title}}</h2>

            {!! Form::open(['route'=>['livros.cover.store', $livro->id], 'files' => true]) !!}

            {!! Form::hidden('redirect_to', URL::previous()) !!}

            {!! Html::openFormGroup('file', $errors) !!}
            {!! Form::label('file', 'Capa (formato aceito: jpg)') !!}
            {!! Form::file('file', ['class' => 'form-control']) !!}
            {!! Form::error('file', $errors) !!}
            {!! Html::closeFormGroup() !!}

            {!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection
