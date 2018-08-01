@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Ver estoques</div>

                <div class="panel-body">
                    @if(isset($mensagem))
                    <div style="color: red">{!! $mensagem !!}</div>
                    @endif
                    <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered">
                        @foreach($estoques as $estoque)
                        <tr>
                            <td style="text-align: right; vertical-align: middle;">
                                <p>{{ $estoque->nome }}</p>
                                <p>{!! str_replace("\n","<br>",$estoque->obs) !!}</p>
                            </td>
                            <td style="vertical-align: middle;">
                                <a href="{{ url('/home/verestoque/'.$estoque->id) }}">
                                    <div class="btn btn-primary">Ver produtos</div>
                                </a>
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
