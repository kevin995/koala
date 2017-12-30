<?php


namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ScoreController
{
    public function store()
    {
        $data = Input::all();

        Log::debug('ScoreController.store', $data);

        $v = Validator::make($data, [
            'course_id' => 'required|exists:courses,id',
            'score' => 'required|integer',
        ]);

        if ($v->fails()) {
            Log::debug('ScoreController.create', [$v->errors()]);
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            DB::transaction(function () use($data) {
                Score::create([
                    'course_id' => $data['course_id'],
                    'score' => $data['score'],
                    'scorer' => Auth::user()->id,
                ]);
            });

            return redirect('score');
        }
    }
}