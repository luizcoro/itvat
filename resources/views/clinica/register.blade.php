@extends('app')

@section('title', 'Cadastro de nova conta')

@section('content')
<div class="row">
    <div class="col-md-12">
        {!! Form::open(['url' => url('/clinica/cadastrar'), 'method' => 'post', 'files' => true]) !!}
            <div class="form-group">
                {!! Form::label('nome', 'Nome da clínica') !!}
                {!! Form::text('nome', old('nome'), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('endereco', 'Endereço') !!}
                {!! Form::text('endereco', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('foto', 'Foto') !!}
                {!! Form::file('foto') !!}
            </div>

            {!! Form::submit('Cadastrar', ['class' => 'btn btn-default']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection
