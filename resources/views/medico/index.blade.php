@extends ('app')

@section ('title', 'Medicos')

@section('content')

@if (count($medicos) == 0)
    <p>Não existem médicos em nosso sistema</p>
@else
    <h3>Médicos</h3> <br />
    @foreach($medicos as $medico)
        <div class="row">
            <div class="col-md-3">
                <a href="{{ url('/medico/' . $medico->id) }}" class="thumbnail">
                    {!! Html::image($medico->foto, 'Foto do médico') !!}
                </a>
            </div>

            <div class="col-md-9">
                <br>
                <label for="">Nome:&nbsp;</label> {{ $medico->userInfo->name  }} <br/>
                <label for="">CRM:&nbsp;</label> {{ $medico->crm  }} <br/>
                <label for="">Email:&nbsp;</label> {{ $medico->userInfo->email  }} <br/>
                <label for="">Telefone:&nbsp;</label> {{ $medico->userInfo->telefone  }} <br/>

                @if (count($medico->areas) != 0)
                    <label>Áreas de atuação:</label>
                    <ul class="list-unstyled">
                    @foreach ($medico->areas as $area)
                        <li>&nbsp;&nbsp;&nbsp;{{ $area->nome }}</li>
                    @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endforeach
@endif

@endsection
