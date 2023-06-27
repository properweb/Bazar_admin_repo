<?php

namespace Modules\Login\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
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
     * Display Login View
     * @return Renderable
     */
    public function index()
    {
        return view('login::index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function submitLogin(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $loggedIn = $this->loginService->attemptLogin($credentials);
        if ($loggedIn) {
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->back()->withErrors(['error' => 'Invalid credentials.']);
        }
    }

    /**
     * Logout
     *
     * @return RedirectResponse
     */
    public function logOut(): RedirectResponse
    {
        $this->loginService->logOut();
        return redirect('/login');
    }
}
