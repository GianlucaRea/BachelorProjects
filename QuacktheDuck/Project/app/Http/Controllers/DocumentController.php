<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Document;
use Illuminate\Support\Facades\DB;
use Validator;
class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Document::get(),200);
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
            'id_user_document'=>'required',
            'title' => 'required|min:3',
            'university' => 'required',
            'course' => 'required',
            'subject' => 'required',

        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $document = Document::create($request->all());
        return response()->json($document,201);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = Document::find($id);
        if(is_null($document)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(Document::find($id),200);
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
        $document = Document::find($id);
        if(is_null($document)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $document -> update($request -> all());
        return response()->json($document,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy($id)
    {
        $document = Document::find($id);
        if(is_null($document)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $document-> delete();
        return response()->json(null,204);
    }

    public function getUser($id){
        $doc = Document::find($id)->user()->get();

        return response()->json($doc, 200);
    }

    public function getContent($id)
    {
        $doc = Document::find($id)->content()->get();

        return response()->json($doc, 200);
    }

    public function getTags($id)
    {
        $doc = Document::find($id)->tag()->get();

        return response()->json($doc, 200);
    }

    public function getReviews($id)
    {
        $doc = Document::find($id)->review()->get();

        return response()->json($doc, 200);
    }

    public function  getVersions($id){

        $doc = Document::find($id)->version()->get();

        return response()->json($doc, 200);
    }
}
