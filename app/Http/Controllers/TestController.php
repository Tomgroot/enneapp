<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    private array $questions;

    public function __construct()
    {
        $this->questions = config('questions');
    }

    /**
     * Show the test
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show()
    {

        $random_statements = $this->shuffleQuestions($this->questions['statements']);
        $random_keywords = $this->shuffleQuestions($this->questions['keywords']);
        $random_summaries = $this->shuffleQuestions($this->questions['summaries']);

        $raw_question_data = json_encode([
            'statements' => $this->questions['statements'],
            'keywords' => $this->questions['keywords'],
            'summaries' => $this->questions['summaries'],
            'random' => [
                'statements' => $random_statements,
                'keywords' => $random_keywords,
                'summaries' => $random_summaries
            ],
        ]);

        return view('test', [
            'raw_question_data' => $raw_question_data,
        ]);
    }

    public function sortPerType($array)
    {
        $types = [];
        foreach ($array as $value) {
            $types[$value['type']][] = $value;
        }
        return $types;
    }

    /**
     * Shuffle the questions but keep the keys
     * @param $questions
     * @return array
     */
    private function shuffleQuestions($questions)
    {
        $keys = array_keys($questions);
        shuffle($keys);
        return $keys;
    }

    /**
     * With an array of numbers, create an array with all combinations
     */
    private function getOptionCombinations($array) {
        $random_summaries = $this->shuffleQuestions($array);
        //Count how many options there are within one type
        $multi_dim_array = array_chunk($random_summaries, count($array[1]));
        $new_array = $multi_dim_array;

        foreach ($multi_dim_array as $key => $array) {
            $new_deep_array = [];
            $another_new_deep_array = [];
            $increasing_key = $key;
            foreach ($multi_dim_array as $deep_key => $deep_array) {
                $new_deep_array[] = $deep_array[$key];
                $another_new_deep_array[] = $deep_array[$increasing_key];
                $increasing_key = ($increasing_key + 1) % 3;
            }
            $new_array[] = $new_deep_array;
            $new_array[] = $another_new_deep_array;
        }
        return $new_array;
    }
}


