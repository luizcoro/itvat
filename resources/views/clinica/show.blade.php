
@extends ('app')

@section('title', $clinica->nome)

@section('content')
<div class="row">
    <div class="col-md-12">
<h3>{{ $clinica->nome }}</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="#" class="thumbnail">
            {!! Html::image($clinica->foto, 'Foto do clínica') !!}
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <label>Endereço:&nbsp;</label>{{ $clinica->endereco }}
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="map" style="width:100%; height:300px;"></div>
    </div>
</div>

@if (count($clinica->medicos) != 0)
    <div class="row">
        <div class="col-md-12">
            <h3>Médicos</h3>
            <ul>
                @foreach($clinica->medicos as $medico)
                    <li><a href="{{ url('/medico/' . $medico->id) }}">{{ $medico->userInfo->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
@endsection

@section ('scripts')
<script>

    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: {{ $clinica->lat }}, lng: {{ $clinica->lng }} },
            zoom: 13
        });

        var marker = new google.maps.Marker({
            position: {lat: {{ $clinica->lat }}, lng: {{ $clinica->lng }} },
            map: map,
            title: '{{ $clinica->nome }}'
        });

    }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6J7whdFiathMGxDwBgWsO24eu7e6S6JA    
    &callback=initMap"
    async defer></script>

@parent
@endsection
