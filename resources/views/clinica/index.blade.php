@extends ('app')

@section ('title', 'Clinicas')

@section('content')

@if (count($clinicas) == 0)
    <p>Não existem clinicas em nosso sistema</p>
@else
    <h3>Clínicas</h3> <br/>
    @foreach($clinicas as $clinica)
        <div class="row">
            <div class="col-md-3">
                <a href="{{ url('/clinica/' . $clinica->id) }}" class="thumbnail">
                    {!! Html::image($clinica->foto, 'Foto do médico') !!}
                </a>
            </div>

            <div class="col-md-9">
                <br>
<label for="">Nome:&nbsp;</label> {{ $clinica->nome  }} <br/>
<label for="">Endereço:&nbsp;</label> {{ $clinica->endereco  }} <br/>
<label for="">Telefone:&nbsp;</label> {{ $clinica->telefone  }} <br/>
            </div>
        </div>
    @endforeach
@endif

@endsection
