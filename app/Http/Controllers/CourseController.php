<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use View;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('course.create', ['users' => User::all()->toArray()]);
    }


    public function store()
    {
        $data = Input::get();

        Log::debug('CourseController.store', $data);

        $v = Validator::make($data, [
            'name' => 'required',
            'speaker' => 'required|exists:users,id',
            'location' => 'required',
            'date' => 'required',
        ]);

        if ($v->fails()) {
            Log::debug('CourseController.create', [$v->errors()]);
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            DB::transaction(function () use($data) {
                Course::create([
                    'name' => $data['name'],
                    'speaker' => $data['speaker'],
                    'location' => $data['location'],
                    'date' => $data['date'],
                ]);
            });

            return redirect('home');
        }
    }

    public function edit($id)
    {
        $course = Course::find($id);

        return View::make('course.edit', [
            'course' => $course,
            'users' => User::all()->toArray(),
        ]);
    }

    public function update($id)
    {
        $data = Input::get();

        Log::debug('CourseController.update', $data);

        $v = Validator::make($data, [
            'name' => 'required',
            'speaker' => 'required|exists:users,id',
            'location' => 'required',
            'date' => 'required',
            'isclose' => 'required|numeric'
        ]);

        if ($v->fails()) {
            Log::debug('CourseController.update', [$v->errors()]);
            return redirect()->back()->withErrors($v->errors())->withInput();
        } else {
            DB::transaction(function () use($data, $id) {

                $course = Course::find($id);

                $course->name = $data['name'];
                $course->speaker = $data['speaker'];
                $course->location = $data['location'];
                $course->date = $data['date'];
                $course->isclose = $data['isclose'];

                $course->save();
            });

            return redirect('home');
        }
    }
}
