<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Clinica;

class ClinicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesquisa = \Input::get('pesquisa');
        $clinicas = (isset($pesquisa) && $pesquisa != '') ? Clinica::where('nome', 'like', "%$pesquisa%")->get() : Clinica::all();

        return view('clinica.index', compact('clinicas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clinica.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nome' => 'required',
            'endereco' => 'required',
            'foto' => 'required|image',
        ]);
        
        if($validator->fails())
        {
            return redirect('/clinica/cadastrar')
                ->withErrors($validator);
        }

        $file = $request->file('foto');
        $image_name = time(). "-" . $file->getClientOriginalName();
        $file->move('img/clinicas', $image_name);

        Clinica::create([
            'nome' => $request->input('nome'),
            'endereco' => $request->input('endereco'),
            'lat' => -18.906286,
            'lng' => -48.257420,
            'foto' => 'img/clinicas/' . $image_name 
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clinica = \App\Clinica::findOrFail($id);

        return view('clinica.show', compact('clinica'));
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
