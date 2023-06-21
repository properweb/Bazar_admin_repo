<?php

namespace Modules\Login\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Login\Http\Services\LoginService;

class LoginController extends Controller
{
    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('login::index');
    }

    public function submitLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $loggedIn = $this->loginService->attemptLogin($credentials);

        if ($loggedIn['res']==1) {
            return redirect()->intended('/dashboard');
        } else {

            return redirect()->back()->withErrors(['error' => 'Invalid credentials.']);
        }
    }

    public function logOut()
    {
        $this->loginService->logOut();
        return redirect('/login');
    }


}
