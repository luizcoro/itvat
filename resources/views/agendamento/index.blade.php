@extends('app')

@section('title', 'Minha conta')

@section('content')
<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="{{ url('/agendamentos') }}">Agendamentos</a></li>
    <li role="presentation"><a href="{{ url('/profile') }}">Profile</a></li>

@if (Auth::user()->tipo == 1)
    <li role="presentation"><a href="{{ url('/horarios') }}">Horarios</a></li>
    <li role="presentation"><a href="{{ url('/areas') }}">Areas</a></li>
    <li role="presentation"><a href="{{ url('/clinicas') }}">Clínicas</a></li>
@endif
</ul>
@if (Auth::user()->tipo == 1)
<div class="row">
    <div class="col-md-12">
        <h3>Minhas consultas como médico</h3>
        @if (isset($agendamentos_medico) && count($agendamentos_medico) > 0)
            <br/>
            <table class="table">
                <tr>
                    <th>Paciente</th>
                    <th>Email paciente</th>
                    <th>Clínica</th>
                    <th>Início</th>
                    <th>Término</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @foreach ($agendamentos_medico as $agendamento_medico)
                    <tr>
                        <td>{{ $agendamento_medico->paciente->userInfo->name }}</td>
                        <td>{{ $agendamento_medico->paciente->userInfo->email }}</td>
                        <td><a href="{{ url('/clinica/' . $agendamento_medico->clinica->id) }}">{{ $agendamento_medico->clinica->nome }}</a></td>
                        <td>{{ $agendamento_medico->inicio}}</td>
                        <td>{{ $agendamento_medico->termino}}</td>
                        <td>{{ agendamento_string($agendamento_medico->status) }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>Você não possui consultas como médico em nosso sistema</p>
        @endif
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        @if (Auth::user()->tipo == 1)
            <h3>Minhas consultas como paciente</h3>
        @else
            <h3>Minhas consultas</h3>
        @endif
        <br/>

        @if (isset($agendamentos_paciente) && count($agendamentos_paciente) > 1)
            <table class="table">
                <tr>
                    <th>Médico</th>
                    <th>Especialidade</th>
                    <th>Clínica</th>
                    <th>Início</th>
                    <th>Término</th>
                    <th></th>
                </tr>
                @foreach ($agendamentos_paciente as $agendamento_paciente)
                    <tr>
                        <td><a href="{{ url('/medico/' .$agendamento_paciente->medico->id) }}">{{ $agendamento_paciente->medico->userInfo->name }}</a></td>
                        <td>{{ implode(', ', array_map(function($area){ return $area['nome'];}, $agendamento_paciente->medico->areas->toArray())) }}</td>
                        <td><a href="{{ url('/clinica/' . $agendamento_paciente->clinica->id) }}">{{ $agendamento_paciente->clinica->nome }}</a></td>
                        <td>{{ $agendamento_paciente->inicio}}</td>
                        <td>{{ $agendamento_paciente->termino}}</td>
                        <td>{{ agendamento_string($agendamento_paciente->status) }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </table>
        @else
            @if (Auth::user()->tipo == 1)
                <p>Você não possui consultas como paciente em nosso sistema</p>
            @else
                <p>Você não possui consultas em nosso sistema</p>
            @endif
        @endif
    </div>
</div>

@endsection
