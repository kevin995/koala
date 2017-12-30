<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Log::debug('HomeController.index', [
            Course::with('speakerInfo')->get(),
            Course::with('speakerInfo')->where('date', '>', date('Y/m/d H:i', time()))->first(),
        ]);

        return view('home', [
            'active' => 0,
            'courses' => Course::with('speakerInfo')->orderBy('date', 'DESC')->get(),
            'nextCourse' => Course::with('speakerInfo')
                ->where('isclose', '!=', 1)->orderBy('date', 'DESC')->first(),
        ]);
    }

    public function score()
    {
        $user = Auth::user();

        $unscoredCourses = $user->getUnscoredCourses();
        $scoredCourses = $user->getScoredCourses();

        Log::debug('HomeController.score', [$unscoredCourses]);
        return view('score', [
            'active' => 1,
            'unscored_courses' => $unscoredCourses,
            'scored_courses' => $scoredCourses,
        ]);
    }

    public function myCourses()
    {
        $courses = Course::all()->where('speaker', '=', Auth::user()->id)->sortByDesc('date');

        return view('myCourses', [
            'active' => 3,
            'courses' => $courses,
        ]);
    }
}
