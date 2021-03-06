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
                $('#quantidade').prop('disabled',false);
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
                <div class="panel-heading">Entrada de produtos</div>
                <div class="panel-body">
                    @if($errors->has('mensagem'))
                    <div style="color: red">{!! $errors->first('mensagem') !!}</div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/entrada') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('estoque') ? ' has-error' : '' }}">
                            <label for="estoque" class="col-md-4 control-label">Selecione o estoque</label>
                            <div class="col-md-6">
                                <select id="estoque" class="form-control" name="estoque">
                                    <option></option>
                                    @foreach($estoques as $estoque)
                                    <option value="{{ $estoque->id }}">{{ $estoque->nome }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('estoque'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estoque') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('produto') ? ' has-error' : '' }}">
                            <label for="produto" class="col-md-4 control-label">Produto</label>
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
