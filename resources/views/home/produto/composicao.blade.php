@extends('layouts.app')

@section('content')
<link href="{{ url('/css/select2.min.css') }}" rel="stylesheet" />
<script type="text/javascript" src="{{ url('/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/jquery.mask.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#produto").select2();
        $('#produto').on('change', function() {
            if (this.value != ''){
                $('#input_quantidade').show();
                $('#quantidade').prop('disabled',false)
            }else{
                $('#input_quantidade').hide();
                $('#quantidade').prop('disabled',true)
            }
        });
        $('#quantidade').mask('0.000.000,0000', {reverse:true});

    });
</script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Composição do produto {{ $produto->nome }}</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4" style="text-align: right;"><strong>Nome: </strong></div>
                        <div class="col-md-8">{{ $produto->nome }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4" style="text-align: right;"><strong>Observação: </strong></div>
                        <div class="col-md-8">{!! str_replace("\n","<br>",$produto->obs) !!} </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4" style="text-align: right;"><strong>Produtos: </strong></div>
                        <div class="col-md-8">
                            @foreach($produto->fichatecnica as $produto2)
                                {{ $produto2->nome }} - {{ str_replace('.',',',$produto2->pivot->quantidade) }} {{ $produto2->unidade->nome }}{{ ($produto2->pivot->quantidade > 1) ? 's' : '' }}
                                <a href="{{ url('/home/produto/'.$produto->id.'/composicao/'.$produto2->id.'/del') }}"><i class="fa fa-btn fa-times" style="color: red;"></i></a>
                                <br>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/produto/'.$produto->id.'/composicao') }}">
                        {{ csrf_field() }}
                        
                        <div class="form-group{{ $errors->has('produto') ? ' has-error' : '' }}">
                            <label for="produto" class="col-md-4 control-label">Adicionar produtos</label>
                            <div class="col-md-6">
                                <select id="produto" class="form-control" name="produto">
                                    <option></option>
                                    @foreach($produtos as $produto)
                                    <option value="{{ $produto->id }}">{{ $produto->nome }} ({{ $produto->unidade->nome }})</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('produto'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('produto') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div id="input_quantidade" class="form-group{{ $errors->has('quantidade') ? ' has-error' : '' }}" hidden>
                            <label for="quantidade" class="col-md-4 control-label">Quantidade</label>
                            <div class="col-md-6">
                                <input id="quantidade" type="text" class="form-control" name="quantidade" value="{{ old('quantidade') }}" disabled>
                                @if ($errors->has('quantidade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('quantidade') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-thumbs-up"></i> Adicionar
                                </button>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url('/home/produtos') }}">
                                <div class="btn btn-danger">
                                    <i class="fa fa-btn fa-thumbs-down"></i> Cancelar
                                </div>
                                </a>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
