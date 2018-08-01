<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartamentoController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function lista() {
        $departamentos = \App\Departamento::orderBy('nome', 'ASC')->get();

        return view('home.departamento.lista')->with('departamentos', $departamentos);
    }

    public function novo() {

        return view('home.departamento.novo');
    }

    public function grava(Request $request) {

        $dados = $request->all();
        $dados['nome'] = ucfirst($request->nome);
        $valid = validator($dados, [
            'nome' => 'required|max:255|unique:departamentos'
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $departamento = new \App\Departamento;
        $departamento->nome = $dados['nome'];
        $departamento->save();

        return redirect('/home/departamentos')->withErrors(array('mensagem' => 'Departamento <strong>' . $dados['nome'] . '</strong> cadastrado com sucesso.'));
    }

    public function edita($id) {
        $departamento = \App\Departamento::find($id);

        return view('home.departamento.edita')->with('departamento', $departamento);
    }

    public function atualiza($id, Request $request) {

        $dados = $request->all();
        $dados['name'] = ucfirst($request->nome);
        $valid = validator($dados, [
            'nome' => 'required|max:255|unique:departamentos'
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $departamento = \App\Departamento::find($id);
        $departamento->nome = $dados['nome'];
        $departamento->save();

        return redirect('/home/departamentos')->withErrors(array('mensagem' => 'Departamento <strong>' . $dados['nome'] . '</strong> alterado com sucesso.'));
    }

    public function apaga($id) {

        $usuarios = \App\User::where('departamento_id', $id)->get();
        $departamento = \App\Departamento::find($id);

        if ($usuarios->isEmpty()) {
            $departamento->delete();

            return redirect('/home/departamentos')->withErrors(array('mensagem' => 'Departamento <strong>' . $departamento->nome . '</strong> apagado com sucesso.'));
        }

        return redirect('/home/departamentos')->withErrors(array('mensagem' => 'Não foi possível apagar o departamento <strong>' . $departamento->nome . '</strong>, pois existe usuários cadastrados nele.'));
    }

}
