<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return RedirectResponse
     */
    protected function sendResetResponse($response)
    {
        \Illuminate\Support\Facades\Request::session()->flash('status', "Votre mot de passe a bien été réinitialisé. Vous êtes désormais connecté(e) à votre compte.");
        if (\Illuminate\Support\Facades\Request::expectsJson()) {
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
     * Get the response for a failed password reset.
     *
     * @param  Request
     * @param  string  $response
     * @return RedirectResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        if ($request->expectsJson()) {
            return response()->json(['error', trans($response)], 401);
        } else {
            \Illuminate\Support\Facades\Request::session()->flash('error', trans($response));
            redirect()->back()->withInput($request->only('email'));
        }
    }
}
