@extends('layouts.app')

@section('content')
<script type="text/javascript" src="{{ url('/js/jquery.mask.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#min').mask('0.000.000,0000', {reverse:true});

    });
</script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Produtos do estoque {{ $estoque->nome }}</div>

                <div class="panel-body">
                    @if(isset($mensagem))
                    <div style="color: red">{!! $mensagem !!}</div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>Produtos</th>
                                    <th>Quantidade atual</th>
                                    <th>Quantidade mínima</th>
                                </tr>
                                @foreach($estoque->produtos as $produto)
                                <tr>
                                    <td style="text-align: right; vertical-align: middle;">
                                        {{ $produto->nome }}
                                    </td>
                                    <td style="vertical-align: middle;">
                                        {{ str_replace('.',',',$produto->pivot->atual) }} {{ $produto->unidade->nome }}{{ ($produto->pivot->atual > 1) ? 's' : '' }}
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/verestoque/'.$estoque->id.'/'.$produto->id) }}">
                                            {{ csrf_field() }}
                                            <div class="form-group{{ $errors->has('min') ? ' has-error' : '' }}">
                                                <div class="col-md-6">
                                                    <input id="min" type="text" class="form-control" name="min" value="{{ str_replace('.',',',$produto->pivot->min) }}" placeholder="0.000,000">
                                                    @if ($errors->has('min'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('min') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
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
</div>
@endsection
