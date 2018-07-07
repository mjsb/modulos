@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de usuários</h3>
            {!! Button::primary('Novo usuário')->asLinkTo(route('codeeduuser.users.create'))->addAttributes(['class' => 'pull-right']) !!}
            {!! Form::model([], ['class' => 'form-inline', 'method' => 'GET']) !!}
                {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Buscar por...']) !!}

                {!! Button::primary('Buscar')->submit() !!}
            {!! Form::close() !!}
        </div>
        <div class="row">
            {!!
                Table::withContents($users->items())->striped()
                ->callback('Ações', function ($field, $user){
                    $linkEdit = route('codeeduuser.users.edit', ['user' => $user->id]);
                    $linkDestroy = route('codeeduuser.users.destroy', ['user' => $user->id]);
                    $deleteForm = "delete-form-{$user->id}";
                    $form = Form::open(['route' => ['codeeduuser.users.destroy', 'user' => $user->id], 'method' => 'DELETE', 'id' => $deleteForm, 'style' => 'disply:none']).Form::close();
                    $anchorDestroy = Button::link('Excluir')->asLinkTo($linkDestroy)->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"{$deleteForm}\").submit();"]);

                    if($user->id == \Auth::user()->id){
                        $anchorDestroy->disable();
                    }

                    return "<ul class=\"list-inline\">".
                                "<li>".Button::link('Editar')->asLinkTo($linkEdit)."</li>".
                                "<li>|</li>".
                                "<li>".$anchorDestroy."</li>".
                            "</ul>".$form;
                });
            !!}

            {{ $users->links() }}
        </div>
    </div>
@endsection
