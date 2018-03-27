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

            return response()->json([
                'userName' => auth()->user()->name,
                'id' => auth()->id(),
                'email' => auth()->user()->email,
                'password' => $request->password,
                'token' => [$passport->requestGrantToken($data)],
            ], 200);
        }

        return response()->json([
            'userName' => null,
            'id' => null,
            'email' => null,
            'password' => null,
            'token' => [],
        ], 500);
    }

    public function apiLogout(Request $request)
    {
        $data = $request->only('email', 'password');

        Auth::logout();

        return response()->json([
            'userName' => null,
            'id' => null,
            'email' => null,
            'password' => null,
            'token' => [],
        ], 200);
    }
}
