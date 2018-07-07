@extends('layouts.app')

@section('content')
    <div class="content container">
        <h2>Checkout</h2>

        <h3>Informações do livro: {{$produto->title}}</h3>
        <p>{{$produto->description}}</p>
        <p>Preço: US$ {{$produto->price}}</p>

        <div class="stripe-button">
            {!! Form::open(['url' => route('store.process', ['produto' => $produto->id]), 'method' => 'POST']) !!}
                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-label="Pagar com cartão"
                        data-panel-label="Concluir pagamento"
                        data-email="{{Auth::user()->email}}"
                        data-key="pk_test_agGFfnDIRvIIBB5TNc6iR6QL"
                        data-amount="{{$produto->price*100}}"
                        data-name="Code Pub"
                        data-description="Livro: {{$produto->title}}"
                        data-locale="auto"></script>
            {!! Form::close() !!}
        </div>
    </div>
@endsection