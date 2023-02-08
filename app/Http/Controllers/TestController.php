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
        $q_scale = $this->shuffleQuestions($this->questions['scale']);
        $q_keywords = $this->shuffleQuestions($this->questions['keywords']);
        $q_summaries = $this->shuffleQuestions($this->questions['summaries']);

        $raw_question_data = json_encode([
            'keys' => [
                'scale' => array_keys($q_scale),
                'keywords' => array_keys($q_keywords),
                'summaries' => array_keys($q_summaries)
            ],
            'scale' => $q_scale,
            'keywords' => $q_keywords,
            'summaries' => $q_summaries,
        ]);

        return view('welcome', [
            'raw_question_data' => $raw_question_data,
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
        if (!isset($order['scale']) || count($order['scale']) != count($this->questions['scale'])
            || !isset($order['summaries']) || count($order['summaries']) != count($this->questions['summaries'])
            || !isset($order['keywords']) || count($order['keywords']) != count($this->questions['keywords'])) {
            //The order has been changed by the user
            return false;
        }

        $q_scale = array_filter($request->all(), function($key) {
            return strpos($key, 'scale-') === 0;
        }, ARRAY_FILTER_USE_KEY);

        $type_counter = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0];
        $i = 0;
        $answers = [];
        foreach ($q_scale as $key => $question) {
            if ($question == 0) {
                continue;
            }
            $check_key = str_replace('scale-', '', $key);
            if ($check_key != $order['scale'][$i]) {
                //TODO add notification that something is wrong
                //echo $check_key . " NOT THE SAME " . $order['scale'][$i] . "\n";
            }
            $key = intval($check_key);
            $answers[] = $this->questions['scale'][$key];
            $type_counter[$this->questions['scale'][$key]['type']]++;
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
            //Multiple highest types for the scale part
            //TODO UI for this selection
            echo "Deze antwoorden heb je gekozen, maar kies nu van deze degene die het best bij je past: \n";
            var_dump($this->getFirstAnswerOfEachType($highest_types, $answers));
            return;
        }

        //Found highest unique type in scale part
        $answer_scale = $highest_types[0];
        $answer_summaries = intval($request->get('summaries')) + 1;
        $answer_keywords = intval($request->get('keywords')) + 1;

        if ($answer_scale != $answer_summaries && $answer_summaries != $answer_keywords && $answer_scale != $answer_keywords) {
            //All three parts result in a unique type
            //TODO UI for this selection
            echo "De delen komen uit op andere types, kies 1 vraag van deze vragen waarmee je het beste kan identificeren: \n";
            var_dump($this->getFirstAnswerOfEachType([$answer_scale, $answer_summaries, $answer_keywords], $answers));
            return;
        }

        //TODO print result
        if ($answer_scale == $answer_summaries || $answer_scale == $answer_keywords) {
            echo "Resultaat ". $answer_scale;
        }
        if ($answer_keywords == $answer_summaries) {
            echo "Resultaat: ". $answer_keywords . " (" . $answer_scale .")";
        }
        var_dump($type_counter);
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


