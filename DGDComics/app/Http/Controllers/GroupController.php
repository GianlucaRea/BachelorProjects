<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Group::get(),200);
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
            'group_description' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $Group = Group::create($request->all());
        return response()->json($Group,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Group = Group::find($id);
        if(is_null($Group)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(Group::find($id),200);
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
        $Group = Group::find($id);
        if(is_null($Group)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $Group -> update($request -> all());
        return response()->json($Group,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Group = Group::find($id);
        if(is_null($Group)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $Group-> delete();
        return response()->json(null,204);
    }


    public static function vendorUpdate(){
        $user = Auth::user();
        $data=array(
            'group_id'=> '2',
            'user_id' => $user->id,
        );
        $data2=array(
            'user_id' => $user->id,
        );
        DB::table('group_user')->where("user_id", "=", $user->id)->update($data);
        DB::table('rankings')->insert($data2);

    }

    public static function isVendor($id){



        $n = DB::table("group_user")->where("user_id", "=", $id)->where("group_id", "=", 2)->count();
        if($n>0){
            return true;
        }
        else{
            return false;
        }
    }




    public static function isAdmin($id){
        $n = DB::table("group_user")->where("user_id", "=", $id)->where("group_id", "=", 3)->count();
        if($n>0){
            return true;
        }
        else{
            return false;
        }
    }
}