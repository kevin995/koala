<?php


namespace App\Http\Controllers;

use App\Models\Score;
use App\User;
use Illuminate\Support\Facades\Auth;
use View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UserController
{
    public function index()
    {
        return view('user.index', [
            'users' => User::all()->sortByDesc('created_at')
        ]);
    }
}