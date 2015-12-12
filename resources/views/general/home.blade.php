@extends("app")


@section('title', 'Agende sua consulta online!')

@section("content")
<div class="row text-center" style=>
    <div class="col-md-12">
        <h2>ENCONTRE PROFISSIONAIS DE SAÚDE E AGENDE ONLINE</h2>
        <h3>Agende quando quiser e receba lembretes via SMS. É de graça!</h3>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-6">
        <h3>Procurando por médicos?</h3>
        {!! Form::open(['url' => url('/medicos'), 'method' => 'get']) !!}
            {!! Form::label('pesquisa', 'Digite o nome do profissional') !!}
            <div class="input-group">
                {!! Form::text('pesquisa', null, ['class' => 'form-control input-lg']) !!}
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default btn-lg">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
                </span>
        </div>
        {!! Form::close() !!}
    
    </div>

    <div class="col-md-6">
        <h3>Procurando por clínicas??</h3>
        {!! Form::open(['url' => url('/clinicas'), 'method' => 'get']) !!}
            {!! Form::label('pesquisa', 'Digite o nome da clínica') !!}
            <div class="input-group">
                {!! Form::text('pesquisa', null, ['class' => 'form-control input-lg']) !!}
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default btn-lg">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
                </span>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection
