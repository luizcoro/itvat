<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'medico_id',
        'dia_semana',
        'manha_entrada',
        'manha_saida',
        'tarde_entrada',
        'tarde_saida'
    ];

    public function medico()
    {
        return $this->belongsTo('App\Medico');
    }
    
    public function scopeDeMedico($query, $medico_id)
    {
        return $query->where('medico_id', $medico_id)->get();
    }
}
