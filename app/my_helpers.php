<?php

use Carbon\Carbon;

function agendamento_string($t)
{
    switch($t)
    {
    case '0': 
        return 'esperando confirmacao de email';
    case '1': 
        return 'confirmado pelo paciente';
    case '2': 
        return 'pago';
    case '3': 
        return 'confirmado pelo medico';
    case '4': 
        return 'concluido';
    }

}


function carbon($date)
{
    return new Carbon($date, 'America/Sao_Paulo');
}

function intervaloMaiorQue($intervalo, $minutos)
{
    $tmp1 = carbon(carbon($intervalo[0])->toTimeString());
    $tmp2 = carbon(carbon($intervalo[1])->toTimeString());

    return ($tmp2->diffInMinutes($tmp1) >= $minutos);
}

function data_entre($c1, $e1, $e2)
{
    $c1_tmp = carbon(carbon($c1)->toDateString());
    $e1_tmp = carbon(carbon($e1)->toDateString());
    $e2_tmp = carbon(carbon($e2)->toDateString());

    return ($c1_tmp->between($e1_tmp, $e2_tmp));
}

function hora_entre($c1, $e1, $e2)
{
    $c1_tmp = carbon(carbon($c1)->toTimeString());
    $e1_tmp = carbon(carbon($e1)->toTimeString());
    $e2_tmp = carbon(carbon($e2)->toTimeString());

    return ($c1_tmp->between($e1_tmp, $e2_tmp));
}
function hora_menor_que($c1, $c2)
{
    $c1_tmp = carbon(carbon($c1)->toTimeString());
    $c2_tmp = carbon(carbon($c2)->toTimeString());

    return carbon($c1_tmp)->lt(carbon($c2_tmp));
}
function dia_da_semana($data)
{
    return carbon($data)->dayOfWeek;
}

function proximo_dia($data)
{
    return carbon($data)->addDay()->toDateString();
}

function antes($d1, $d2)
{
    return carbon($d1)->lt(carbon($d2));
}

function mesma_data($d1, $d2)
{
    return (carbon($d1)->format('Y-m-d') == carbon($d2)->format('Y-m-d'));
}

function antes_ou_igual($d1, $d2)
{
    return carbon($d1)->lte(carbon($d2));
}
