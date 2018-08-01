<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */


Route::group(['middleware' => ['web']], function () {
    
});
Route::get('/', function () {
    return view('welcome');
});
Route::auth();
Route::group(['prefix' => '/home'], function () {
    Route::get('/', 'HomeController@index');
    // Rotas dos departamentos
    Route::get('/departamentos', 'DepartamentoController@lista');
    Route::get('/departamento/novo', 'DepartamentoController@novo');
    Route::post('/departamento/novo', 'DepartamentoController@grava');
    Route::get('/departamento/{id}', 'DepartamentoController@edita');
    Route::post('/departamento/{id}', 'DepartamentoController@atualiza');
    Route::get('/departamento/{id}/del', 'DepartamentoController@apaga');

    // Rotas dos estoques
    Route::get('/estoques', 'EstoqueController@lista');
    Route::get('/estoque/novo', 'EstoqueController@novo');
    Route::post('/estoque/novo', 'EstoqueController@grava');
    Route::get('/estoque/{id}', 'EstoqueController@edita');
    Route::post('/estoque/{id}', 'EstoqueController@atualiza');
    Route::get('/estoque/{id}/del', 'EstoqueController@apaga');
    Route::get('/verestoques', 'EstoqueController@ver');
    Route::get('/verestoque/{id}', 'EstoqueController@verestoque');
    Route::post('/verestoque/{id1}/{id2}', 'EstoqueController@min');

    // Rotas das Fichas Tecnicas
    /*
      Route::get('/fichastecnicas', 'FichaTecnicaController@lista');
      Route::get('/fichatecnica/novo', 'FichaTecnicaController@novo');
      Route::post('/fichatecnica/novo', 'FichaTecnicaController@grava');
      Route::get('/fichatecnica/{id}', 'FichaTecnicaController@edita');
      Route::post('/fichatecnica/{id}', 'FichaTecnicaController@atualiza');
      Route::get('/fichatecnica/{id}/del', 'FichaTecnicaController@apaga');
      Route::get('/fichatecnica/{id}/composicao', 'FichaTecnicaController@composicao');
      Route::post('/fichatecnica/{id}/composicao', 'FichaTecnicaController@produto');
     */
    // Rotas dos produtos
    Route::get('/produtos', 'ProdutoController@lista');
    Route::get('/produto/novo', 'ProdutoController@novo');
    Route::post('/produto/novo', 'ProdutoController@grava');
    Route::get('/produto/{id}', 'ProdutoController@edita');
    Route::post('/produto/{id}', 'ProdutoController@atualiza');
    Route::get('/produto/{id}/del', 'ProdutoController@apaga');
    Route::get('/produto/{id}/composicao', 'ProdutoController@composicao');
    Route::post('/produto/{id}/composicao', 'ProdutoController@produto');
    Route::get('/produto/{id}/composicao/{id2}/del', 'ProdutoController@composicaodel');

    // Rotas das unidades
    Route::get('/unidades', 'UnidadeController@lista');
    Route::get('/unidade/novo', 'UnidadeController@novo');
    Route::post('/unidade/novo', 'UnidadeController@grava');
    Route::get('/unidade/{id}', 'UnidadeController@edita');
    Route::post('/unidade/{id}', 'UnidadeController@atualiza');
    Route::get('/unidade/{id}/del', 'UnidadeController@apaga');

    // Rotas dos usuarios
    Route::get('/usuarios', 'UsuarioController@lista');
    Route::get('/usuario/novo', 'UsuarioController@novo');
    Route::post('/usuario/novo', 'UsuarioController@grava');
    Route::get('/usuario/{id}', 'UsuarioController@edita');
    Route::post('/usuario/{id}', 'UsuarioController@atualiza');
    Route::get('/usuario/{id}/del', 'UsuarioController@apaga');
    Route::get('/perfil', 'UsuarioController@perfil');

    // Movimentação do estoque
    Route::get('/entrada', 'MovimentoController@entrada');
    Route::post('/entrada', 'MovimentoController@gravaentrada');
    Route::get('/saida', 'MovimentoController@saida');
    Route::get('/saida/{id}', 'MovimentoController@saidaestoque');
    Route::post('/saida/{id}', 'MovimentoController@gravasaida');    
    // Relatorio
    Route::get('/relatorio','MovimentoController@relatorio');
    // Solicitações
    Route::get('/solicitacoes','MovimentoController@solicitacoes');
    Route::get('/solicitacao/{id}','MovimentoController@solicitacao');
    Route::post('/solicitacao/{id}','MovimentoController@autoriza');
    
    // Rotas de produção
    Route::get('/producao','ProducaoController@produtos');
    Route::post('/producao','ProducaoController@produzir');
    Route::get('/producao/{id}','ProducaoController@produto');
    
});

