<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>JZ Implementos - Controle de Estoque</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ url('/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">
        {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

        <style>
            body {
                font-family: 'Lato';
            }

            .fa-btn {
                margin-right: 6px;
            }
        </style>
        <!-- JavaScripts -->
        <script src="{{ url('/js/jquery-2.2.3.min.js') }}"></script>
        <script src="{{ url('/js/bootstrap.min.js') }}"></script>
        {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container" style="height: 100px;">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ url('/images/logotipojz.jpg') }}" height="70">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                @if (Auth::user())
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Cadastros<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/home/departamentos') }}"><i class="fa fa-btn fa-suitcase"></i>Departamentos</a></li>
                            <li><a href="{{ url('/home/estoques') }}"><i class="fa fa-btn fa-database"></i>Estoques</a></li>
                            <li><a href="{{ url('/home/produtos') }}"><i class="fa fa-btn fa-square"></i>Produtos</a></li>
                            <li><a href="{{ url('/home/unidades') }}"><i class="fa fa-btn fa-minus"></i>Unidades</a></li>
                            <li><a href="{{ url('/home/usuarios') }}"><i class="fa fa-btn fa-user"></i>Usuários</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Movimentação<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/home/entrada') }}"><i class="fa fa-btn fa-sign-in"></i>Entrada</a></li>
                            <li><a href="{{ url('/home/saida') }}"><i class="fa fa-btn fa-sign-out"></i>Saída</a></li>
                            <li><a href="{{ url('/home/solicitacoes') }}"><i class="fa fa-btn fa-list"></i>Solicitações</a></li>
                            <li>-----------------------------</li>
                            <li><a href="{{ url('/home/relatorio') }}"><i class="fa fa-btn fa-list"></i>Relatório</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home/verestoques') }}">Ver Estoques</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home/producao') }}">Produção</a></li>
                </ul>
                @endif

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Entrar</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/home/perfil') }}"><i class="fa fa-btn fa-user"></i>Perfil</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Sair</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
    <footer style="text-align: center;"><img src="{{ url('/images/insighti.png') }}"></footer>
</body>
</html>
