<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // user list
    public function index()
    {
        $users = User::query()->orderBy("id", 'desc')->paginate(10);

        if (!$users || count($users) < 0) {
            return 'Users not found!';
        }

        return response()->json([
            'message' => 'users list success',
            'data' => $users
        ]);
    }
}
