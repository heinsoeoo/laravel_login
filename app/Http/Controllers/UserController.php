<?php

namespace App\Http\Controllers;

use App\Actions\UserAction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['isSuccess' => false, 'error' => 'credentials required']);
        }

        $userAction = new UserAction($this->user);
        $res = $userAction->login(request()->all());
        return response()->json($res);
    }

    public function logout()
    {
        if (auth('api')->check()) {
            auth('api')->logout();
            return response()->json(['isSuccess' => true, 'message' => 'successfully logged out']);
        }
        return response()->json(['isSuccess' => false, 'error' => 'token required. please login first']);
    }

    public function userList()
    {
        $user = auth('api')->user();
        if ($user) {
            $users = User::select('name', 'email')->where('email', '!=', $user->email)->get();
            return response()->json(['isSuccess' => true, 'users' => $users]);
        }
        return response()->json(['isSuccess' => false, 'error' => 'token required. please login first']);
    }
}
