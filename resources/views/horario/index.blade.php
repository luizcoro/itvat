@extends('app')

@section('title', 'Minha conta')

@section('content')
<ul class="nav nav-tabs">
    <li role="presentation"><a href="{{ url('/agendamentos') }}">Agendamentos</a></li>
    <li role="presentation"><a href="{{ url('/profile') }}">Profile</a></li>

@if (Auth::user()->tipo == 1)
    <li role="presentation" class="active"><a href="{{ url('/horarios') }}">Horarios</a></li>
    <li role="presentation"><a href="{{ url('/areas') }}">Areas</a></li>
    <li role="presentation"><a href="{{ url('/clinicas') }}">Clínicas</a></li>
@endif
</ul>
@if (Auth::user()->tipo == 1)
<div class="row">
    <div class="col-md-12">
        <h3>Meus horários</h3>
        @if (isset($horarios) && count($horarios) > 0)
            <br/>
            <table class="table">
                <tr>
                    <th>Dia</th>
                    <th>Entrada</th>
                    <th>Saida</th>
                </tr>
                @foreach ($horarios as $dia => $hs)
                    <tr>
                        <td>{{ $dia }}</td>
                        @for ($i = 0; $i < count($hs); $i++)
                            @if ($i != 0)
                                <tr><td></td>
                            @endif
                            <td>{{ $hs[$i]['entrada'] }}</td>
                            <td>{{ $hs[$i]['saida'] }}</td>
                        @endfor
                    </tr>
                @endforeach
            </table>
        @else
            <p>Você não possui horários de atendimento cadastrados</p>
        @endif
    </div>
</div>
@endif
@endsection
