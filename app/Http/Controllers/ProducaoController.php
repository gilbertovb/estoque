<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class ProducaoController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function produtos() {
        $produtos = \App\Produto::orderBy('nome', 'ASC')->where('tipo', 'PP')->get();

        return view('home.producao.produtos')->with('produtos', $produtos);
    }

    public function produto($id) {
        $produtos = \App\Produto::orderBy('nome', 'ASC')->where('tipo', 'PP')->get();
        $produto1 = \App\Produto::find($id);
        $users = \App\User::orderBy('name', 'ASC')->get();

        return view('home.producao.produtos')->with('produtos', $produtos)->with('produto1', $produto1)->with('users', $users);
    }

    public function produzir(Request $request) {
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

        if (\Illuminate\Support\Facades\Auth::once(['id' => $request->user, 'password' => $request->password])) {
            $producao = new \App\Producao;
            $producao->produto_id = $request->produto;
            $producao->user_id = $request->user;
            $producao->quantidade = $quantidade;
            $producao->produzido = FALSE;
            $producao->obs = $request->obs;
            $producao->save();

            $produto = \App\Produto::find($request->produto);

            foreach ($produto->fichatecnica as $value) {
                $solicitacao = new \App\Solicitacao;
                $solicitacao->producao_id = $producao->id;
                $solicitacao->produto_id = $value->id;
                $solicitacao->user_id = $request->user;
                $solicitacao->quantidade = $value->pivot->quantidade * $quantidade;
                $solicitacao->autorizado = FALSE;
                $solicitacao->save();
            }

            return redirect()->back()->withErrors(array('mensagem' => 'Solicitação de produção número <strong>' . $producao->id . '</strong> enviada para o estoque.'));
        } else {
            return redirect()->back()->withErrors(array('mensagem' => 'Senha incorreta.'));
        }
    }

}
