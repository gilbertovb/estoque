<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MovimentoController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function entrada() {
        $estoques = \App\Estoque::orderBy('nome', 'ASC')->get();
        $produtos = \App\Produto::orderBy('produtos', 'ASC')->get();

        return view('home.movimento.entrada')->with('estoques', $estoques)->with('produtos', $produtos);
    }

    public function gravaentrada(Request $request) {
        $valid = validator($request->all(), [
            'produto' => 'required',
            'estoque' => 'required',
            'quantidade' => 'required'
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $atual = str_replace('.', '', $request->quantidade);
        $atual = str_replace(',', '.', $atual);

        $estoque = \App\Estoque::find($request->estoque);

        $movimento = new \App\Movimento;
        $movimento->estoque_id = $request->estoque;
        $movimento->produto_id = $request->produto;
        $movimento->user_id = \Illuminate\Support\Facades\Auth::user()->id;
        $movimento->quantidade = $atual;
        $movimento->save();

        foreach ($estoque->produtos as $produto) {
            if ($produto->id == $request->produto) {
                $atual = $atual + $produto->pivot->atual;
                $estoque->produtos()->updateExistingPivot($request->produto, ['atual' => $atual]);
                return redirect('/home/entrada')->withErrors(array('mensagem' => 'Produto adicionado ao estoque com sucesso.'));
            }
        }

        $estoque->produtos()->attach($request->produto, ['atual' => $atual]);
        return redirect('/home/entrada')->withErrors(array('mensagem' => 'Produto adicionado ao estoque com sucesso.'));
    }

    public function saida() {
        $estoques = \App\Estoque::orderBy('nome', 'ASC')->get();

        return view('home.movimento.lista')->with('estoques', $estoques);
    }

    public function saidaestoque($id) {
        $estoque = \App\Estoque::find($id);
        $users = \App\User::all();

        return view('home.movimento.saida')->with('estoque', $estoque)->with('users', $users);
    }

    public function gravasaida($id, Request $request) {
        $valid = validator($request->all(), [
            'produto' => 'required',
            'quantidade' => 'required',
            'user' => 'required',
            'password' => 'required'
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $quantidade = str_replace('.', '', $request->quantidade);
        $quantidade = str_replace(',', '.', $quantidade);

        $estoque = \App\Estoque::find($id);

        foreach ($estoque->produtos as $produto) {
            if ($produto->id == $request->produto) {
                if ($produto->pivot->atual < $quantidade) {
                    return redirect()->back()->withErrors(array('mensagem' => 'Quantidade para retirada maior que o produto em estoque.'));
                } else {
                    $atual = $produto->pivot->atual - $quantidade;
                }
            }
        }

        if (\Illuminate\Support\Facades\Auth::once(['id' => $request->user, 'password' => $request->password])) {
            $movimento = new \App\Movimento;
            $movimento->estoque_id = $id;
            $movimento->produto_id = $request->produto;
            $movimento->user_id = $request->user;
            $movimento->quantidade = -$quantidade;
            $movimento->save();

            $estoque->produtos()->updateExistingPivot($request->produto, ['atual' => $atual]);

            return redirect('/home/saida/' . $id)->withErrors(array('mensagem' => 'Saída concluída com sucesso.'));
        } else {
            return redirect('/home/saida/' . $id)->withErrors(array('mensagem' => 'Senha incorreta.'));
        }
    }

    public function relatorio() {
        $movimentos = \App\Movimento::all();

        return view('home.movimento.relatorio')->with('movimentos', $movimentos);
    }

    public function solicitacoes() {
        $solicitacoes = \App\Solicitacao::where('autorizado', false)->orderBy('id', 'ASC')->get();

        return view('home.movimento.solicitacoes')->with('solicitacoes', $solicitacoes);
    }

    public function solicitacao($id) {
        $producao = \App\Producao::find($id);
        $solicitacoes = \App\Producao::find($id)->solicitacoes;

        return view('home.movimento.solicitacao')->with('producao', $producao)->with('solicitacoes', $solicitacoes);
    }

    public function autoriza(Request $request) {
        foreach ($request->solicitacao as $value1) {
            $x = explode(':', $value1);
            $value1 = $x[0];
            $estoque = \App\Estoque::find($x[1]);

            $solicitacoes[] = \App\Solicitacao::find($value1);
            $estoques[] = \App\Estoque::find($x[1]);
            $solicitacao = \App\Solicitacao::find($value1);
            $solicitacao->autorizado = TRUE;
            $solicitacao->save();
            
            $estoque_produto = $estoque->produtos->find($solicitacao->produto_id);
            $atual = $estoque_produto->pivot->atual - $solicitacao->quantidade;
            $estoque->produtos()->updateExistingPivot($solicitacao->produto_id, ['atual' => $atual]);

            $movimento = new \App\Movimento;
            $movimento->estoque_id = $x[1];
            $movimento->produto_id = $solicitacao->produto_id;
            $movimento->user_id = $solicitacao->user_id;
            $movimento->quantidade = -$solicitacao->quantidade;
            $movimento->save();


        }
        return view('home.movimento.autorizado')->with('solicitacoes', $solicitacoes)->with('estoques',$estoques);
    }

}
