<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Author::get(),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name_author' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $Author = Author::create($request->all());
        return response()->json($Author,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Author = Author::find($id);
        if(is_null($Author)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(Author::find($id),200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Author = Author::find($id);
        if(is_null($Author)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $Author -> update($request -> all());
        return response()->json($Author,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Author = Author::find($id);
        if(is_null($Author)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $Author-> delete();
        return response()->json(null,204);
    }

    public function getAuthor($id)
    {
        $author = Author::find($id)->comic()->get();

        return response()->json($author, 200);

    }
}
