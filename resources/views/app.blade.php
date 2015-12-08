<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>ITVAT | @yield('title')</title>
    
    @section('styles')
        {!! Html::style('css/bootstrap.min.css') !!}
        {!! Html::style('css/app.css') !!}    
    @show
  </head>
  <body>

	<div id="wrap">
		<div class="container">
			<div class="row text-right">
                @if (Auth::check())
                    <div class="col-md-12">
                        <span>Seja bem vindo, {{ Auth::user()->name }}&nbsp;&nbsp;</span>
                        <a href="{{ url('/logout') }}" class="btn btn-primary">FAZER LOGOUT</a>
                    </div>
                @else
                    <div class="col-md-12">
                        <span>CLÍNICA OU PROFISSIONAL DE SAÚDE?&nbsp;&nbsp;</span>
                        <a href="{{ url('/medico-clinica-anuncio') }}" class="btn btn-primary">VER BENEFÍCIOS</a>
                    </div>
                @endif
			</div>
		</div>

		<nav class="navbar navbar-default">
		  <div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="{{ url('/') }}">ITVAT</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="#">COMO FUNCIONA</a></li>
<li><a href="#">BLOG</a></li>
@if (Auth::check())
	<li><a href="{{ url('/agendamentos') }}">MINHA CONTA</a></li>
@else
    <li><a href="{{ url('/login') }}">LOGIN</a></li>
@endif
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

		<div class="content container">
			@yield("content")
		</div>

		<div id="push"></div>
	</div>
	<footer id="footer container">
      <div class="container">
        <p class="text-muted">Copyright © 2015 Luiz Fernando Afra Brito</p>
      </div>
    </footer>
    
    @section('scripts')
        {!! Html::script('js/jquery-1.11.3.min.js') !!}
        {!! Html::script('js/bootstrap.min.js') !!}
    @show
  </body>
</html>
