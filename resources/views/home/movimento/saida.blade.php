@extends('layouts.app')

@section('content')
<link href="{{ url('/css/select2.min.css') }}" rel="stylesheet" />
<script type="text/javascript" src="{{ url('/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/jquery.mask.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#produto").select2();
        $("#user").select2();
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
                <div class="panel-heading">Saída de produtos</div>
                <div class="panel-body">
                    @if($errors->has('mensagem'))
                    <div style="color: red">{!! $errors->first('mensagem') !!}</div>
                    @endif
                    <div class="row">Estoque {{ $estoque->nome }}</div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/saida/'.$estoque->id) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('produto') ? ' has-error' : '' }}">
                            <label for="produto" class="col-md-4 control-label">Produto</label>
                            <div class="col-md-6">
                                <select id="produto" class="form-control" name="produto">
                                    <option></option>
                                    @foreach($estoque->produtos as $produto)
                                    <option value="{{ $produto->id }}">{{ $produto->nome }} - {{ str_replace('.',',',$produto->pivot->atual) }} {{ $produto->unidade->nome }}{{ ($produto->pivot->atual > 1) ? 's' : '' }}</option>
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
                        
                        <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
                            <label for="user" class="col-md-4 control-label">Usuário</label>
                            <div class="col-md-6">
                                <select id="user" class="form-control" name="user">
                                    <option></option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->login }})</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('user'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div id="input_password" class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Senha</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-thumbs-up"></i> Retirar
                                </button>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url('/home/saida') }}">
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
@endsection
