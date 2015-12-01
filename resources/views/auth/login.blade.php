@extends('app')

@section('title', 'Faça login em sua conta')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">JÁ SOU CADASTRADO</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['url' => url('login'), 'method' => 'post']) !!}
                       
                         <div class="form-group">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('password', 'Senha') !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('remember') !!}
                                Continuar conectado
                            </label>
                        </div>

                        {!! Form::submit('Entrar', ['class' => 'btn btn-default']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
        </div>
        <div class="col-md-6 text-center">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">QUERO ME CADASTRAR</h3>
                </div>
                <div class="panel-body">
                    <br/> <br/> </br>
                    Cadastrar é rápido e fácil! Comece agora <br/><br/>
                    <a href="{{ url('cadastrar') }}" class="btn btn-default">Cadastre-se</a>
                    <br/> <br/> <br/><br/> <br/>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection
