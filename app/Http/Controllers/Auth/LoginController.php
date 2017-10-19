<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Lang;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */
    
    const ERROR_USER_NOT_ACTIVE = 1;
    const ERROR_BAD_CREDENTIALS = 2;

    use AuthenticatesUsers;
    
    protected $loginError = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function showResetPasswordForm(Request $request) {
        if ($request->ajax()) {
            $response = response();
            $jsonResponse = array('success' => 0);

            $typeUser = $request->get('type_user');

            //TODO Check if current user has right to invoke this view
            $view = View::make('auth.passwords.reset');
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;

            $responsePrepared = $response->json($jsonResponse);
            return $responsePrepared;
        } else {
            return view('front.home');
        }
    }

    protected function redirectPath() {
        $redirectTo = "/";
        $user = Auth::user();

        switch ($user->getType()) {
            case User::TYPE_USER_ADMIN_PRO:
            case User::TYPE_USER_PRO:
                $redirectTo = "/admin";
                break;
        }

        return $redirectTo;
    }
    
    public function getErrorMessage(){
        $errorMessage = Lang::get('auth.failed');
        switch($this->getLoginError()){
            case self::ERROR_USER_NOT_ACTIVE:
                $errorMessage = "Ce compte utilisateur n'a pas été activé. Pour procéder à son activation, veuillez "
                    . "<a href='".url("/aktiv8me/resend?email=".\Illuminate\Support\Facades\Request::get('email'))."'>cliquer ici</a>.";
                break;
        }
        return $errorMessage;
    }

    protected function sendLoginResponse(Request $request) {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        \Illuminate\Support\Facades\Request::session()->flash('status', "Vous êtes désormais connecté(e) à votre compte.");
        if ($request->ajax()) {
            return response()->json(['success' => 1], 200);
        }
        return $this->authenticated($request, $this->guard()->user()) ?: redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request) {
        if ($request->ajax()) {
            return response()->json(['success' => 0, 'error' => $this->getErrorMessage()], 401);
        } else {
            \Illuminate\Support\Facades\Request::session()->flash('error', $this->getErrorMessage());
            return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ;
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function login(Request $request) {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $user = Auth::user();

            if ($user->verified) {
                return $this->sendLoginResponse($request);
            } else {
                $this->setLoginError(self::ERROR_USER_NOT_ACTIVE);
            }

            $this->guard()->logout();
            $request->session()->invalidate();
        } else {
            $this->setLoginError(self::ERROR_BAD_CREDENTIALS);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * The user has been authenticated.
     *
     * @param  Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user) {
        if ($request->expectsJson()) {
            return response()->json([
                        'user' => $user,
                        'intended' => $this->redirectPath(),
            ]);
        }

        Session::flash('status', [
            'title' => trans('aktiv8me.status.login'),
            'message' => trans('aktiv8me.status.logged_in', ['username' => $user->name]),
            'type' => 'success',
        ]);
    }
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        
        \Illuminate\Support\Facades\Request::session()->flash('status', "Vous avez bien été déconnecté(e) de votre compte.");

        return redirect('/');
    }

    function getLoginError() {
        return $this->loginError;
    }

    function setLoginError($loginError) {
        $this->loginError = $loginError;
    }


}
