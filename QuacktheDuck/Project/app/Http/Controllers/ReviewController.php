<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Review;
use Illuminate\Support\Facades\DB;
use Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Review::get(),200);
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
            'id_review_by_user'=>'required',
             'id_document_reviewed'=>'required',
            'stars_number'=> 'required|integer|min:1|max:5'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $review = Review::create($request->all());
        return response()->json($review,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $review = Review::find($id);
        if(is_null($review)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(Review::find($id),200);
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
        $rules = [
            'stars_number'=> 'numeric|min:1|max:5',
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $review = Review::find($id);
        if(is_null($review)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $review -> update($request -> all(),$rules);
        return response()->json($review,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::find($id);
        if(is_null($review)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $review-> delete();
        return response()->json(null,204);
    }

    public function getDocument($id)
    {
        $doc = Review::find($id)->document()->get();

        return response()->json($doc, 200);
    }
    public function getUser($id)
    {
        $doc = Review::find($id)->user()->get();

        return response()->json($doc, 200);
    }


}
