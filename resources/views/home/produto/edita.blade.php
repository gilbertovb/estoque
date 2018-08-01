@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Editar produto</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/home/produto/'.$produto->id) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Nome do produto</label>
                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" value="{{ $produto->nome }}">

                                @if ($errors->has('nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('unidade') ? ' has-error' : '' }}">
                            <label for="unidade" class="col-md-4 control-label">Unidade do produto</label>
                            <div class="col-md-6">
                                <select id="unidade" class="form-control" name="unidade">
                                    @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->id }}"{{ ($unidade->id == $produto->unidade_id) ? ' selected' : '' }}>{{ $unidade->nome }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('unidade'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('unidade') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('tipo') ? ' has-error' : '' }}">
                            <label for="tipo" class="col-md-4 control-label">Tipo de produto</label>
                            <div class="col-md-6">
                                <select id="tipo" class="form-control" name="tipo">
                                    <option value="MP"{{ ($produto->tipo === 'MP') ? ' selected' : '' }}>Matéria Prima</option>
                                    <option value="PP"{{ ($produto->tipo === 'PP') ? ' selected' : '' }}>Produto Produzido</option>
                                    <option value="PR"{{ ($produto->tipo === 'PR') ? ' selected' : '' }}>Produto para Revenda</option>
                                </select>
                                @if ($errors->has('tipo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tipo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('obs') ? ' has-error' : '' }}">
                            <label for="obs" class="col-md-4 control-label">Observação</label>
                            <div class="col-md-6">
                                <textarea id="obs" class="form-control" name="obs">{{ $produto->obs }}</textarea>

                                @if ($errors->has('obs'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('obs') }}</strong>
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
@endsection
