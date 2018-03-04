<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Services\PassportService;

class LoginController extends Controller
{
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function apiLogin(Request $request, PassportService $passport)
    {
        $data = $request->only('email', 'password');

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            // Authentication passed...
            // Auth::login(auth()->user());

            return response()->json([
                'error' => false,
                'user_name' => auth()->user()->name,
                'id' => auth()->id(),
                'email' => auth()->user()->email,
                'access_token' => $passport->requestGrantToken($data),
            ], 200);
        }

        return response()->json([
            'error' => true,
            'message' => 'Invalid email or password',
        ], 500);
    }
}
