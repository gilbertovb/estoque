@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Relatório de movimento</div>
                <div class="panel-body">
                    <div class="row">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Data</th>
                                <th>Estoque</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Usuario</th>
                            </tr>
                            @foreach($movimentos as $movimento)
                            <tr>
                                <td>{{ $movimento->created_at }}</td>
                                <td>{{ $movimento->estoque->nome }}</td>
                                <td>{{ $movimento->produto->nome }}</td>
                                <td>{{ str_replace('.',',',$movimento->quantidade) }}</td>
                                <td>{{ $movimento->user->name }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
