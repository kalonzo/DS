<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use View;

class ForgotPasswordController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset emails and
      | includes a trait which assists in sending these notifications from
      | your application to your users. Feel free to explore this trait.
      |
     */

use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    public function showLinkRequestForm(Request $request) {
        if ($request->ajax()) {
            $response = response();
            $jsonResponse = array('success' => 0);

            $view = View::make('auth.passwords.forgot-password')->with('email', $request->get('email'));
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;

            $responsePrepared = $response->json($jsonResponse);
            return $responsePrepared;
        } else {
            return view('front.home');
        }
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse($response) {
        \Illuminate\Support\Facades\Request::session()->flash('status', "Un email vous a été envoyé pour réinitialiser votre mot de passe.");
        if (\Illuminate\Support\Facades\Request::ajax()) {
            return response()->json(['success' => 1], 200);
        } else {
            return back();
        }
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response) {
        if ($request->ajax()) {
            return response()->json(['email' => trans($response)], 401);
        } else {
            return back()->withErrors(
                            ['email' => trans($response)]
            );
        }
    }

}
