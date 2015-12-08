@extends('app')

@section('title', 'Minha conta')

@section('content')
<ul class="nav nav-tabs">
    <li role="presentation"><a href="{{ url('/agendamentos') }}">Agendamentos</a></li>
    <li role="presentation" class="active"><a href="{{ url('/profile') }}">Profile</a></li>

@if (Auth::user()->tipo == 1)
    <li role="presentation"><a href="{{ url('/horarios') }}">Horarios</a></li>
    <li role="presentation"><a href="{{ url('/areas') }}">Areas</a></li>
    <li role="presentation"><a href="{{ url('/clinicas') }}">Clínicas</a></li>
@endif
</ul>
</br></br>
@if (Auth::user()->tipo == 1)
<div class="row">
<div class="col-md-12">
        @if ($profile['tipo'] == 'Médico')
            {!! Form::image($profile['foto']) !!} <br/><br/>
            <label>CRM&nbsp;</label>{{ $profile['crm'] }}<br/>
        @endif
        <label>Nome&nbsp;</label>{{ $profile['nome'] }}<br/>
        <label>Email&nbsp;</label>{{ $profile['email'] }}<br/>
        <label>Nome&nbsp;</label>{{ $profile['nascimento'] }}<br/>
        <label>Telefone&nbsp;</label>{{ $profile['telefone'] }}<br/>
        @if ($profile['tipo'] == 'Paciente')
            <label>Sangue:&nbsp;</label>{{ $profile['sangue'] }}<br/>
        @endif
        <br/> <br/>
        <label>Tipo de conta:&nbsp;</label>{{ $profile['tipo'] }}<br/>
    </div>
</div>
@endif
@endsection
