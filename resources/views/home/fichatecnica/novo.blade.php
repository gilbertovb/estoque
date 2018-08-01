@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastro de Ficha Técnica</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/fichatecnica/novo') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Nome da nova Ficha Técnica</label>
                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}">
                                @if ($errors->has('nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome') }}</strong>
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
                                    <i class="fa fa-btn fa-thumbs-up"></i> Criar
                                </button>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ url('/home/fichastecnicas') }}">
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
