<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ResultController extends Controller
{
    public function show($id, $hash)
    {

        $result = Result::where('id', $id)->first();
        if ($result) {
            if (password_verify($hash, $result->secret)) {
                $winner = json_decode($result->result)->winners[0];
                if (!empty($winner)) {
                    return view('result', [
                        'winner' => $winner,
                        'result' => str_replace("'", "\'", $result->result)
                    ]);
                }
            }
        }
        abort(404);
    }

    public function store(Request $request)
    {
        $rules = [
            'result' => 'required|string',
            'selected' => 'required|string',
            'email' => 'required|string|email|max:255'
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return [
                "status" => 0,
                "error" => $validator->errors()
            ];
        }

        $data = $request->input();
        //Test if result JSON is in correct format
        $resultData = json_decode($data['result'], true);
        if (!(json_last_error() === JSON_ERROR_NONE)) {
            return [
                "status" => 0,
                "error" => "Result JSON not in correct format (210)",
            ];
        }
        $rules = [
            'keywords' => 'required|array',
            'summaries' => 'required|array',
            'statements' => 'required|array',
            'winners' => 'required|array',
            'percentages' => 'required|array',
        ];
        $validator = Validator::make($resultData, $rules);
        if ($validator->fails()) {
            return [
                "status" => 0,
                "error" => "Result JSON not in correct format (211)"
            ];
        }

        $resultData = json_decode($data['selected'], true);
        if (!(json_last_error() === JSON_ERROR_NONE)) {
            return [
                "status" => 0,
                "error" => "Selected JSON not in correct format (210)",
            ];
        }
        $rules = [
            'keywords' => 'required|array',
            'summaries' => 'required|array',
            'statements' => 'required|array',
        ];
        $validator = Validator::make($resultData, $rules);
        if ($validator->fails()) {
            return [
                "status" => 0,
                "error" => "Selected JSON not in correct format (211)"
            ];
        }


        try{
            $result = new Result;
            $result->email = $data['email'];
            $result->result = $data['result'];
            $result->selected = $data['selected'];

            $result->newsletter = (isset($data['newsletter']) && $data['newsletter']);
            $result->secret = '';
            $result->uri = '';
            $result->save();

            $random_uri = bin2hex(random_bytes(20));
            $result->uri = config('app.url').'/result/' . $result->id . '/' . $random_uri;
            $result->secret = password_hash($random_uri, PASSWORD_BCRYPT);
            $result->save();
            $this->send($result->email, $result->uri);

            return [
                "status" => 1,
                "data" => $result
            ];
        } catch(Exception $e){
            return [
                "status" => 0,
                "error" => $e->getMessage()
            ];
        }
    }

    public function send($to, $uri): void {
        $mailData = [
            'uri' => $uri
        ];
        Mail::to($to)->send(new SendMail($mailData));
    }
}
