<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Controllers\Controller;
use App\Statistic;
use Illuminate\Http\Request;
use App\User;
use Validator;
class UtenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return response()->json(User::get(),200);
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
        $validator = Validator::make($request->all());
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $user = User::create($request->all());
        $id = $user->id;
        Statistic::create(['id_user'=>$id]);
        return response()->json($user,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_user = $id ;
        $user = User::find($id_user);
        if(is_null($user)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(User::find($id_user),200);
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
        $utente = User::find($id);
        if(is_null($utente)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $utente -> update($request -> all());
        return response()->json($utente,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $utente = User::find($id);
        if(is_null($utente)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $utente-> delete();
        return response()->json(null,204);
    }

    public function getDoc($id){
        $user = User::find($id)->document()->get();

        return response()->json($user,200);
    }

    public function getReviews($id){
        $user = User::find($id)->review()->get();

        return response()->json($user,200);
    }

    public function getStatistic($id){
        $user = User::find($id)->statistic()->get();

        return response()->json($user,200);
    }

    public function SearchDocByUniversity($id){
        $university = User::find($id)->getUniversity();
        $documents = Document::where('university',$university)->get();
        return response()->json($documents,200);
    }



}
