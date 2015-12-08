<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    protected $loginPath = '/login';
    protected $redirectPath = '/agendamentos';
    protected $redirectAfterLogout = '/';    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getLogout', 'profile']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'tipo' => 0
        ]);
    }

    protected function profile()
    {
        $user = \Auth::user();

        $profile = array();

        $profile['nome'] = $user->name;
        $profile['email'] = $user->email;
        $profile['nascimento'] = $user->nascimento;
        $profile['telefone'] = $user->telefone;
        $profile['tipo'] = $user->tipo == 0 ? 'Paciente' : 'Médico';

        if($user->tipo == 0)
        {
            $profile['sangue'] = \App\Paciente::find($user->id)->sangue;
        }
        else
        {
            $medico = \App\Medico::find($user->id);
            $profile['crm'] = $medico->crm;
            $profile['foto'] = $medico->foto;
        }

        return view('auth.profile', compact('profile'));
    }
}
