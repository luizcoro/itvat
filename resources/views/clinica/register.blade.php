@extends('app')

@section('title', 'Cadastro de nova conta')

@section('content')
<div class="row">
    <div class="col-md-12">
        {!! Form::open(['url' => url('/clinica/cadastrar'), 'method' => 'post']) !!}
            <div class="form-group">
                {!! Form::label('nome', 'Nome da clínica') !!}
                {!! Form::email('nome', old('nome'), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('endereco', 'Endereço') !!}
                {!! Form::password('endereco', ['class' => 'form-control']) !!}
            </div>

            {!! Form::submit('Cadastrar', ['class' => 'btn btn-default']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection
