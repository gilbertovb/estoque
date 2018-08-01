<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function lista() {
        $usuarios = \App\User::orderBy('name', 'ASC')->get();

        return view('home.usuario.lista')->with('usuarios', $usuarios);
    }

    public function novo() {
        $departamentos = \App\Departamento::orderBy('nome', 'ASC')->get();

        return view('home.usuario.novo')->with('departamentos', $departamentos);
    }

    public function grava(Request $request) {
        $dados = $request->all();
        $dados['name'] = ucfirst($request->name);
        $valid = validator($dados, [
            'name' => 'required|max:255',
            'login' => 'required|unique:users',
            'departamento' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($valid->fails())
            return redirect()->back()->withInput()->withErrors($valid);

        $usuario = new \App\User;
        $usuario->name = $dados['name'];
        $usuario->login = $dados['login'];
        $usuario->departamento_id = $dados['departamento'];
        $usuario->password = bcrypt($dados['password']);
        $usuario->save();

        return redirect('/home/usuarios')->withErrors(array('mensagem' => 'Usuário <strong>' . $dados['name'] . '</strong> cadastrado com sucesso.'));
    }

    public function edita($id) {
        $usuario = \App\User::find($id);
        $departamentos = \App\Departamento::orderBy('nome', 'ASC')->get();

        return view('home.usuario.edita')->with('usuario', $usuario)->with('departamentos', $departamentos);
    }

    public function atualiza($id, Request $request) {

        $referer = explode('/', $request->header('referer'));
        $origem = end($referer);
        $origem = '/' . prev($referer) . '/' . $origem;

        $dados = $request->all();
        $dados['name'] = ucfirst($request->name);

        if (($dados['password'] === '') && ($dados['password_confirmation'] === '')) {
            if (isset($dados['login'])) {
                $valid = validator($dados, [
                    'name' => 'required|max:255',
                    'departamento' => 'required',
                    'login' => 'required|unique:users,login,' . $id
                ]);
            } else {
                $valid = validator($dados, [
                    'name' => 'required|max:255',
                    'departamento' => 'required',
                ]);
            }
        } else {
            if (isset($dados['login'])) {
                $valid = validator($dados, [
                    'name' => 'required|max:255',
                    'departamento' => 'required',
                    'password' => 'required|min:6|confirmed',
                    'login' => 'required|unique:users,login,' . $id
                ]);
            } else {
                $valid = validator($dados, [
                    'name' => 'required|max:255',
                    'departamento' => 'required',
                    'password' => 'required|min:6|confirmed',
                ]);
            }
        }

        if ($valid->fails())
            return redirect()->back()->withErrors($valid)->withInput();

        $usuario = \App\User::find($id);
        $usuario->name = $dados['name'];
        if (isset($dados['login']))
            $usuario->login = $dados['login'];
        $usuario->departamento_id = $dados['departamento'];
        if ($dados['password'] != '')
            $usuario->password = bcrypt($dados['password']);

        $usuario->save();

        if ($origem === '/home/perfil') {
            return redirect('/home/perfil')->withErrors(array('mensagem' => 'Perfil alterado com sucesso.'));
        } else {
            return redirect('/home/usuarios')->withErrors(array('mensagem' => 'Usuário <strong>' . $dados['name'] . '</strong> alterado com sucesso.'));
        }
    }

    public function apaga($id) {

        $usuario = \App\User::find($id);

        if (Auth::user()->id == $usuario->id) {
            $usuarios = \App\User::orderBy('name', 'ASC')->get();

            return redirect('/home/usuarios')->withErrors(array('mensagem' => 'Não é possível apagar o <strong>próprio</strong> usuário .'));
        } elseif ($usuario->movimentos->isEmpty()) {
            $usuario->delete();

            return redirect('/home/usuarios')->withErrors(array('mensagem' => 'Usuário <strong>' . $usuario->name . '</strong> apagado com sucesso.'));
        }else{
            return redirect('/home/usuarios')->withErrors(array('mensagem' => 'Não é possível apagar o usuário <strong>'.$usuario->name.'</strong>, pois o mesmo possui historico de movimentos no estoque.'));
        }
    }

    public function perfil() {
        $usuario = Auth::user();
        $departamentos = \App\Departamento::orderBy('nome', 'ASC')->get();

        return view('home.usuario.edita')->with('usuario', $usuario)->with('departamentos', $departamentos);
    }

}
