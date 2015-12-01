@extends('app')

@section('title', 'Agendamentos')

@section('content')

<div class="row">
    <div class="col-md-12">

        <h3>Minhas Consultas</h3>
        <br/>

        @if (count($agendamentos) == 0)
            <p>Você não possui consultas em nosso sistema</p>
        @else
            <table class="table">
                <tr>
                    <th>Médico</th>
                    <th>Especialidade</th>
                    <th>Endereço da clínica</th>
                    <th>Data/Hora</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @foreach ($agendamentos as $agendamento)
                    <tr>
                        <td>{{ $agendamento->medico->crm }}</td>
<td>{{ implode(', ', array_map(function($area){ return $area['nome'];}, $agendamento->medico->areas->toArray())) }}</td>
                        <td>{{ $agendamento->clinica->endereco }}</td>
                        <td>{{ $agendamento->data_hora }}</td>
                        <td>{{ $agendamento->status }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
</div>

@endsection
