<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\RegistrationToken;
use App\Utilities\UuidTools;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as View2;
use Kitano\Aktiv8me\ActivatesUsers;

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

use ActivatesUsers,
    RegistersUsers,
    ThrottlesLogins;

    /** @var Request */
    protected $request;

    /** @var User */
    protected $user;

    /** @var string */
    protected $redirectTo = '/';

    /**
     * Will carry flashed messages/json responses
     *
     * @var array
     */
    protected $status = [];
    
    protected $error = null;
    
    const ERROR_USER_CREATION = 1;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;

        $this->middleware(['guest']);
    }
    
    public function getErrorMessage(){
        $errorMessage = '';
        switch($this->getError()){
            case self::ERROR_USER_CREATION:
                $errorMessage = "La création du compte a échoué.";
                break;
            default :
                $errorMessage = $this->getError();
                break;
        }
        return $errorMessage;
    }

    public function showRegistrationForm(Request $request) {
        if ($request->ajax()) {
            $response = response();
            $jsonResponse = array('success' => 0);

            $typeUser = $request->get('type_user');

            $view = View::make('components.register')->with('type_user', $typeUser);
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;

            $responsePrepared = $response->json($jsonResponse);
            return $responsePrepared;
        } else {
            return view('front.home');
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validator
     */
    protected function validator(array $data) {
        $rules = [
            'firstname' => 'required|min:2|string|max:255',
            'lastname' => 'required|min:2|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ];
        $messages = [
            'firstname.required' => 'Veuillez entrer votre prénom.',
            'firstname.string' => 'Votre prénom doit contenir exclusivement des caractères.',
            'firstname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre prénom.',
            'firstname.max' => 'Votre prénom est trop long.',
            'lastname.required' => 'Veuillez entrer un nom.',
            'lastname.string' => 'Le nom n\'est pas correct.',
            'lastname.min' => 'Veuillez renseigner au minimum 2 caractères pour votre nom.',
            'lastname.max' => 'Le nom est trop long.',
            'email.required' => 'Un email valide est requis.',
            'email.string' => 'Le format de votre mail n\'est pas correct.',
            'email.email' => 'Veuillez saisir un email valide.',
            'email.max' => 'Votre email est trop long.',
            'password.required' => 'Veuillez renseigner un mot de passe pour vous connecter à votre espace privé.',
            'password.min' => 'Mot de passe trop faible.',
            'password.min.string' => 'Mot de passe trop faible.',
            'password.confirmed' => 'Veuillez confirmer votre mot de passe.',
        ];
        
        $validator = Validator::make($data, $rules, $messages);
        $validator->after(function ($validator) use ($data) {
            $userQuery = User::where('email', 'LIKE', $data['email']);
            if ($userQuery->exists()) {
                $userNotActivated = $userQuery->where('status', '=', User::STATUS_CREATED)->exists();
                if($userNotActivated){
                    $validator->errors()->add('email', "Ce compte est actuellement inactif. "."Si ce compte vous appartient, veuillez "
                                         . "<a href='".url("/aktiv8me/resend?email=".$data['email'])."'>cliquer ici</a> pour procéder à son activation.");
                } else {
                    $validator->errors()->add('email', "Cette adresse email n\'est pas disponible.");
                }
            }
        });
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        $status = User::STATUS_CREATED;
        $user = User::create([
                    'id' => UuidTools::generateUuid(),
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

    protected function redirectTo() {
        $redirectTo = "/";
//        $redirectTo = "/register_done";
//        $user = \Illuminate\Support\Facades\Auth::user();
//        
//        switch($user->getType()){
//            case \App\Models\User::TYPE_USER_ADMIN_PRO:
//            case \App\Models\User::TYPE_USER_PRO:
//                $redirectTo = "/admin";
//                break;
//        }

        return $redirectTo;
    }

    public function register(Request $request) {
        $this->validator($this->request->input())->validate();
        try{
            $this->storeUser();
            return $this->sendRegisterResponse();
        } catch(\Exception $e){
            $this->setError($e->getMessage());
            return $this->sendRegisterFailedResponse();
        }
    }

    /**
     * Show resend token form
     *
     * @return Factory|View2
     */
    public function getResend(Request $request) {
        return view('auth.resend')->with('email', $request->get('email'));
    }

    /**
     * Resend token by user request
     *
     * We'll try our best to avoid disclosing any information
     * about users. This feature could be used to check if
     * a given email address is registered or not.
     *
     * @return JsonResponse
     */
    public function postResend() {
        $this->emailValidator($this->request->input())->validate();

        // We take advantage of Laravel's ThrottlesLogins trait,
        // but a recaptcha on the Form should be implemented.
        if ($this->hasTooManyLoginAttempts($this->request)) {
            $this->fireLockoutEvent($this->request);

            return $this->sendLockoutResponse($this->request);
        }

        $this->incrementLoginAttempts($this->request);

        $this->user = User::findByEmail($this->request->input('email'));

        // No user, no go!
        if (is_null($this->user) || !$this->user->count()) {
            // just apologise and throw some generic message
            $this->status = $this->setStatus(
                    trans('aktiv8me.status.account_confirmation'), trans('aktiv8me.status.no_can_do'), 422
            );

            return $this->sendResendFailedResponse();
        }

        if ($this->user->verified) {
            // If a user is already active, we will send him
            // an email with that information, rather than
            // popping up any info alert on the screen.
            $this->setStatus($this->sendUserIsActiveEmail($this->user));

            return $this->sendResendFailedResponse();
        }

        if (!$this->canSendToken($this->user->codes->count())) {
            $this->status = $this->setStatus(
                    trans('aktiv8me.status.account_confirmation'), trans('aktiv8me.status.max_tokens'), 403
            );

            return $this->sendResendFailedResponse();
        }

        // good to go! generate new token and mail it
        $this->status = $this->setStatus(
                $this->sendActivationEmail(
                        $this->user, RegistrationToken::makeToken($this->user->email), $this->user->codes->count() + 1
                )
        );

        $this->clearLoginAttempts($this->request);

        return $this->sendResendResponse();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username() {
        return 'email';
    }

    /**
     * Confirm/Activate a user
     *
     * This method only supports HTTP requests.
     * Tweaks are necessary, if front-end is
     * a JavaScript App.
     *
     * @param  string $token
     *
     * @return RedirectResponse
     */
    public function verify($token) {
        /** @var RegistrationToken $valid_token */
        $valid_token = RegistrationToken::findToken($token);
        if (!$valid_token) {
            $this->status = $this->setStatus(
                    trans('aktiv8me.status.account_confirmation'), trans('aktiv8me.status.invalid_token'), 403
            );
            return redirect('/')->with('status', $this->status);
        }

        $this->user = $valid_token->user;

        if ($this->tokenIsExpired($valid_token)) {
            $this->renewToken();
            return redirect('/')->with('status', $this->status);
        }

        $this->sendWelcomeEmail($this->user)->destroyToken($valid_token->user_id);

        if ($this->autoLoginEnabled()) {
            $this->guard()->login($this->user);

            $this->status = $this->setStatus(
                    trans('aktiv8me.status.account_confirmation'), trans('aktiv8me.status.account_confirmed_and_in', ['username' => $this->user->name]), false
            );
            return redirect('/')->with('status', $this->status);
        }

        $this->status = $this->setStatus(
                trans('aktiv8me.status.account_confirmation'), trans('aktiv8me.status.account_confirmed'), false
        );

        return redirect('/login')->with('status', $this->status);
    }

    /**
     * Destroy used tokens
     *
     * @param $user
     *
     * @return $this
     */
    protected function destroyToken($userId) {
        RegistrationToken::deleteCode($userId);

        return $this;
    }

    /**
     * The user has been registered.
     *
     * @return void
     */
    protected function registered() {
        if ($this->aktiv8enabled()) {
            $this->status = $this->setStatus(
                    $this->sendActivationEmail($this->user, RegistrationToken::makeToken($this->user->email))
            );
        }

        if ($this->canAutoLogin()) {
            $this->guard()->login($this->user);

            $this->status = $this->setStatus(
                    trans('aktiv8me.status.login'), trans('aktiv8me.status.first_login', ['username' => $this->user->name]), false
            );
        }
    }

    /**
     * Update an expired token
     *
     * @return $this
     */
    protected function renewToken() {
        if (!$this->canAutoResendToken()) {
            $this->status = $this->setStatus(
                    trans('aktiv8me.status.account_confirmation'), trans('aktiv8me.status.token_expired') .
                    $this->canSendToken($this->user->codes->count()) ? trans('aktiv8me.status.can_resend') : '', 422
            );

            return $this;
        }

        $this->status = $this->setStatus(
                $this->sendTokenUpdatedEmail($this->user, RegistrationToken::updateFor($this->user))
        );

        return $this;
    }

    /**
     * @return RedirectResponse
     */
    protected function sendResendResponse() {
        \Illuminate\Support\Facades\Request::session()->flash('status', 
                "Votre demande d'activation a bien été prise en compte. Un mail de confirmation vous a été envoyé. "
                . "Merci de cliquer sur le lien d'activation dans cet email pour confirmer votre adresse email.");
        if ($this->request->expectsJson()) {
            return response()->json([
                                'success' => 1,
                                'relocateMode' => 1,
                                'location' => $this->redirectPath()
                            ], $this->status['http_code']);
        } else {
            return redirect($this->redirectPath());
        }
    }

    /**
     * @return RedirectResponse
     */
    protected function sendResendFailedResponse() {
        if ($this->request->expectsJson()) {
            return response()->json([
                                'success' => 0,
                                'error' => $this->status['title'].': '.$this->status['message'],
                            ], $this->status['http_code']);
        } else {
            return redirect($this->redirectPath())
                        ->with('status', $this->status);
        }
    }

    /**
     * @return JsonResponse|RedirectResponse
     */
    protected function sendRegisterResponse() {
        \Illuminate\Support\Facades\Request::session()->flash('status', 
                "Votre demande d'inscription a bien été enregistrée. Un mail de confirmation vous a été envoyé. "
                . "Merci de cliquer sur le lien d'activation dans cet email pour confirmer votre adresse email.");
        if ($this->request->expectsJson()) {
            return response()->json([
                        'success' => 1,
                        'relocateMode' => 1,
                        'location' => $this->redirectPath()
                            ], 200);
        } else {
            return redirect($this->redirectPath());
        }
    }
    
    /**
     * @return JsonResponse|RedirectResponse
     */
    protected function sendRegisterFailedResponse() {
        if ($this->request->expectsJson()) {
            return response()->json([
                        'success' => 0,
                        'error' => $this->getErrorMessage(),
                        'status' => $this->status
                            ], 401);
        } else {
            return redirect($this->redirectPath())
                            ->with('status', $this->status);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return static|User
     */
    protected function storeUser() {
        try{
            $data = $this->request->input();

            $status = User::STATUS_CREATED;
            $this->user = User::create([
                        'id' => UuidTools::generateUuid(),
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
            $this->registered();
        } catch(\Exception $e){
            $this->setError($e->getMessage());
            if(checkModel($this->user)){
                $this->user->delete();
            }
            throw $e;
        }
    }

    function getError() {
        return $this->error;
    }

    function setError($error) {
        $this->error = $error;
    }

}
