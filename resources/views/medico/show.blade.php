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
        <h3>{{ $medico->info_basica->name }}</h3>
        <a href="#" class="thumbnail">
            {!! Html::image($medico->foto, 'Foto do médico') !!}
        </a>
        <label for="">CRM:&nbsp;</label> {{ $medico->crm  }} <br/>
        <label for="">Email:&nbsp;</label> {{ $medico->info_basica->email  }} <br/>
        <label for="">Telefone:&nbsp;</label> {{ $medico->info_basica->telefone  }} <br/>

        @if (count($areas) != 0)
        <label>Áreas de atuação:</label>
        @foreach ($areas as $area)
            {{ $area->nome }} &nbsp;&nbsp;
        @endforeach
        @endif
    </div>
    <div class="col-md-7">
        <h3>Horários disponíveis</h3>
        <div id='calendar'></div>       
    </div>
</div>

@if (count($clinicas) != 0)

<div id="agendamento" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="agendamento-header" class="modal-title"></h4>
      </div>
      <div class="modal-body">
            {!! Form::open(['id' => 'agendamento-form', 'url' => url('/agendamento/cadastrar'), 'method' => 'post']) !!}
                    {!! Form::hidden('medico', $medico->id) !!}
                <div class="form-group">
                    {!! Form::label('clinica', 'Clínica') !!}
                    {!! Form::select('clinica', $clinicas->lists('nome', 'id'), Input::old('clinica'), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('hora', 'Hora') !!}
                    {!! Form::select('hora', [], null, ['class' => 'form-control']) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {!! Form::submit('Agendar', ['class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row">
    <h3>Clinicas de atuação</h3>
    <div class="col-md-12"> 

        <ul>
        @foreach ($clinicas as $clinica)
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
<button id="go-to-month-bt" type="button" class="fc-button fc-state-default fc-corner-left fc-corner-right" hidden="true"><<</button>

@endsection


@section ('scripts')
@parent
{!! Html::script('js/moment.js') !!}
{!! Html::script('js/fullcalendar.min.js') !!}

@include('medico.scripts')

@if (count($medico->clinicas) > 0)

<script>
$(document).ready(function() {
    var button = $('#go-to-month-bt');
    $('#agendamento').modal({ show: false}) 
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
            var start = moment(calEvent.start);
            var end = moment(calEvent.end);
            var horas = [];

            while(start.diff(end, 'horas') < 0)
            {
                var hora_corrente = moment(start);
                var proxima_hora = moment(start.add(1, 'hours'));
    
                if(end.diff(proxima_hora, 'minutes') < 0)
                    proxima_hora = moment(end);

                horas.push({
                    'start' : hora_corrente.format('HH:mm:ss'),
                    'end' : proxima_hora.format('HH:mm:ss')
                });
            }

            $('#agendamento').modal('show');
            $('#agendamento-header').text('Agende sua consulta (' + start.format('YYYY-MM-DD') + ')');
            $('<input>').attr({
                type: 'hidden',
                name: 'data',
                value: start.format('YYYY-MM-DD')
            }).prependTo('#agendamento-form');

            var options = $('#hora');
            options.empty();
            $.each(horas, function(index, value) {
                options.append($("<option />").val(value.start + '~' + value.end).text(value.start + '~' + value.end));
            });
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
