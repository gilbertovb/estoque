<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class FichaTecnicaController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function lista() {
        $fichastecnicas = \App\FichaTecnica::orderBy('nome', 'ASC')->get();

        return view('home.fichatecnica.lista')->with('fichastecnicas', $fichastecnicas);
    }

    public function novo() {

        return view('home.fichatecnica.novo');
    }

    public function grava(Request $request) {

        $dados = $request->all();
        $dados['nome'] = ucfirst($request->nome);
        $valid = validator($dados, [
            'nome' => 'required|max:255|unique:fichastecnicas'
        ]);

        if ($valid->fails())
            return redirect('/home/fichatecnica/novo')->withInput()->withErrors($valid);

        $fichatecnica = new \App\FichaTecnica;
        $fichatecnica->nome = $dados['nome'];
        $fichatecnica->obs = $dados['obs'];
        $fichatecnica->save();
        $fichastecnicas = \App\FichaTecnica::orderBy('nome', 'ASC')->get();

        return view('home.fichatecnica.lista')->with('mensagem', 'Ficha Tecnica <strong>' . $dados['nome'] . '</strong> cadastrado com sucesso.')
                        ->with('fichastecnicas', $fichastecnicas);
    }

    public function edita($id) {
        $fichatecnica = \App\FichaTecnica::find($id);

        return view('home.fichatecnica.edita')->with('fichatecnica', $fichatecnica);
    }

    public function atualiza($id, Request $request) {

        $dados = $request->all();
        $dados['name'] = ucfirst($request->nome);
        $valid = validator($dados, [
            'nome' => 'required|max:255|unique:fichastecnicas,nome,' . $id
        ]);

        if ($valid->fails())
            return redirect('/home/fichatecnica/' . $id)->withInput()->withErrors($valid);

        $fichatecnica = \App\FichaTecnica::find($id);
        $fichatecnica->nome = $dados['nome'];
        $fichatecnica->obs = $dados['obs'];
        $fichatecnica->save();
        $fichastecnicas = \App\FichaTecnica::orderBy('nome', 'ASC')->get();

        return view('home.fichatecnica.lista')->with('mensagem', 'Ficha Técnica <strong>' . $dados['nome'] . '</strong> alterada com sucesso.')
                        ->with('fichastecnicas', $fichastecnicas);
    }

    public function apaga($id) {

        $fichatecnica = \App\FichaTecnica::find($id);
        $fichatecnica->delete();
        $fichastecnicas = \App\FichaTecnica::orderBy('nome', 'ASC')->get();

        return view('home.fichatecnica.lista')->with('mensagem', 'Ficha Técnica <strong>' . $fichatecnica->nome . '</strong> apagado com sucesso.')
                        ->with('fichastecnicas', $fichastecnicas);
    }

    public function composicao($id) {
        $fichatecnica = \App\FichaTecnica::find($id);
        foreach ($fichatecnica->produtos as $value) {
            $dados[] = $value->id;
        }
        if (isset($dados)) {
            $produtos = \App\Produto::whereNotIn('id', $dados)->orderBy('nome', 'ASC')->get();
        } else {
            $produtos = \App\Produto::orderBy('nome', 'ASC')->get();
        }

        return view('home.fichatecnica.composicao')->with('fichatecnica', $fichatecnica)->with('produtos', $produtos);
    }

    public function produto($id, Request $request) {

        $valid = validator($request->all(), [
            'produto' => 'required',
            'quantidade' => 'required'
        ]);

        if ($valid->fails())
            return redirect('/home/fichatecnica/' . $id)->withInput()->withErrors($valid);

        $dados['produto_id'] = $request->produto;
        $dados['quantidade'] = str_replace('.', '', $request->quantidade);
        $dados['quantidade'] = str_replace(',', '.', $dados['quantidade']);

        $fichatecnica = \App\FichaTecnica::find($id);
        $fichatecnica->produtos()->attach($dados['produto_id'], ['quantidade' => $dados['quantidade']]);
        foreach ($fichatecnica->produtos as $value) {
            $dados[] = $value->id;
        }
        if (isset($dados)) {
            $produtos = \App\Produto::whereNotIn('id', $dados)->orderBy('nome', 'ASC')->get();
        } else {
            $produtos = \App\Produto::orderBy('nome', 'ASC')->get();
        }

        return view('home.fichatecnica.composicao')->with('fichatecnica', $fichatecnica)->with('produtos', $produtos);
    }

}
