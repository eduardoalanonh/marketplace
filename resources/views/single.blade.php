@extends('layouts.front')

@section('content')
    <div class="row">
        <div class="col-6">
            @if($product->photos->count())
                <img src="{{asset('storage/' . $product->photos->first()->image)}}" alt=""
                     class="card-img-top img-fluid">
                <div class="row mt-3">
                    @foreach($product->photos as $photo)
                        <div class="col-6">
                            <img src="{{asset('storage/' . $photo->image)}}" alt=""
                                 class="card-img-top img-fluid">
                        </div>
                    @endforeach
                </div>
            @else
                <img src="{{asset('assets/img/no-photo.jpg')}}" alt=""
                     class="card-img-top img-fluid">
            @endif
        </div>
        <div class="col-6">
            <div class="col-md-12">
                <h2>{{$product->name}}</h2>
                <p>{{$product->description}}</p>

                <h3>{{number_format($product->price, '2',',','.')}}</h3>

                <span>
                Loja: {{$product->store->name}}
            </span>
            </div>
            <hr>
            <div class="product-add">
                <form action="{{route('cart.add')}}" method="post">
                    @csrf
                    <input type="hidden" name="product[name]" value="{{$product->name}}">
                    <input type="hidden" name="product[price]" value="{{$product->price}}">
                    <input type="hidden" name="product[slug]" value="{{$product->slug}}">
                    <div class="form-group">
                        <label>Quantidade</label>
                        <input type="number" name="product[amount]" class="form-control col-md-3" value="1">
                    </div>
                    <button class="btn btn-lg btn-danger">Comprar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <hr>
            {{$product->body}}
        </div>
    </div>
@endsection
