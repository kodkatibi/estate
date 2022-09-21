<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;
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
        User::query()->firstOrCreate([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        dd($data);
        return $this->login($data);
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }


    public function registerRules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
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
