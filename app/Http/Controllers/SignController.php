<?php


namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Sign;
use Illuminate\Support\Facades\Auth;
use View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class SignController
{
    public function store()
    {
        $data = Input::all();

        Log::debug('ScoreController.store', $data);

        $v = Validator::make($data, [
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($v->fails()) {
            Log::debug('ScoreController.create', [$v->errors()]);
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {

            Sign::create([
                'course_id' => $data['course_id'],
                'user_id' => Auth::user()->id,
            ]);

            return redirect('score');
        }
    }
}