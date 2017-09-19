<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {

        $messages = [
            'name.required' => 'Veuillez entrer un non.',
            'name.string' => 'Le nom n\'est pas correcte',
            'name.max' => 'Le nom est trop long',
            'email.required' => 'Un email valide est reuis',
            'email.string' => 'Le format de votre mail n\'pas correcte',
            'email.email' => 'Veuillez saisir un email valide',
            'email.max' => 'Votre email est trop long',
            'email.unique' => 'Un utilisateur est déja renseigné pour cette email',
            'password.required' => 'Un mot de pass est requis',
            'password.string' => 'dfdff',
            'password.min' => 'Mot de passe trop faible',
            'password.min.string' => 'Mot de passe trop faible',
            'password.confirmed' => 'ddd',
        ];

            
        return Validator::make($data, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
    }

}
