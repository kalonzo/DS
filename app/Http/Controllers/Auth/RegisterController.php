<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Request;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator as Validator2;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

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

    public function showRegistrationForm(\Illuminate\Http\Request $request) {
        if ($request->ajax()) {
            $response = response();
            $jsonResponse = array('success' => 0);

            $typeUser = $request->get('type_user');

            //TODO Check if current user has right to invoke this view
            $view = View::make('components.register')->with('type_user', $typeUser);
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;

            $responsePrepared = $response->json($jsonResponse);
            return $responsePrepared;
        } else {
            return view('auth.register');
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validator2
     */
    protected function validator(array $data) {
        $rules = [
            'firstname' => 'required|min:2|string|max:255',
            'lastname' => 'required|min:2|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
        $messages = [
            'firstname.required' => 'Veuillez entrer un prénom.',
            'firstname.string' => 'Votre prénom contient des caractère.',
            'firstname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre prénom.',
            'firstname.max' => 'Votre prénom est trop long.',
            'lastname.required' => 'Veuillez entrer un non.',
            'lastname.string' => 'Le nom n\'est pas correcte.',
            'lastname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre nom.',
            'lastname.max' => 'Le nom est trop long.',
            'email.required' => 'Un email valide est requis.',
            'email.string' => 'Le format de votre mail n\'estt pas correcte.',
            'email.email' => 'Veuillez saisir un email valide.',
            'email.max' => 'Votre email est trop long.',
            'email.unique' => 'Un utilisateur est déja renseigné pour cette email.',
            'password.required' => 'Veuillez renseigner un mot de passe pour vous connecter à votre espace privé.',
            'password.min' => 'Mot de passe trop faible.',
            'password.min.string' => 'Mot de passe trop faible.',
            'password.confirmed' => 'Veuillez confirmer votre mot de passe.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        $status = User::STATUS_CREATED;
        return User::create([
                    'id' => \App\Utilities\UuidTools::generateUuid(),
                    'status' => $status,
                    'name' => $data['email'],
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'type' => $data['type_user'],
                    'gender' => 0,
                    'id_address' => 0,
                    'id_inbox' => 0,
                    'id_company' => 0,
        ]);
    }

}
