@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Editar usuário</div>
                <div class="panel-body">
                    @if(Session::has('mensagem'))
                    <div style="color: red">{!! Session::get('mensagem') !!}</div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/usuario/'.$usuario->id) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome do usuário</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $usuario->name }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                            <label for="login" class="col-md-4 control-label">Login do usuário</label>
                            <div class="col-md-6">
                                <input id="login" type="text" class="form-control" name="login" value="{{ $usuario->login }}"{{ ($usuario->id == Auth::user()->id) ? ' disabled' : '' }}>

                                @if ($errors->has('login'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('departamento') ? ' has-error' : '' }}">
                            <label for="departamento" class="col-md-4 control-label">Departamento</label>
                            <div class="col-md-6">
                                <select id="departamento" class="form-control" name="departamento">
                                    @foreach($departamentos as $departamento)
                                    <option value="{{ $departamento->id }}"{{ ($departamento->id == $usuario->departamento_id) ? ' selected' : '' }}>{{ $departamento->nome }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('departamento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('departamento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Mudar senha</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirme a nova senha</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-thumbs-up"></i> Alterar
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
