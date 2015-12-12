<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Validator;

use App\Medico;
use App\User;

use Input;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesquisa = \Input::get('pesquisa');

        if(isset($pesquisa) && $pesquisa != '')
        {
            $medicos =  Medico::hydrate(\DB::table('medicos')
                ->join('users', 'users.id', '=', 'medicos.id')
                ->where('users.name', 'like', "%$pesquisa%")
                ->select('medicos.*')
                ->distinct()
                ->get());

             
            return view('medico.index', compact('medicos'));
        }
        else
        {
            $medicos = Medico::all();
            return view('medico.index', compact('medicos'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('medico.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'crm' => 'required|integer',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
            'foto' => 'required|image',
        ]);

        if($validator->fails())
        {
            return redirect('/medico/cadastrar')
                ->withErrors($validator, 'login');
        }

        if(!Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {
            return redirect('/medico/cadastrar')
                ->withErrors(['failed' => 'Credenciais informadas não correspondem com nossos registros.'], 'login');
        }

        $user = Auth::user();
        $user->tipo = 1;
        $user->save();

        $file = $request->file('foto');
        $image_name = time(). "-" . $file->getClientOriginalName();
        $file->move('img/medicos', $image_name);

        Medico::create([
            'id' => $user->id,
            'crm' => $request->input('crm'),
            'foto' => 'img/medicos/' . $image_name 
        ]);

        return redirect('/agendamentos'); 
    }

    public function store_novo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'crm' => 'required|integer',
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'foto' => 'required|image',
        ]);

        if($validator->fails())
        {
            return redirect('/medico/cadastrar')
                ->withErrors($validator, 'novo');
        }

        $user = User::create([
            'name' => $request->input('nome'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'nascimento' => null,
            'telefone' => null,
            'tipo' => 1
        ]);

        Auth::login($user);

        $file = $request->file('foto');
        $image_name = time(). "-" . $file->getClientOriginalName();
        $file->move('img/medicos', $image_name);

        Medico::create([
            'id' => $user->id,
            'crm' => $request->input('crm'),
            'foto' => 'img/medicos/' . $image_name 
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
        $medico = Medico::findOrFail($id);
        
        $medico->info_basica = $medico->userInfo;
        $areas = $medico->areas;
        $clinicas = $medico->clinicas;
        
        return view('medico.show', compact(['medico', 'areas', 'clinicas']));
    }

    //ajax
    public function getHorariosDisponiveis($id_medico)
    {
        $medico = Medico::findOrFail($id_medico);
        $start = Input::get('start');
        $end = Input::get('end');
        
        //30 minutos
        $vaga_minima = 30;        
        
        if(antes($start, date('Y-m-d')))
            $start = date('Y-m-d');

        $horarios = $medico->horarios;
        $agendamentos = $medico->getAgendamentosBetween($start, $end);

        $horarios_diponiveis = [];

        while(antes_ou_igual($start, $end))
        {
            $horarios_do_dia = $horarios->filter(function($item) use($start) {
                return dia_da_semana($start) == $item->dia_da_semana;
            });

            foreach($horarios_do_dia as $horario)
            {
                $agendamentos_por_horario = $agendamentos->filter(function($agendamento) use($start, $horario) {
                    return mesma_data($start, $agendamento->inicio) && hora_entre($agendamento->inicio, $horario->entrada, $horario->saida);
                })->values();

                if($agendamentos_por_horario->isEmpty())
                {
                    if(intervaloMaiorQue([$horario->entrada, $horario->saida], $vaga_minima))
                    {
                        $horarios_disponiveis[] = [
                            'start' => $start . ' ' . $horario->entrada,
                            'end' => $start . ' ' . $horario->saida,
                        ];
                    }
                }
                else
                {
                    if(intervaloMaiorQue([$horario->entrada, $agendamentos_por_horario[0]->inicio], $vaga_minima))
                    {
                        $horarios_disponiveis[] = [
                            'start' => $start . ' ' . $horario->entrada,
                            'end' => $agendamentos_por_horario[0]->inicio
                        ];
                    }

                    $count_agendamentos_por_horario = count($agendamentos_por_horario);
                    for($i = 0; $i < $count_agendamentos_por_horario; $i++)
                    {
                        if(isset($agendamentos_por_horario[$i+1]))
                        {
                            if(intervaloMaiorQue([$agendamentos_por_horario[$i]->termino, $agendamentos_por_horario[$i+1]->inicio], $vaga_minima))
                            {
                                $horarios_disponiveis[] = [
                                    'start' => $agendamentos_por_horario[$i]->termino,
                                    'end' =>$agendamentos_por_horario[$i+1]->inicio
                                ];
                            }
                        }
                        else
                        {
                            if(intervaloMaiorQue([$agendamentos_por_horario[$i]->termino, $horario->saida], $vaga_minima))
                            {
                                $horarios_disponiveis[] = [
                                    'start' => $agendamentos_por_horario[$i]->termino,
                                    'end' => $start . ' ' . $horario->saida
                                ];
                            }
                        }
                    }
                }
            }

            $start = proximo_dia($start);  
        }

        return \Response::json($horarios_disponiveis);
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
