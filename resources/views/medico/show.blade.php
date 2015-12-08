@extends ('app')

@section('title', $medico->userInfo->name)

@section('styles')
@parent
{!! Html::style('css/fullcalendar.min.css') !!}

<style>
.fc-basic-view .fc-body .fc-row {
    min-height: 1.8em;
}
.fc h2 {
    font-size:20px;
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-5">
        <h3>{{ $medico->userinfo->name }}</h3>
        <a href="#" class="thumbnail">
            {!! Html::image($medico->foto, 'Foto do médico') !!}
        </a>
        <label for="">CRM:&nbsp;</label> {{ $medico->crm  }} <br/>
        <label for="">Email:&nbsp;</label> {{ $medico->userInfo->email  }} <br/>
        <label for="">Telefone:&nbsp;</label> {{ $medico->userInfo->telefone  }} <br/>

        @if (count($medico->areas) != 0)
        <label>Áreas de atuação:</label>
        @foreach ($medico->areas as $area)
            {{ $area->nome }} &nbsp;&nbsp;
        @endforeach
        @endif
    </div>
    <div class="col-md-7">
        <h3>Horários disponíveis</h3>
        <div id='calendar'></div>       
    </div>
</div>

@if (count($medico->clinicas) != 0)

<div class="row">
    <div class="col-md-12">
        <h3>Clinicas de atuação</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        
        <ul>
        @foreach ($medico->clinicas as $clinica)
<li><label><a href="{{ url('/clinica/' . $clinica->id) }}">{{ $clinica->nome}}</a>: &nbsp;</label>{{ $clinica->endereco }}</li>
        @endforeach
        </ul>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-md-12">
        <div id="map" style="width:100%; height:300px;"></div>
    </div>
</div>

@endif

<br/>
<br/>
<div class="row">
    <div class="col-md-12">
        <h3>Informações adicionais</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
    </div>
</div>

<button id="go-to-month-bt" type="button" class="fc-button fc-state-default fc-corner-left fc-corner-right" hidden="hidden"><<</button>
@endsection


@section ('scripts')
@parent
{!! Html::script('js/moment.js') !!}
{!! Html::script('js/fullcalendar.min.js') !!}

@include('medico.scripts')

<script>
$(document).ready(function() {
    var button = $('#go-to-month-bt');
    
    function hasEventInDate(date)
    {
        var events = $('#calendar').fullCalendar('clientEvents');

        for (var i = 0; i < events.length; i++) {
            if(date.isSame(events[i].start, 'day')) {
                return true;
            }
        }
        return false;
    }


    $('#calendar').fullCalendar({
        allDaySlot:false,
        header: {
            left: '',
            center: 'title',
            right: 'today prev,next'
        },

        events: '{{ url('/medico/horarios-disponiveis/'. $medico->id) }}', 
        viewRender: function( currentView ) {
            if(currentView.type == 'agendaDay') {
                var minDate = moment(),
                maxDate = moment().add(2,'weeks');
while(!hasEventInDate(minDate)) minDate.add(1, 'd');
                // Past
                if (minDate >= currentView.start && minDate <= currentView.end) {
                    $(".fc-prev-button").prop('disabled', true); 
                    $(".fc-prev-button").addClass('fc-state-disabled'); 
                }
                else {
                    $(".fc-prev-button").removeClass('fc-state-disabled'); 
                    $(".fc-prev-button").prop('disabled', false); 
                }
                // Future
                if (maxDate >= currentView.start && maxDate <= currentView.end) {
                    $(".fc-next-button").prop('disabled', true); 
                    $(".fc-next-button").addClass('fc-state-disabled'); 
                } else {
                    $(".fc-next-button").removeClass('fc-state-disabled'); 
                    $(".fc-next-button").prop('disabled', false); 
                }
            }
        },

        eventRender: function( event, element, view ) { 
            if(view.type === 'month'){
                if(event.start.diff(moment(), 'day') >= 0) {
                    var dataToFind = moment(event.start).format('YYYY-MM-DD');
$('.fc-day[data-date="' + dataToFind + '"]').css('background-color', 'rgba(58,135,173,0.8)');
                    $("td[data-date='"+dataToFind+"']").css('color', '#FFF');
                }
                return false;
            }
        },
        dayClick : function (date, jsEvent, view) {
if(view.type === 'month' && date.diff(moment(), 'day') >= 0 && hasEventInDate(date)){
                $('#calendar').fullCalendar( 'changeView', 'agendaDay');
                $('#calendar').fullCalendar( 'gotoDate', date);
                $(button).show();
            }
        },

        eventClick: function(calEvent, jsEvent, view) {
                alert('Event: ' + calEvent.title);
        }
    });

    $('.fc-toolbar .fc-left').prepend(button);
    
    $(button).on('click', function() {
            $(button).hide();
            $('#calendar').fullCalendar( 'changeView', 'month');
    });

    function prev_date(date)
    {
        var a = moment(date);
        a.subtract(1, 'days');
        return a;
    }
    function next_date(date)
    {
        var a = moment(date);
        a.add(1, 'days');
        return a;
    }

    $('body').on('click', 'button.fc-prev-button', function() {
        if(($('#calendar').fullCalendar( 'getView' )).type == 'agendaDay')
        {
            var date = $('#calendar').fullCalendar( 'getDate');
            var hoje = moment();

            while(!hasEventInDate(date) && date > hoje)
            {
                date.subtract('1', 'days');
            }

            $('#calendar').fullCalendar( 'gotoDate', date);
        }//do something
    });

    $('body').on('click', 'button.fc-next-button', function() {
        if(($('#calendar').fullCalendar( 'getView' )).type == 'agendaDay')
        {
            var date = $('#calendar').fullCalendar( 'getDate');
            while(!hasEventInDate(date))
            {
                date.add('1', 'days');
            }

            $('#calendar').fullCalendar( 'gotoDate', date);
        }//do something
    });
});
</script>

@if (count($medico->clinicas) != 0)
<script>

    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -18.910327, lng: -48.266320 },
            zoom: 12
        });

        @foreach( $medico->clinicas as $clinica )
            var marker = new google.maps.Marker({
                position: {lat: {{ $clinica->lat }}, lng: {{ $clinica->lng }} },
                map: map,
                title: '{{ $clinica->nome }}'
            });
        @endforeach

    }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6J7whdFiathMGxDwBgWsO24eu7e6S6JA    
    &callback=initMap"
    async defer></script>
@endif

@endsection
