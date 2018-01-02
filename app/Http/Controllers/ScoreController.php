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
            'score_0' => 'required|integer',
            'score_1' => 'required|integer',
            'score_2' => 'required|integer',
            'score_3' => 'required|integer',
            'question' => 'required|string',
            'suggest' => 'required|string',
        ]);

        if ($v->fails()) {
            Log::debug('ScoreController.create', [$v->errors()]);
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {

            $scores = ['scores' => [
                $data['score_0'],
                $data['score_1'],
                $data['score_2'],
                $data['score_3']
            ]];

            DB::transaction(function () use($data, $scores) {
                Score::create([
                    'course_id' => $data['course_id'],
                    'score' => json_encode($scores),
                    'scorer' => Auth::user()->id,
                    'question' => $data['question'],
                    'suggest' => $data['suggest'],
                ]);
            });

            return redirect('score');
        }
    }
}