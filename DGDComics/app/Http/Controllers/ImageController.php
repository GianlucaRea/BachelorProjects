<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Image::get(),200);

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
            'comic_id' => 'required',
            'image_name' => 'required',
            'cover' => 'required',
            'imageNumber' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $image = Image::create($request->all());
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
        $image = Image::find($id);
        if(is_null($image)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(Image::find($id),200);
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
        $image = Image::find($id);
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
        $image = Image::find($id);
        if(is_null($image)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $image-> delete();
        return response()->json(null,204);
    }

    public static function getCover($id){
        return Image::where('comic_id', '=', $id)->where('cover', '=', 1)->first();
    }

    public static function getOtherImages($id){
        return Image::where('comic_id', '=', $id)->where('cover', '=', 0)->get();
    }

    public static function getOtherImagesOrdered($id){
        return Image::where('comic_id', '=', $id)->where('cover', '=', 0)->orderBy('imageNumber', 'asc')->get();
    }

    public function getComic($id)
    {
        $image = Image::find($id)->comic()->get();

        return response()->json($image, 200);
    }
    public static function getImageByNumber ($id, $num){
        $true = Image::where('comic_id', '=', $id)->where('imageNumber', '=', $num)->get();
        if ($true != null)
            return Image::where('comic_id', '=', $id)->where('imageNumber', '=', $num)->first();
        else
            return null;

    }

    public static function moveFileCover(Request $request, $id){

        //get image file
        $image = $request->file('cover');
        $name = Str::random(16);

        $image->move(public_path("img/comicsImages"), $name);

        $imageC = new Image();
        $imageC->comic_id = $id;
        $imageC->image_name = $name;
        $imageC->cover = 1;
        $imageC->imageNumber = 0;

        $data = array(
            'comic_id' => $imageC->comic_id,
            'image_name' => $imageC->image_name,
            'cover' => $imageC->cover,
            'imageNumber' => $imageC->imageNumber,
        );
        DB::table('images')->insert($data);

        return redirect()->back();

    }

    public static function addImagesToComic(Request $request, $id){

        if($request->has('image1')){
            $imageA = $request->file('image1');
            $nameA = Str::random(16);
            $imageA->move(public_path("img/comicsImages"), $nameA);

            $image1 = new Image();
            $image1->comic_id = $id;
            $image1->image_name = $nameA;
            $image1->cover = 0;
            $image1->imageNumber = 1;

            $data1 = array(
                'comic_id' => $image1->comic_id,
                'image_name' => $image1->image_name,
                'cover' => $image1->cover,
                'imageNumber' => $image1->imageNumber,
            );
            DB::table('images')->insert($data1);
        }

        if($request->has('image2')){
            $imageB = $request->file('image2');
            $nameB = Str::random(16);
            $imageB->move(public_path("img/comicsImages"), $nameB);

            $image2 = new Image();
            $image2->comic_id = $id;
            $image2->image_name = $nameB;
            $image2->cover = 0;
            $image2->imageNumber = 2;

            $data2 = array(
                'comic_id' => $image2->comic_id,
                'image_name' => $image2->image_name,
                'cover' => $image2->cover,
                'imageNumber' => $image2->imageNumber,
            );
            DB::table('images')->insert($data2);
        }

        if($request->has('image3')){
            $imageC = $request->file('image3');
            $nameC = Str::random(16);
            $imageC->move(public_path("img/comicsImages"), $nameC);

            $image3 = new Image();
            $image3->comic_id = $id;
            $image3->image_name = $nameC;
            $image3->cover = 0;
            $image3->imageNumber = 3;

            $data3 = array(
                'comic_id' => $image3->comic_id,
                'image_name' => $image3->image_name,
                'cover' => $image3->cover,
                'imageNumber' => $image3->imageNumber,
            );
            DB::table('images')->insert($data3);
        }

        if($request->has('image4')){
            $imageD = $request->file('image4');
            $nameD = Str::random(16);
            $imageD->move(public_path("img/comicsImages"), $nameD);

            $image4 = new Image();
            $image4->comic_id = $id;
            $image4->image_name = $nameD;
            $image4->cover = 0;
            $image4->imageNumber = 4;

            $data4 = array(
                'comic_id' => $image4->comic_id,
                'image_name' => $image4->image_name,
                'cover' => $image4->cover,
                'imageNumber' => $image4->imageNumber,
            );
            DB::table('images')->insert($data4);
        }



    }
}
