<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Feedback;
use App\Models\Score;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['welcome']);
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

//        Log::debug('HomeController.score', [$scoredCourses]);

        return view('score', [
            'active' => 1,
            'unscored_courses' => $unscoredCourses,
            'scored_courses' => $scoredCourses,
        ]);
    }

    public function myCourses()
    {
        $courses = Course::with('scores')
            ->where('speaker', '=', Auth::user()->id)->get()
            ->sortByDesc('date');

//        Log::debug('HomeController.score', [$courses->first()->scores]);

        $users = User::all()->pluck('name', 'id');

        Log::debug('HomeController.score', [$users, $courses->pluck('scores')]);
        Log::debug('HomeController.score', [$courses->pluck('id')]);

        $questions = DB::table('scores')->whereIn('course_id', $courses->pluck('id'))
            ->select(['course_id', 'scorer', 'question'])
            ->get()->groupBy('course_id');

        $suggests = DB::table('scores')->whereIn('course_id', $courses->pluck('id'))
            ->select(['course_id', 'scorer', 'suggest'])
            ->get()->groupBy('course_id');

        Log::debug('HomeController.score', [$questions, $suggests]);

        return view('myCourses', [
            'active' => 2,
            'courses' => $courses,
            'users' => $users,
            'questions' => $questions,
            'suggests' => $suggests,
        ]);
    }

    public function feedback(Request $request)
    {
        $feedback = Feedback::all();
        $courses = Course::all()->where('isclose', '=', 0);
        $user = User::all();

        return view('feedback', [
            'courses' => $courses,
            'feedback' => $feedback,
            'user' => $user
        ]);
    }

    public function trace(Request $request)
    {
        return view('trace', [
            'active' => 3,
            'courses' => Course::with('speakerInfo')->get()
        ]);
    }

    public function welcome(Request $request)
    {
        return view('welcome', [
            'userTotal' => User::all()->count(),
            'courseTotal' => Course::all()->count(),
            'rateTraces' => Score::with('scorerInfo')
                ->orderBy('created_at', 'DESC')->take(50)->get(),
        ]);
    }
}
