@extends('app')

@section('title', 'Faça cadastro de médico ou clínica')

@section('content')

<div class="row">
    <div class="cold-md-12">
    <h2>Por que cadastrar na Itvat?</h2>
    <div class="jumbotron">
        <h1>Médico?</h1>
        <p><ul>
            <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>
            <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>
            <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>
            <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>
        </ul></p>
        <p><a class="btn btn-primary btn-lg" href="{{ url('/medico/cadastrar') }}" role="button">Quero me cadastrar</a></p>
    </div>

    <div class="jumbotron">
        <h1>Clínica?</h1>
        <p><ul>
            <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>
            <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>
            <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>
            <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>
        </ul></p>
        <p><a class="btn btn-primary btn-lg" href="{{ url('clinica/cadastrar') }}" role="button">Quero cadastrar minh clínica</a></p>
    </div>
</div>
@endsection
