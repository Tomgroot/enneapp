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

    public function show()
    {
        $q_1of3 = $this->shuffleQuestions($this->questions['1of3']);
        $q_keywords = $this->shuffleQuestions($this->questions['keywords']);
        $q_summaries = $this->shuffleQuestions($this->questions['summaries']);

        return view('test', [
            'q_1of3'      => $q_1of3,
            'q_keywords'  => $q_keywords,
            'q_summaries' => $q_summaries,
            'keys'        => base64_encode(json_encode([
                '1of3' => array_keys($q_1of3),
                'keywords' => array_keys($q_keywords),
                'q_summaries' => array_keys($q_summaries)
            ]))
        ]);
    }

    private function shuffleQuestions($questions)
    {
        $keys = array_keys($questions);
        shuffle($keys);
        $shuffledArray = [];
        foreach($keys as $key) {
            $shuffledArray[$key] = $questions[$key];
        }
        return $shuffledArray;
    }

    public function result(Request $request)
    {

        print("<pre>");

        $q_1of3 = array_filter($request->all(), function($key) {
            return strpos($key, '1of3-') === 0;
        }, ARRAY_FILTER_USE_KEY);

        $type_counter = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0];

        foreach ($q_1of3 as $q) {
            foreach ($this->questions['type_encoding'] as $type => $encoded) {
                if ($q === $encoded && $type != 0) {
                    $type_counter[$type] ++;
                }
            }
        }

        arsort($type_counter);

        var_dump($type_counter);
    }

    public function getQuestionsToRemove($types, $answers)
    {

    }

}


