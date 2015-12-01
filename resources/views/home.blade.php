@extends("app")


@section('title', 'Agende sua consulta online!')

@section("content")
<div class="container">
	<div class="row text-center" style=>
		<div class="col-md-12">
			<h2>ENCONTRE PROFISSIONAIS DE SAÚDE E AGENDE ONLINE</h2>
			<h3>Agende quando quiser e receba lembretes via SMS. É de graça!</h3>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-4">

			<h3>Comece por aqui, é <strong>fácil</strong>!</h3>
        
                {!! Form::open(['url' => url('/medicos'), 'method' => 'get']) !!}
                    <div class="form-group">
                        {!! Form::label('area', 'Selecione uma área') !!}
                        {!! Form::select('area', [
                            'fisioterapia'   => 'Fisioterapia',
                            'fonoaudiologia' => 'Fonoaudiologia',
                            'medicina'       => 'Medicina',
                            'nutricão'       => 'Nutricão',
                            'odontologia'    => 'Odontologia',
                            'outro'          => 'Outro'
                        ], null, ['placeholder' => '', 'class' => 'form-control']) !!}
                    </div>

				<div class="form-group">
                        {!! Form::label('especialidade', 'Selecione uma especialidade') !!}
                        {!! Form::select('especialidade', [
                            'fisioterapia' => 'Fisioterapia',
                            'osteopatia'   => 'Osteopatia',
                            'pilates'      => 'Pilates',
                            'outro'        => 'Outro'
                        ], null, ['placeholder' => '', 'class' => 'form-control']) !!}
				</div>

				<div class="form-group">
                        {!! Form::label('plano', 'Plano de saúde (opcional)') !!}
                        {!! Form::select('plano', [
                            'plano_1' => 'Plano de saúde 1',
                            'plano_2' => 'Plano de saúde 2',
                            'plano_3' => 'Plano de saúde 3',
                            'plano_4' => 'Plano de saúde 4',
                            'plano_5' => 'Plano de saúde 5',
                        ], null, ['placeholder' => '', 'class' => 'form-control']) !!}
                </div>
                {!! Form::submit('Pesquisar', ['class' => 'btn btn-default']) !!}
            {!! Form::close() !!}
		</div>

		<div class="col-md-offset-2 col-md-6">
			<h3>O que você está procurando?</h3>
            {!! Form::open(['url' => url('/medicos'), 'method' => 'get']) !!}
                {!! Form::label('pesquisa', 'Digite o nome de um profissional, uma clínica ou um sintoma') !!}
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
</div>

@endsection
