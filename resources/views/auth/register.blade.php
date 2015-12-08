@extends('app')

@section('title', 'Cadastro de nova conta')

@section('content')
<div class="row">
    <div class="col-md-12">
        {!! Form::open(['url' => url('/cadastrar'), 'method' => 'post']) !!}
            <div class="form-group">
                {!! Form::label('name', 'Nome') !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
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

            {!! Form::submit('Cadastrar', ['class' => 'btn btn-default']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection
