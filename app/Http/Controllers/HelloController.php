<?php

namespace App\Http\Controllers;

// global $head, $style, $body, $end;

// $head = "<html><head>";
// $style = <<<EOF
// <style>
// h1{font-size:100px;}
// </style>
// EOF;
// $body = "</head><body>";
// $end = "</body></html>";


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\HelloRequest;
use Validator;

class HelloController extends Controller
{

    public function index(Request $request)
    {
        $validator = Validator::make($request->query(), [
            "id" => "required",
            "pass" => "required",
        ]);
        if ($validator->fails()) {
            $msg = "クエリーに問題があります";
        } else {
            $msg = "ID/PASSを受け付けました";
        }
        return view("hello.index", ["msg" => $msg,]);
    }

    public function post(HelloRequest $request)
    {

        return view("hello.index", ["msg" => "正しく入力されました"]);

    }
}
