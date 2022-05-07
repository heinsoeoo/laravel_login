<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAction {
    protected $modal;

    public function __construct(User $user)
    {
        $this->modal = $user;
    }

    public function login(array $data) {

        $email = $data['email'];
        $password = $data['password'];

        if ($email === '' || $password === '' || $email === null || $password === null) {
            return ['isSuccess' => false, 'error' => 'credentials required!'];
        }

        $user = User::where('email', $email)->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {
                $token = auth('api')->login($user);
                $users = User::select("name", "email")->where('email', '!=', $email)->get();

                return [
                    'isSuccess' => true,
                    'token' => $token,
                    'users' => $users
                ];
            }
            return ['isSuccess' => false, 'error' => 'invalid email or password'];
        }
        return ['isSuccess' => false, 'error' => 'account doesn\'t exists!'];
    }
}