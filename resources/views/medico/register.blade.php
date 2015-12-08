@extends('app')

@section('title', 'Cadastro de nova conta')

@section('content')
<div class="row">
    <div class="col-md-12">
    </div>
</div>
<div id="cadastrar-medico" class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">JÁ SOU CADASTRADO COMO PACIENTE</h3>
            </div>
            <div class="panel-body">
                {!! Form::open(['url' => url('/medico/cadastrar/login'), 'method' => 'post', 'files' => true]) !!}
                    <br/> <br/> <br/>
                    <div class="form-group">
                        {!! Form::label('crm', 'CRM') !!}
                        {!! Form::text('crm', old('crm'), ['class' => 'form-control']) !!}
                    </div>
                   
                    <div class="form-group">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Senha') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('foto', 'Foto') !!}
                        {!! Form::file('foto') !!}
                    </div>
                    <br/> <br/> <br/> <br/>
                    {!! Form::submit('Cadastrar', ['class' => 'btn btn-default']) !!}
                {!! Form::close() !!}
            </div>
        </div>
            @if ($errors->login->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->login->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">AINDA NAO TENHO CADASTRO DE PACIENTE</h3>
            </div>
            <div class="panel-body">
                {!! Form::open(['url' => url('/medico/cadastrar/novo'), 'method' => 'post', 'files' => true]) !!}
                    <div class="form-group">
                        {!! Form::label('crm', 'CRM') !!}
                        {!! Form::text('crm', old('crm'), ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('nome', 'Nome') !!}
                        {!! Form::text('nome', old('nome'), ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Senha') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('password_confirmation', 'Repita a senha') !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('foto', 'Foto') !!}
                        {!! Form::file('foto') !!}
                    </div>

                    {!! Form::submit('Cadastrar', ['class' => 'btn btn-default']) !!}
                {!! Form::close() !!}
            </div>
        </div>
            @if ($errors->novo->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->novo->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
    </div>
</div>
@endsection
