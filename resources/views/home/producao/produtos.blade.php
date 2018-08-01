@extends('layouts.app')

@section('content')
<link href="{{ url('/css/select2.min.css') }}" rel="stylesheet" />
<script type="text/javascript" src="{{ url('/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/jquery.mask.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#produto").select2();
    $("#user").select2();
    $('#produto').on('change', function () {
        if (this.value != '') {
            window.location = "{{url('/home/producao/') }}/" + document.getElementById("produto").value;
        }
    });
    $('#quantidade').mask('0.000.000', {reverse: true});

});
</script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Solicitação de produção</div>

                <div class="panel-body">
                    @if($errors->has('mensagem'))
                    <div style="color: red">{!! $errors->first('mensagem') !!}</div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/producao') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('produto') ? ' has-error' : '' }}">
                                    <label for="produto" class="col-md-4 control-label">Produto</label>
                                    <div class="col-md-6">
                                        <select id="produto" class="form-control" name="produto">
                                            @if(isset($produto1))
                                            @foreach($produtos as $produto)
                                            <option value="{{ $produto->id }}"{{ ($produto->id == $produto1->id) ? ' selected' : '' }}>{{ $produto->nome }} ({{ $produto->unidade->nome }})</option>
                                            @endforeach
                                            @else
                                            <option></option>
                                            @foreach($produtos as $produto)
                                            <option value="{{ $produto->id }}">{{ $produto->nome }} ({{ $produto->unidade->nome }})</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('produto'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('produto') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    @if(isset($produto1))
                                    <label class="col-md-4 control-label">Composição</label>
                                    <div class="col-md-6">
                                        @foreach($produto1->fichatecnica as $produto2)
                                        {{ $produto2->nome }} - {{ str_replace('.',',',$produto2->pivot->quantidade) }} {{ $produto2->unidade->nome }}{{ ($produto2->pivot->quantidade > 1) ? 's' : '' }}<br>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('quantidade') ? ' has-error' : '' }}">
                                    <label for="quantidade" class="col-md-4 control-label">Quantidade</label>
                                    <div class="col-md-6">
                                        <input id="quantidade" type="text" class="form-control" name="quantidade" value="{{ old('quantidade') }}">
                                        @if ($errors->has('quantidade'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('quantidade') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('obs') ? ' has-error' : '' }}">
                                    <label for="obs" class="col-md-4 control-label">Observação</label>
                                    <div class="col-md-6">
                                        <textarea id="obs" class="form-control" name="obs">{{ old('obs') }}</textarea>

                                        @if ($errors->has('obs'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('obs') }}</strong>
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

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
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
                                            <i class="fa fa-btn fa-thumbs-up"></i> Produzir
                                        </button>
                                    </div>
                                    @endif
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
