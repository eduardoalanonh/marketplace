@extends('layouts.app')

@section('content')
<h1> Criar Loja</h1>
<form action="{{route('admin.stores.update', ['store' => $store->id])}}" method="post">
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
        <label>slug</label>
        <input type="text" name="slug"  class="form-control"  value="{{$store->slug}}">
    </div>

    <div>
        <button type="submit" class="btn btn-success btn-lg">Atualizar loja</button>
    </div>
</form>
@endsection
