<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthRepository implements AuthInterface
{

    public function login(array $data)
    {
        $token = $this->getToken($data['email'], $data['password']);
        Auth::user()->token = $token;
        Auth::user()->save();
        return Auth::user();
    }

    public function register(array $data)
    {
        // TODO: Implement register() method.
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }


    public function registerRules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function loginRules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * @param string $email
     * @param string $password
     * @return string
     * @throws JWTException
     */
    public function getToken(string $email, string $password): string
    {
        $credentials = [
            'email' => $email,
            'password' => $password
        ];
        if (!$token = Auth::attempt($credentials)) {
            throw new JWTException('Invalid Email or Password');
        }
        return $token;
    }
}
