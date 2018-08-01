@extends('layouts.app')

@section('content')
<script type="text/javascript">
    function botao() {
        if (jQuery('#solicitacao_form input[type=checkbox]:checked').length) {
            $('#bt_autorizar').prop('disabled',false);
        } else {
            $('#bt_autorizar').prop('disabled',true);
        }
    }
</script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Solicitação de saída autorizada com sucesso.</div>
                <div class="panel-body">
                        <div class="row">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>Produtos autorizados</th>
                                    <th>Estoque</th>
                                    <th>Quantidade</th>
                                </tr>
                                @for($i = 0; $i < count($solicitacoes); $i++)
                                <tr>
                                    <td>{{ $solicitacoes[$i]->produto->nome }}</td>
                                    <td>{{ $estoques[$i]->nome }}</td>
                                    <td>{{ $solicitacoes[$i]->quantidade }}</td>
                                </tr>
                                @endfor
                            </table>
                        </div>
                        <div class="row">
                                <div class="col-md-6 col-md-offset-5">
                                    <a href="{{ url('/home/solicitacoes') }}">
                                        <div class="btn btn-primary">
                                            <i class="fa fa-btn fa-thumbs-up"></i> OK
                                        </div>
                                    </a>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
