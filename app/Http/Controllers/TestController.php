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
        shuffle($this->questions['keywords']);
        shuffle($this->questions['summaries']);
        return view('test', [
            'q_1of3'      => $this->questions['1of3'] ?? [],
            'q_keywords'  => $this->questions['keywords'] ?? [],
            'q_summaries' => $this->questions['summaries'] ?? [],
        ]);
    }

}


