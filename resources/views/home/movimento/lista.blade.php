@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Saída de produtos</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            Selecione o estoque para a retirada do produto.
                        </div>
                    </div>
                    <div class="row">
                        @foreach($estoques as $estoque)
                        <div class="col-md-2">
                            <a href="{{ url('/home/saida/'.$estoque->id) }}">
                                <div class="btn btn-primary">{{ $estoque->nome }}</div>
                            </a>
                            <p>{!! str_replace("\n","<br>",$estoque->obs) !!}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
