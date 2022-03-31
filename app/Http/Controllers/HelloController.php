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
use Illuminate\Support\Facades\DB;

class HelloController extends Controller
{

    public function index(Request $request)
    {

        $items = DB::table("peoples")->get();
        return view("hello.index", ["items" => $items]);
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $item = DB::table("peoples")->where("id", "<=",$id)->get();
        return view("hello.show", ["item" => $item]);
    }

    public function post(Request $request)
    {

        $validate_rule = [
            "msg" => "required",
        ];

        $this->validate($request, $validate_rule);
        $msg = $request->msg;
        $response = response()->view(
            "hello.index",
            ["msg" => "[" . $msg . "]をcookieに保存しました"]
        );
        $response->cookie("msg", $msg, 100);

        return $response;
    }

    public function add(Request $request)
    {
        return view("hello.add");
    }

    public function create(Request $request)
    {
        $param = [
            "name" => $request->name,
            "mail" => $request->mail,
            "age" => $request->age,
        ];
        DB::insert("insert into peoples (name, mail, age) values(:name, :mail, :age)", $param);
        return redirect("/hello");
    }

    public function edit(Request $request)
    {
        $param = [
            "id" => $request->id,
        ];
        $item = DB::select("select * from peoples where id = :id", $param);
        return view("hello.edit", ["form" => $item[0]]);
    }

    public function update(Request $request)
    {
        $param = [
            "id" => $request->id,
            "name" => $request->name,
            "mail" => $request->mail,
            "age" => $request->age,
        ];
        DB::update("update peoples set name =:name, mail =:mail, age =:age where id = :id", $param);
        return redirect("/hello");
    }

    public function del(Request $request)
    {
        $param = [
            "id" => $request->id,
        ];
        $item = DB::select("select * from peoples where id = :id", $param);
        return view("hello.del", ["form" => $item[0]]);
    }

    public function remove(Request $request)
    {
        $param = [
            "id" => $request->id,
        ];
        $item = DB::delete("delete from peoples where id = :id", $param);
        return redirect("/hello");
    }
}
