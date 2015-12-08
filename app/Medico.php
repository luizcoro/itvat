<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';

    protected $fillable = [
        'id',
        'crm',
        'foto'
    ];

    public function horarios()
    {
        return $this->hasMany('App\Horario');
    }

    public function agendamentos()
    {
        return $this->hasMany('App\Agendamento');
    }

    public function clinicas()
    {
         return $this->belongsToMany('App\Clinica')->withTimestamps();
    }

    public function areas()
    {
        return $this->belongsToMany('App\Area')->withTimestamps();
    }

    public function userInfo()
    {
        return $this->hasOne('App\User', 'id', 'id');
    }
    
    public function getAgendamentosBetween($start, $end)
    {
        return \App\Agendamento::where('medico_id', $this->id)
            ->whereBetween('inicio', [$start, $end])
            ->get();
    }
}
