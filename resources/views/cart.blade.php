@extends('layouts.front')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Carrinho de compras</h2>
            <hr>
        </div>
        <div class="col-12">
            @if($cart)
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preco</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $c)
                    <tr>
                        <td>{{$c['name']}}</td>
                        <td>R$: {{number_format($c['price'], 2, ',','.')}}</td>
                        <td>{{$c['amount']}}</td>
                        @php
                        $subtotal = $c['price'] * $c['amount'];
                        $total += $subtotal;
                        @endphp

                        <td>R$: {{number_format($subtotal, 2, ',', '.' )}}</td>
                        <td>
                            <a href="{{route('cart.remove',['slug' => $c['slug']])}}" class="btn btn-sm btn-danger">Remover</a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"></td>
                    <td colspan="2">Total:R$ {{number_format($total,2,',','.')}}</td>
                </tr>
                </tbody>
            </table>
                <hr>
                <div class="col-md-12">
                    <a href="#" class="btn btn-lg btn-success float-right">Concluir Compra</a>
                    <a href="{{route('cart.cancel')}}" class="btn btn-lg btn-danger float-right">Cancelar Compra</a>
                </div>
            @else
                <div class="alert alert-warning">Carrinho vazio</div>
            @endif
        </div>
    </div>
@endsection
