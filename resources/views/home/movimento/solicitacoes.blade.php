@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Solicitações de saída</div>
                <div class="panel-body">
                    @if($errors->has('mensagem'))
                    <div style="color: red">{!! $errors->first('mensagem') !!}</div>
                    @endif
                    <div class="row">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Código</th>
                                <th>Data</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Usuario</th>
                                <th>Ação</th>
                            </tr>
                            @foreach($solicitacoes as $solicitacao)
                            <tr>
                                <td>{{ $solicitacao->id }}</td>                                
                                <td>{{ $solicitacao->created_at }}</td>
                                <td>{{ $solicitacao->produto->nome }}</td>
                                <td>{{ str_replace('.',',',$solicitacao->quantidade) }}</td>
                                <td>{{ $solicitacao->user->name }}</td>
                                <td>
                                    <a href="{{ url('/home/solicitacao/'.$solicitacao->producao_id) }}">
                                    <div class="btn btn-primary">Ver solicitação</div>
                                    </a>
                                </td>
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
