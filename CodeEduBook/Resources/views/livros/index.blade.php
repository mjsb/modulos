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
            <h3>Listagem de livros</h3>
        </div>
        <div class="row">
            {!! Button::primary('Novo livro')->asLinkTo(route('livros.create'))->addAttributes(['class' => 'pull-right']) !!}
            {!! Form::model([], ['class' => 'form-inline', 'method' => 'GET']) !!}
                {{--{!! Form::label('search', 'Busca:  ', ['class' => 'control-label']) !!}--}}
                {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Buscar por...']) !!}

                {!! Button::primary('Buscar')->submit() !!}
            {!! Form::close() !!}
        </div>
        <div class="row">
            {!!
                Table::withContents($livros->items())->striped()
                ->callback('Ações', function ($field, $livro){
                    $linkEdit = route('livros.edit', ['livro' => $livro->id]);
                    $linkDestroy = route('livros.destroy', ['livro' => $livro->id]);
                    $linkCapitulos = route('capitulos.index', ['livro' => $livro->id]);
                    $linkCapa = route('livros.cover.create', ['livro' => $livro->id]);
                    $linkExport = route('livros.export', ['livro' => $livro->id]);
                    $deleteFormId = "delete-form-{$livro->id}";
                    $deleteForm = Form::open([
                                        'route' => ['livros.destroy', 'livro' => $livro->id],
                                        'method' => 'DELETE', 'id' => $deleteFormId,
                                        'style' => 'disply:none'
                                    ]).Form::close();

                    $anchorDestroy = Button::link('Lixeira')
                                        ->asLinkTo($linkDestroy)
                                        ->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"{$deleteFormId}\").submit();"]);

                    /*$exportFormId = "export-form-{$livro->id}";
                    $exportForm = Form::open([
                                        'route' => ['livros.export','livro' => $livro->id],
                                        'method' => 'POST','id' => $exportFormId, 'style' => 'display:none']).Form::close();*/

                    $anchorExport = Button::link('Exportar')
                                ->asLinkTo($linkExport)
                                /* ->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"{$exportFormId}\").submit();"]);*/
                                ->addAttributes(['onclick' => "event.preventDefault();exportBook(\"$linkExport\");"]);

                    return "<ul class=\"list-inline\">".
                                "<li>".$anchorExport."</li>".
                                "<li>|</li>".
                                "<li>".Button::link('Capítulos')->asLinkTo($linkCapitulos)."</li>".
                                "<li>|</li>".
                                "<li>".Button::link('Capa')->asLinkTo($linkCapa)."</li>".
                                "<li>|</li>".
                                "<li>".Button::link('Editar')->asLinkTo($linkEdit)."</li>".
                                "<li>|</li>".
                                "<li>".$anchorDestroy."</li>".
                            "</ul>".
                            $deleteForm;
                            /*$exportForm;*/
                });
            !!}
            {{ $livros->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function exportBook(route){
            window.$.get(route, function(data){
                /*alert('Processo de exportação iniciado!')*/
                window.notify({message: 'Processo de exportação iniciado!!'});
            })
        }
    </script>
@endpush