<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class ProdutoController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function lista() {
        $produtos = \App\Produto::orderBy('nome', 'ASC')->get();

        return view('home.produto.lista')->with('produtos', $produtos);
    }

    public function novo() {
        $unidades = \App\Unidade::orderBy('nome', 'ASC')->get();

        return view('home.produto.novo')->with('unidades', $unidades);
    }

    public function grava(Request $request) {

        $dados = $request->all();
        $dados['nome'] = ucfirst($request->nome);
        $valid = validator($dados, [
            'nome' => 'required|max:255|unique:produtos',
            'unidade' => 'required',
            'tipo' => 'required'
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $produto = new \App\Produto;
        $produto->nome = $dados['nome'];
        $produto->obs = $dados['obs'];
        $produto->tipo = $dados['tipo'];
        $produto->unidade_id = $dados['unidade'];
        $produto->save();

        return redirect('/home/produtos')->withErrors(array('mensagem' => 'Produto <strong>' . $dados['nome'] . '</strong> cadastrado com sucesso.'));
    }

    public function edita($id) {
        $produto = \App\Produto::find($id);
        $unidades = \App\Unidade::orderBy('nome', 'ASC')->get();

        return view('home.produto.edita')->with('produto', $produto)->with('unidades', $unidades);
    }

    public function atualiza($id, Request $request) {

        $dados = $request->all();
        $dados['name'] = ucfirst($request->nome);
        $valid = validator($dados, [
            'nome' => 'required|max:255|unique:produtos,nome,' . $id
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $produto = \App\Produto::find($id);
        $produto->nome = $dados['nome'];
        $produto->tipo = $dados['tipo'];
        $produto->obs = $dados['obs'];
        $produto->unidade_id = $dados['unidade'];
        $produto->save();

        return redirect('/home/produtos')->withErrors(array('mensagem' => 'Produto <strong>' . $dados['nome'] . '</strong> alterado com sucesso.'));
    }

    public function apaga($id) {

        $produto = \App\Produto::find($id);

        if ($produto->fichatecnica->isEmpty() && $produto->estoques->isEmpty()) {
            $produto->delete();
            return redirect('/home/produtos')->withErrors(array('mensagem' => 'Produto <strong>' . $produto->nome . '</strong> apagado com sucesso.'));
        } else {
            return redirect('/home/produtos')->withErrors(array('mensagem' => 'Não foi possível apagar o produto <strong>' . $produto->nome . '</strong>, pois ele pertence a alguma ficha técnica ou esta em algum estoque.'));
        }
    }

    public function composicao($id) {
        $produto = \App\Produto::find($id);

        $dados[] = $id;
        foreach ($produto->fichatecnica as $value) {
            $dados[] = $value->id;
        }
        $produtos = \App\Produto::whereNotIn('id', $dados)->orderBy('nome', 'ASC')->get();

        return view('home.produto.composicao')->with('produto', $produto)->with('produtos', $produtos);
    }

    public function produto($id, Request $request) {

        $valid = validator($request->all(), [
            'produto' => 'required',
            'quantidade' => 'required'
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $dados['produto2_id'] = $request->produto;
        $dados['quantidade'] = str_replace('.', '', $request->quantidade);
        $dados['quantidade'] = str_replace(',', '.', $dados['quantidade']);

        $produto = \App\Produto::find($id);
        $produto->fichatecnica()->attach($dados['produto2_id'], ['quantidade' => $dados['quantidade']]);

        return redirect('/home/produto/' . $id . '/composicao');
    }

    public function composicaodel($id, $id2) {

        $produto = \App\Produto::find($id);
        $produto->fichatecnica()->detach($id2);

        return redirect('/home/produto/' . $id . '/composicao');
    }

}
