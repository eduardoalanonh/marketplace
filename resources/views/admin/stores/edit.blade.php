@extends('layouts.app')

@section('content')
<h1> Editar loja</h1>
<form action="{{route('admin.stores.update', ['store' => $store->id])}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Nome loja</label>
        <input type="text" name="name" class="form-control" value="{{$store->name}}">
    </div>

    <div class="form-group">
        <label>Descricao</label>
        <input type="text" name="description"  class="form-control"  value="{{$store->name}}">
    </div>

    <div class="form-group">
        <label>Telefone</label>
        <input type="text" name="phone"  class="form-control"  value="{{$store->phone}}">
    </div>

    <div class="form-group">
        <label>Celular/Whatsapp</label>
        <input type="text" name="mobile_phone"  class="form-control"  value="{{$store->mobile_phone}}">
    </div>

    <div class="form-group">
        <p>
            <img src="{{asset('storage/' . $store->logo)}}" alt="">
        </p>
        <label for="logo">Logo loja</label>
        <input type="file" name="logo" class="form-control" multiple>
    </div>


    <div>
        <button type="submit" class="btn btn-success btn-lg">Atualizar loja</button>
    </div>
</form>
@endsection
