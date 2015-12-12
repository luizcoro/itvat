<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AgendamentoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        $agendamentos_medico;
        //usuario é medico
        if($user->tipo == 1)
        {
            $agendamentos_medico = \App\Agendamento::deMedico($user->id);
        }

        $agendamentos_paciente = \App\Agendamento::dePaciente($user->id);
        
        return view('agendamento.index', compact(['agendamentos_medico', 'agendamentos_paciente']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //pagina do medico
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hora = explode('~', $request->input('hora'));
        
        $agendamento = \App\Agendamento::create([
            'paciente_id' => \Auth::user()->id,
            'inicio' => $hora[0],
            'termino' => $hora[1],
            'medico_id' => $request->input('medico'),
            'clinica_id' => $request->input('clinica'),
            'status' => 0,
            'obs' => null
        ]);

        return redirect('/agendamentos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
