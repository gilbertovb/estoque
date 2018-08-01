@extends('layouts.app')

@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $(':checkbox').on('change', function () {
            if (jQuery('#solicitacao_form input[type=checkbox]:checked').length) {
                $('#bt_autorizar').prop('disabled', false);
            } else {
                $('#bt_autorizar').prop('disabled', true);
            }
            var th = $(this), name = th.prop('name');
            if (th.is(':checked')) {
                $(':checkbox[name="' + name + '"]').not($(this)).prop('checked', false);
            }
        });
    });
</script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Solicitação de saída número <strong>{{ $producao->id }}</strong></div>
                <div class="panel-body">
                    <form id="solicitacao_form" class="form-horizontal" role="form" method="POST" action="{{ url('/home/solicitacao/'.$producao->id) }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>Data</th>
                                    <th>Produto a ser produzido</th>
                                    <th>Quantidade</th>
                                    <th>Usuario</th>
                                    <th>Produtos solicitados</th>
                                    <th>Quantidade solicitada</th>
                                    <th>Quantidade em estoque</th>
                                </tr>
                                <tr>
                                    <td rowspan="{{ count($solicitacoes) }}" style="vertical-align: middle;">{{ $producao->created_at }}</td>                                
                                    <td rowspan="{{ count($solicitacoes) }}" style="vertical-align: middle;">{{ $producao->produto->nome }}</td>                                
                                    <td rowspan="{{ count($solicitacoes) }}" style="vertical-align: middle;">{{ str_replace('.',',',$producao->quantidade) }}</td>                                
                                    <td rowspan="{{ count($solicitacoes) }}" style="vertical-align: middle;">{{ $producao->user->name }}</td>
                                    @foreach($solicitacoes as $solicitacao)
                                    @if(!$solicitacao->autorizado)
                                    <td>{{ $solicitacao->produto->nome }}</td>
                                    <td>{{ $solicitacao->quantidade }}</td>
                                    <td>
                                        @foreach($solicitacao->produto->estoques as $estoque)
                                        @foreach($estoque->produtos as $produto)
                                        @if($produto->id == $solicitacao->produto->id)
                                        <div style="color: {{($produto->pivot->atual < $solicitacao->quantidade) ? 'red':'black'}};">
                                            <label>
                                                <input type="checkbox" name="solicitacao[{{ $produto->id }}]" value="{{ $solicitacao->id }}:{{ $estoque->id }}"{{($produto->pivot->atual < $solicitacao->quantidade) ? ' disabled':''}}>
                                                {{ $produto->pivot->atual }} ({{ $estoque->nome }})
                                            </label>
                                        </div>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </table>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-4">
                                    <button id="bt_autorizar" type="submit" class="btn btn-primary" disabled>
                                        <i class="fa fa-btn fa-thumbs-up"></i> Autorizar
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ URL::previous() }}">
                                        <div class="btn btn-danger">
                                            <i class="fa fa-btn fa-thumbs-down"></i> Cancelar
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
