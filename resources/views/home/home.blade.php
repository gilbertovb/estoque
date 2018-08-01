@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Controle de Estoque</div>

                <div class="panel-body">
                    {{ Auth::user()->name }} seja bem-vindo.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
