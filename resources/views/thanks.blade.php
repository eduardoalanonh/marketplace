@extends('layouts.front')

@section('content')
    <h2>Muito obrigado</h2>
    <h3 class="alert alert-success">Seu pedido foi processado, codigo do pedido: {{request()->get('order')}}</h3>
@endsection
