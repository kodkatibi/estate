<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthRepository $authRepository;

    public function __construct()
    {
        $this->authRepository = new AuthRepository();
    }

    public function login(Request $request)
    {
        $this->validate($request, $this->authRepository->loginRules());

        $credentials = $request->only('email', 'password');

        return $this->response($this->authRepository->login($credentials));
    }

    public function register(Request $request)
    {
        $this->validate($request, $this->authRepository->registerRules());

        $credentials = $request->only('first_name', 'last_name', 'email', 'password');

        return $this->response($this->authRepository->register($credentials));
    }

    public function logout()
    {
        return $this->response($this->authRepository->logout());
    }
}
