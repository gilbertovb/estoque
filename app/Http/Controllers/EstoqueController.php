<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class EstoqueController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function lista() {
        $estoques = \App\Estoque::orderBy('nome', 'ASC')->get();

        return view('home.estoque.lista')->with('estoques', $estoques);
    }

    public function novo() {

        return view('home.estoque.novo');
    }

    public function grava(Request $request) {

        $dados = $request->all();
        $dados['nome'] = ucfirst($request->nome);
        $valid = validator($dados, [
            'nome' => 'required|max:255|unique:estoques'
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $estoque = new \App\Estoque;
        $estoque->nome = $dados['nome'];
        $estoque->obs = $dados['obs'];
        $estoque->save();

        return redirect('/home/estoques')->withErrors(array('mensagem' => 'Estoque <strong>' . $dados['nome'] . '</strong> cadastrado com sucesso.'));
    }

    public function edita($id) {
        $estoque = \App\Estoque::find($id);

        return view('home.estoque.edita')->with('estoque', $estoque);
    }

    public function atualiza($id, Request $request) {

        $dados = $request->all();
        $dados['name'] = ucfirst($request->nome);
        $valid = validator($dados, [
            'nome' => 'required|max:255|unique:estoques,nome,' . $id
        ]);

        if ($valid->fails())
            return redirect('/home/estoque/' . $id)->withInput()->withErrors($valid);

        $estoque = \App\Estoque::find($id);
        $estoque->nome = $dados['nome'];
        $estoque->obs = $dados['obs'];
        $estoque->save();

        return redirect('/home/estoques')->withErrors(array('mensagem' => 'Estoque <strong>' . $dados['nome'] . '</strong> alterado com sucesso.'));
    }

    public function apaga($id) {

        $estoque = \App\Estoque::find($id);

        if ($estoque->produtos->isEmpty()) {
            $estoque->delete();
            return redirect()->back()->withErrors(array('mensagem' => 'Estoque <strong>' . $estoque->nome . '</strong> apagado com sucesso.'));
        } else {
            return redirect()->back()->withErrors(array('mensagem' => 'Não foi possível apagar o estoque <strong>' . $estoque->nome . '</strong>, pois o mesmo não esta vazio.'));
        }
    }

    public function ver() {
        $estoques = \App\Estoque::orderBy('nome', 'ASC')->get();

        return view('home.estoque.ver')->with('estoques', $estoques);
    }

    public function verestoque($id) {
        $estoque = \App\Estoque::find($id);

        return view('home.estoque.verestoque')->with('estoque', $estoque);
    }

    public function min($id1, $id2, Request $request) {
        $valid = validator($request->all(), [
            'min' => 'required'
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $min = str_replace('.', '', $request->min);
        $min = str_replace(',', '.', $min);

        $estoque = \App\Estoque::find($id1);
        $estoque->produtos()->updateExistingPivot($id2, ['min' => $min]);

        return redirect()->back();
    }

}
