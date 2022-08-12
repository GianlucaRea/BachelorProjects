<?php

namespace App\Http\Controllers;

use App\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Wishlist::get(),200);
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

            'user_id' => 'required'


        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $Wishlist = Wishlist::create($request->all());
        return response()->json($Wishlist,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Wishlist = Wishlist::find($id);
        if(is_null($Wishlist)){
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
        $Wishlist = Wishlist::find($id);
        if(is_null($Wishlist)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $Wishlist -> update($request -> all());
        return response()->json($Wishlist,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Wishlist = Wishlist::find($id);
        if(is_null($Wishlist)){
            return redirect()->route("AdminAccount")->with('message','Alredy Deleted');
        }
        $Wishlist -> delete();
        return redirect()->route("AdminAccount")->with('message','Success');
    }

    public static function getAllListByUser($id){
        return DB::table('wishlists')->where('user_id', '=', $id)->get();
    }

    public static function getWishByUser($id){
        return DB::table('wishlists')->where('user_id', '=', $id)->first();
    }

    public static function getComicsWishlist($id){
       return DB::table('wishlists')->where('wishlists.user_id', '=', $id)->join('comic_wishlist', 'wishlists.id', '=', 'comic_wishlist.wishlist_id')->get();
    }

    public static function control($id){
        $user = Auth::user();
        if(DB::table('comic_wishlist')->where('wishlist_id', '=', $id)->count() > 0){
            return true;}
        else{
            return false;}
    }

    public static function addToList($id){
        if(Auth::user()) {
            $user = Auth::user();
            if(WishlistController::alreadyToList($id, $user->id)){
                return redirect()->back();
            }
            else{
            $data1 = array('user_id' => $user->id);
            $wishlist_id = Wishlist::create($data1);
            $data2 = array('comic_id' => $id, 'wishlist_id' => $wishlist_id->id);
            DB::table('comic_wishlist')->insert($data2);

            return redirect()->back();
            }
        }
        else{
            return redirect('/login');
        }
    }

    public static function alreadyToList($comic_id, $user_id){
        if(DB::table('wishlists')->where('user_id', '=', $user_id)->exists()) {
            $wishlists= DB::table('wishlists')->where('user_id', '=', $user_id)->get();
            foreach ($wishlists as $wishlist) {
                if (DB::table('comic_wishlist')->where('comic_id', '=', $comic_id)->where('wishlist_id', '=', $wishlist->id)->exists()) {
                    return true;
                }
            }
        }
        else{
            return false;
        }
    }

    public static function removeToList($id){
        if(Auth::user()) {
            $user = Auth::user();
            $toRemove = DB::table('comic_wishlist')->join('wishlists', 'comic_wishlist.wishlist_id', '=', 'wishlists.id')->where('wishlists.user_id', '=', $user->id)->where('comic_wishlist.comic_id', '=', $id)->first();
            DB::table('comic_wishlist')->delete($toRemove->id);
            DB::table('wishlists')->delete($toRemove->wishlist_id);
            return redirect()->back();
        }
        else{
            return redirect('/login');
        }
    }

    public static function getComicWishlistTuple($id){
        return ComicController::getByID(DB::table('comic_wishlist')->where('wishlist_id', '=', $id)->first()->comic_id);
    }



    public static function removeToListCaseLost($id){
        if(Auth::user()) {
            $user = Auth::user();
            $toRemove = DB::table('wishlists')->where('wishlists.id', '=', $id)->delete();
            return redirect()->back();
        }
        else{
            return redirect('/login');
        }
    }

    public static function wishlistCountByUserId($id){
        if(DB::table('wishlists')->where('user_id', '=', $id)->count()>0){
            return DB::table('wishlists')->where('user_id', '=', $id)->count();
        }
        else{
            return 0;
        }
    }

    public static function userHasList($id){
        if(DB::table('wishlists')->where('user_id', '=', $id)->count()>0){
            return true;
        }
        else{
            return false;
        }
    }

    public function wishSearchUser(Request $request){
        $search = $request->input('search');
        $list = DB::table('wishlists')->join('comic_wishlist', 'comic_wishlist.wishlist_id', '=', 'wishlists.id')->join('comics', 'comic_wishlist.comic_id', '=', 'comics.id')->join('users', 'comics.user_id', '=', 'users.id')->where('comics.comic_name','LIKE','%'.$search.'%')->orWhere('users.username','LIKE','%'.$search.'%')->orWhere('comics.description','LIKE','%'.$search.'%')->select('wishlists.*')->paginate(6);
        return UserController::dashboardList($list);
    }

}
