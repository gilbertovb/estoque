@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Fichas Técnicas</div>

                <div class="panel-body">
                    @if(isset($mensagem))
                    <div style="color: red">{!! $mensagem !!}</div>
                    @endif
                    <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered">
                        @foreach($fichastecnicas as $fichatecnica)
                        <tr>
                            <td style="text-align: right; vertical-align: middle;">
                                <p>{{ $fichatecnica->nome }}</p>
                                <p>{!! str_replace("\n","<br>",$fichatecnica->obs) !!}</p>
                            </td>
                            <td style="vertical-align: middle;">
                                @foreach($fichatecnica->produtos as $produto)
                                {{ $produto->nome }} - {{ str_replace('.',',',$produto->pivot->quantidade) }} {{ $produto->unidade->nome }}<br>
                                @endforeach
                            </td>
                            <td style="vertical-align: middle;">
                                <a href="{{ url('/home/fichatecnica/'.$fichatecnica->id.'/composicao') }}">
                                    <div class="btn btn-success">Alterar composição</div>
                                </a>
                                <a href="{{ url('/home/fichatecnica/'.$fichatecnica->id) }}">
                                    <div class="btn btn-primary">Alterar nome e obs</div>
                                </a>
                                <a href="{{ url('/home/fichatecnica/'.$fichatecnica->id.'/del') }}">
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
                    <a href="{{ url('/home/fichatecnica/novo') }}">
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
