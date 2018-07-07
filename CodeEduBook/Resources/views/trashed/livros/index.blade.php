<!--
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 10/11/2017
 * Time: 11:30
 */
-->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Lixeira</h3>
        </div>
        <div class="row">
            {!! Form::model([], ['class' => 'form-inline pull-right', 'method' => 'GET']) !!}
                {{--{!! Form::label('search', 'Busca:  ', ['class' => 'control-label']) !!}--}}
                {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Buscar por...']) !!}

                {!! Button::primary('Buscar')->submit() !!}
            {!! Form::close() !!}
        </div>
        <div class="row">
            @if($livros->count() > 0)
                {!!
                    Table::withContents($livros->items())->striped()
                    ->callback('Ações', function ($field, $livro){
                        $linkView = route('trashed.livros.show', ['livro' => $livro->id]);
                        $linkRestore = route('trashed.livros.update', ['livro' => $livro->id]);
                        $restoreForm = "restore-form-{$livro->id}";
                        $form = Form::open(['route' => ['trashed.livros.update', 'livro' => $livro->id], 'method' => 'PUT', 'id' => $restoreForm, 'style' => 'disply:none']).
                        /*Form::hidden('redirect_to', URL::previous()).*/
                        Form::close();
                        $anchorRestore = Button::link('Restaurar')->asLinkTo($linkRestore)->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"{$restoreForm}\").submit();"]);
                        return "<ul class=\"list-inline\">".
                                    "<li>".Button::link('Ver')->asLinkTo($linkView)."</li>".
                                    "<li>|</li>".
                                    "<li>".$anchorRestore."</li>".
                                "</ul>".
                                $form;
                    });
                !!}
            @else
                <br>
                <div class="well well-lg text-center">
                    <strong>Lixieira vazia</strong>
                </div>
            @endif
            {{ $livros->links() }}
        </div>
    </div>
@endsection