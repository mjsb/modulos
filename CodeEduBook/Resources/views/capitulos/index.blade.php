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
            <h3>Capítulos do livro: {{$livro->title}}</h3>
        </div>
        <div class="row">
            {!! Button::primary('Novo capítulo')->asLinkTo(route('capitulos.create', ['livro' => $livro->id]))->addAttributes(['class' => 'pull-right']) !!}
            {!! Form::model(compact('search'), ['class' => 'form-inline', 'method' => 'GET']) !!}
                {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Buscar por...']) !!}
                {!! Button::primary('Buscar')->submit() !!}
            {!! Form::close() !!}
        </div>
        <div class="row">
            {!!
                Table::withContents($capitulos->items())->striped()
                ->callback('Ações', function ($field, $capitulo) use($livro){
                    $linkEdit = route('capitulos.edit', ['livro' => $livro->id, 'capitulo' => $capitulo->id]);
                    $linkDestroy = route('capitulos.destroy', ['livro' => $livro->id, 'capitulo' => $capitulo->id]);
                    $deleteForm = "delete-form-{$capitulo->id}";
                    $form = Form::open([
                        'route' => ['capitulos.destroy',
                        'livro' => $livro->id,
                        'capitulo' => $capitulo->id],
                        'method' => 'DELETE',
                        'id' => $deleteForm,
                        'style' => 'disply:none']).
                    Form::close();
                    $anchorDestroy = Button::link('Excluir')->asLinkTo($linkDestroy)->addAttributes([
                        'onclick' => "event.preventDefault();document.getElementById(\"{$deleteForm}\").submit();"
                    ]);
                    return "<ul class=\"list-inline\">".
                                "<li>".Button::link('Editar')->asLinkTo($linkEdit)."</li>".
                                "<li>|</li>".
                                "<li>".$anchorDestroy."</li>".
                            "</ul>".
                            $form;
                });
            !!}
            {{ $capitulos->links() }}
        </div>
    </div>
@endsection