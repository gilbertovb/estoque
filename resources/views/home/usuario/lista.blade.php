@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Usuários</div>

                <div class="panel-body">
                    @if($errors->has('mensagem'))
                    <div style="color: red">{!! $errors->first('mensagem') !!}</div>
                    @endif
                    <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered">
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td style="text-align: right; vertical-align: middle;">
                                {{ $usuario->name }} ({{ $usuario->login }}) - {{ $usuario->departamento->nome }}
                            </td>
                            <td>
                                <a href="{{ url('/home/usuario/'.$usuario->id) }}">
                                    <div class="btn btn-primary">Alterar</div>
                                </a>
                                <a href="{{ url('/home/usuario/'.$usuario->id.'/del') }}">
                                    <div class="btn btn-danger">Excluir</div>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </table>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                    <a href="{{ url('/home/usuario/novo') }}">
                        <div class="btn btn-default">Novo</div>
                    </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
