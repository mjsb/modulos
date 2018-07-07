<!--
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 09/11/2017
 * Time: 15:41
 */
-->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de categorias</h3>
            {!! Button::primary('Nova categoria')->asLinkTo(route('categorias.create'))->addAttributes(['class' => 'pull-right']) !!}
            {!! Form::model([], ['class' => 'form-inline', 'method' => 'GET']) !!}
                {{--{!! Form::label('search', 'Busca:  ', ['class' => 'control-label']) !!}--}}
                {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Buscar por...']) !!}

                {!! Button::primary('Buscar')->submit() !!}
            {!! Form::close() !!}
        </div>
        <div class="row">
            {!!
                Table::withContents($categorias->items())->striped()
                ->callback('Ações', function ($field, $categoria){
                    $linkEdit = route('categorias.edit', ['categoria' => $categoria->id]);
                    $linkDestroy = route('categorias.destroy', ['categoria' => $categoria->id]);
                    $deleteForm = "delete-form-{$categoria->id}";
                    $form = Form::open(['route' => ['categorias.destroy', 'categoria' => $categoria->id], 'method' => 'DELETE', 'id' => $deleteForm, 'style' => 'disply:none']).Form::close();
                    $anchorDestroy = Button::link('Excluir')->asLinkTo($linkDestroy)->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"{$deleteForm}\").submit();"]);
                    return "<ul class=\"list-inline\">".
                                "<li>".Button::link('Editar')->asLinkTo($linkEdit)."</li>".
                                "<li>|</li>".
                                "<li>".$anchorDestroy."</li>".
                            "</ul>".
                            $form;
                });
            !!}

            {{ $categorias->links() }}
        </div>
    </div>
@endsection
