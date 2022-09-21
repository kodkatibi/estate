<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class LoginController extends Controller
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

       return $this->authRepository->login($credentials);
    }
}
