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
            <h3>Listagem de funções de usuário</h3>
            {!! Button::primary('Nova função')->asLinkTo(route('codeeduuser.roles.create'))->addAttributes(['class' => 'pull-right']) !!}
            {{--{!! Form::model([], ['class' => 'form-inline', 'method' => 'GET']) !!}
                {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Buscar por...']) !!}

                {!! Button::primary('Buscar')->submit() !!}
            {!! Form::close() !!}--}}
        </div>
        <div class="row">
            {!!
                Table::withContents($roles->items())->striped()
                ->callback('Ações', function ($field, $role){
                    $linkEdit = route('codeeduuser.roles.edit', ['role' => $role->id]);
                    $linkDestroy = route('codeeduuser.roles.destroy', ['role' => $role->id]);
                    $linkEditPermission = route('codeeduuser.roles.permissions.edit', ['role' => $role->id]);
                    $deleteForm = "delete-form-{$role->id}";
                    $form = Form::open(['route' => ['codeeduuser.roles.destroy', 'role' => $role->id], 'method' => 'DELETE', 'id' => $deleteForm, 'style' => 'disply:none']).Form::close();
                    $anchorDestroy = Button::link('Excluir')->asLinkTo($linkDestroy)->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"{$deleteForm}\").submit();"]);

                    if($role->id == 1){
                        $anchorDestroy->disable();
                    }

                    return "<ul class=\"list-inline\">".
                                "<li>".Button::link('Editar')->asLinkTo($linkEdit)."</li>".
                                "<li>|</li>".
                                "<li>".$anchorDestroy."</li>".
                                "<li>|</li>".
                                "<li>".Button::link('Permissões')->asLinkTo($linkEditPermission)."</li>".
                            "</ul>".
                            $form;
                });
            !!}

            {{ $roles->links() }}
        </div>
    </div>
@endsection
