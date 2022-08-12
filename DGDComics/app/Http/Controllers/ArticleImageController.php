<?php

namespace App\Http\Controllers;

use App\ArticleImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;

class ArticleImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ArticleImage::get(),200);

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
        $rules=[
            'article_id' => 'required',
            'image_name' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $image = ArticleImage::create($request->all());
        return response()->json($image,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = ArticleImage::find($id);
        if(is_null($image)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(ArticleImage::find($id),200);
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
        $image = ArticleImage::find($id);
        if(is_null($image)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $image -> update($request -> all());
        return response()->json($image,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = ArticleImage::find($id);
        if(is_null($image)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $image-> delete();
        return response()->json(null,204);
    }

    public static function getImageByArticleId($id){
        return ArticleImage::where('article_id', '=', $id)->first();
    }

    public function getArticleByImageId($id)
    {
        $image = ArticleImage::find($id)->article()->get();

        return response()->json($image, 200);
    }

    public static function moveFileCover(Request $request, $id){

        if($request->has('articleImage')){
            $image = $request->file('articleImage');
            $name = Str::random(16);
            $image->move(public_path("img/comicsImages"), $name);

            $image = new ArticleImage();
            $image->article_id = $id;
            $image->image_name = $name;

            $data = array(
                'article_id' => $image->article_id,
                'image_name' => $image->image_name,
            );

            DB::table('article_images')->insert($data);
        }

        return redirect()->back();

    }
}
