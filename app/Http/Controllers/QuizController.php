<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function image() {
        return view('quiz.images');
    }

    public function answers() {
        return view('quiz.answers');
    }

    public function music() {
        return view('quiz.music');
    }
}
