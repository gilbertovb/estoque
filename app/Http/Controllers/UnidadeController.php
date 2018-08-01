<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class UnidadeController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function lista() {
        $unidades = \App\Unidade::orderBy('nome', 'ASC')->get();

        return view('home.unidade.lista')->with('unidades', $unidades);
    }

    public function novo() {

        return view('home.unidade.novo');
    }

    public function grava(Request $request) {

        $dados = $request->all();
        $dados['nome'] = ucfirst($request->nome);
        $valid = validator($dados, [
            'nome' => 'required|max:255|unique:unidades'
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $unidade = new \App\Unidade;
        $unidade->nome = $dados['nome'];
        $unidade->save();

        return redirect('/home/unidades')->withErrors(array('mensagem' => 'Unidade <strong>' . $dados['nome'] . '</strong> cadastrada com sucesso.'));
    }

    public function edita($id) {
        $unidade = \App\Unidade::find($id);

        return view('home.unidade.edita')->with('unidade', $unidade);
    }

    public function atualiza($id, Request $request) {

        $dados = $request->all();
        $dados['name'] = ucfirst($request->nome);
        $valid = validator($dados, [
            'nome' => 'required|max:255|unique:unidades'
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $unidade = \App\Unidade::find($id);
        $unidade->nome = $dados['nome'];
        $unidade->save();

        return redirect('/home/unidades')->withErrors(array('mensagem' => 'Unidade <strong>' . $dados['nome'] . '</strong> alterada com sucesso.'));
    }

    public function apaga($id) {

        $produto = \App\Produto::where('unidade_id', $id)->get();
        $unidade = \App\Unidade::find($id);

        if ($produto->isEmpty()) {
            $unidade->delete();
            $unidades = \App\Unidade::orderBy('nome', 'ASC')->get();

            return redirect('/home/unidades')->withErrors(array('mensagem' => 'Unidade <strong>' . $unidade->nome . '</strong> apagado com sucesso.'));
        }

        return redirect('/home/unidades')->withErrors(array('mensagem' => 'Não foi possível apagar a unidade <strong>' . $unidade->nome . '</strong>, pois existe(m) produto(s) cadastrado(s) nele.'));
    }

}
