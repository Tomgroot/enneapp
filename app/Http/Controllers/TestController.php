<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    private array $questions;

    public function __construct()
    {
        $this->questions = config('questions');
    }

    public function show()
    {
        shuffle($this->questions['1of3']);
        return view('test', [
            'questions' => $this->questions['1of3']
        ]);
    }


}


