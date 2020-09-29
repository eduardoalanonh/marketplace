@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.notification.readAll')}}" class="btn btn-lg btn-success">Marcar todoas como
                lidas!</a>
            <hr>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Notificacao</th>
            <th>Criado em</th>
            <th>Acoes</th>
        </tr>
        </thead>
        <tbody>
        @forelse($unreadNotifications as $n)
            <tr>
                <td>{{$n->data['message']}}</td>
                <td>{{$n->created_at->locale('pt')->diffForHumans()}}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{route('admin.notification.read', ['notification' => $n->id])}}" type="submit"
                           class="btn btn-sm btn-danger">Marcar como lida</a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">
                    <div class="alert alert-warning">Nenhuma notificacao</div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection
