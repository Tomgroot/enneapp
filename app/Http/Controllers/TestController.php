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
                'summaries' => array_keys($q_summaries)
            ]))
        ]);
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
        $shuffledArray = [];
        foreach($keys as $key) {
            $shuffledArray[$key] = $questions[$key];
        }
        return $shuffledArray;
    }

    /**
     * Calculate the result after a POST of the test
     * @param Request $request
     * @return false|void
     */
    public function result(Request $request)
    {
        //TODO check if all questions have been filled in
        echo "<pre>";
        $order = json_decode(base64_decode($request->get('keys')), true);
        if (!isset($order['1of3']) || count($order['1of3']) != count($this->questions['1of3'])
            || !isset($order['summaries']) || count($order['summaries']) != count($this->questions['summaries'])
            || !isset($order['keywords']) || count($order['keywords']) != count($this->questions['keywords'])) {
            //The order has been changed by the user
            return false;
        }

        $q_1of3 = array_filter($request->all(), function($key) {
            return strpos($key, '1of3-') === 0;
        }, ARRAY_FILTER_USE_KEY);

        $type_counter = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0];
        $i = 0;
        $answers = [];
        foreach ($q_1of3 as $key => $question) {
            if ($question == 0) {
                continue;
            }
            $check_key = str_replace('1of3-', '', $key);
            if ($check_key != $order['1of3'][$i]) {
                //TODO add notification that something is wrong
                //echo $check_key . " NOT THE SAME " . $order['1of3'][$i] . "\n";
            }
            $key = intval($check_key);
            $answers[] = $this->questions['1of3'][$key];
            $type_counter[$this->questions['1of3'][$key]['type']]++;
            $i++;
        }

        arsort($type_counter);

        $highest_types = [];
        foreach ($type_counter as $type => $count) {
            if ($count == max($type_counter)) {
                $highest_types[] = $type;
            }
        }

        if (count($highest_types) > 1) {
            //Multiple highest types for the 1of3 part
            //TODO UI for this selection
            echo "Deze antwoorden heb je gekozen, maar kies nu van deze degene die het best bij je past: \n";
            var_dump($this->getFirstAnswerOfEachType($highest_types, $answers));
            return;
        }

        //Found highest unique type in 1of3 part
        $answer_1of3 = $highest_types[0];
        $answer_summaries = intval($request->get('summaries')) + 1;
        $answer_keywords = intval($request->get('keywords')) + 1;

        if ($answer_1of3 != $answer_summaries && $answer_summaries != $answer_keywords && $answer_1of3 != $answer_keywords) {
            //All three parts result in a unique type
            //TODO UI for this selection
            echo "De delen komen uit op andere types, kies 1 vraag van deze vragen waarmee je het beste kan identificeren: \n";
            var_dump($this->getFirstAnswerOfEachType([$answer_1of3, $answer_summaries, $answer_keywords], $answers));
            return;
        }

        //TODO print result
        if ($answer_1of3 == $answer_summaries || $answer_1of3 == $answer_keywords) {
            echo "Resultaat ". $answer_1of3;
        }
        if ($answer_keywords == $answer_summaries) {
            echo "Resultaat: ". $answer_keywords;
        }
    }

    /**
     * Select from the filled in answers, the questions that the user agrees with and matches the type
     * @param $types
     * @param $answers
     * @return array
     */
    public function getFirstAnswerOfEachType($types, $answers)
    {
        $questions = [];
        foreach ($types as $type) {
            foreach ($answers as $answer) {
                if ($answer['type'] != $type) {
                    continue;
                }
                $questions[] = $answer;
                break;
            }
        }
        return $questions;
    }

}


