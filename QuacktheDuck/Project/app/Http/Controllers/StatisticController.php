<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Statistic;
use Illuminate\Support\Facades\DB;
use Validator;

class StatisticController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Statistic::get(),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $rules=[
            'id_user' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $statistic = Statistic::create($request->all());
        return response()->json($statistic,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\Response
     */
    public function show($id_user)
    {
        $statistic = Statistic::find($id_user);
        if(is_null($statistic)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(Statistic::find($statistic),200);
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
        $statistic = Statistic::find($id);
        if(is_null($statistic)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $statistic -> update($request -> all());
        return response()->json($statistic,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $statistic = Statistic::find($id);
        if(is_null($statistic)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $statistic-> delete();
        return response()->json(null,204);
    }

    public function getUser($id)
    {
        $doc = Statistic::find($id)->user()->get();

        return response()->json($doc, 200);
    }

    public function getAvgFeedbackDoc($id){

        //select  from review_table inner join document on document.id = review_table.document_id and document.user_id = $id;
        $average = DB::select( DB::raw("select avg(stars_number) as average from reviews inner join documents on documents.id = reviews.id_document_reviewed and documents.id_user_document = $id"));


        $stat = Statistic::where('id_user',$id)->first();
        $stat -> average_feedback_total_doc = $average[0]->average;
        $stat -> save();
        return $stat;


    }


    public function getNumberUploadedDoc($id){
        $number = DB::select( DB::raw("select count(id) as number_uploaded_doc from documents where id_user_document = $id"));
        $stat = Statistic::where('id_user',$id)->first();
        $stat -> number_uploaded_doc = $number[0]->number_uploaded_doc;
        $stat -> save();
        return $stat;
    }

    public function getPointsFeedbackTotalDoc($id){
        $points = DB::select( DB::raw("select sum(stars_number) as points from reviews inner join documents on documents.id = reviews.id_document_reviewed and documents.id_user_document = $id"));

        $stat = Statistic::where('id_user',$id)->first();
        $stat -> points_feedback_total_doc = $points[0]->points;
        $stat -> save();
        return $stat;

    }


}
