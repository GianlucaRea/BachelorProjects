<?php

namespace App\Http\Controllers;

use App\Comic;
use App\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Genre::get(),200);
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
            'name_genre' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $Genre = Genre::create($request->all());
        return response()->json($Genre,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Genre = Genre::find($id);
        if(is_null($Genre)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(Genre::find($id),200);
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
        $Genre = Genre::find($id);
        if(is_null($Genre)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $Genre -> update($request -> all());
        return response()->json($Genre,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Genre = Genre::find($id);
        if(is_null($Genre)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $Genre-> delete();
        return response()->json(null,204);
    }


    public static function countComics($id){
        return $number = Genre::find($id)->comic()->count();
    }

    public static function getComics($name_genre){
        return $comics = Genre::where('name_genre','=',$name_genre)->first()->comic()->paginate(9);

    }

    public static function getAllGenres(){
        return Genre::all();
    }

}
