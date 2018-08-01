@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Estoques</div>

                <div class="panel-body">
                    @if($errors->has('mensagem'))
                    <div style="color: red">{!! $errors->first('mensagem') !!}</div>
                    @endif
                    <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered">
                        @foreach($estoques as $estoque)
                        <tr>
                            <td style="text-align: right; vertical-align: middle;">
                                <p>{{ $estoque->nome }}</p>
                                <p>{!! str_replace("\n","<br>",$estoque->obs) !!}</p>
                            </td>
                            <td style="vertical-align: middle;">
                                <a href="{{ url('/home/estoque/'.$estoque->id) }}">
                                    <div class="btn btn-primary">Alterar</div>
                                </a>
                                <a href="{{ url('/home/estoque/'.$estoque->id.'/del') }}">
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
                    <a href="{{ url('/home/estoque/novo') }}">
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
