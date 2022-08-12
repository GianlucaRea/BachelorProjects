<?php

namespace App\Http\Controllers;


use App\ComicBought;
use App\Genre;
use App\Http\Controllers\Controller;
use App\Image;
use App\Notification;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use App\Comic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Component\Console\Input\Input;
use Validator;

class ComicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Comic::get(),200);
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
     * @param \Illuminate\Http\Request $request
     * @param array $genre_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,array $genre_id) //array $genre_id passa un array di id che corrispondono
    {                                                       //ai generi che prenderà il fumetto
        $rules = [
            'user_id'=>'required',
            'id_author'=>'required',
            'comic_name'=>'required',
            'type'=>'required',
            'quantity'=>'required',
            'ISBN'=>'required',
            'price'=>'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $Comic = Comic::create($request->all());
        $Genre = Genre::find($genre_id); // Prendi genere in base all'id passato
        $Comic->genre()->attach($Genre); // Attacca al Comic i generi passati come argomento
        //Questo codice non è sicuro sia funzionante Codice di Gianluca Rea
        return response()->json($Comic,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Comic = Comic::find($id);
        if(is_null($Comic)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(Comic::find($id),200);
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
        $Comic = Comic::find($id);
        if(is_null($Comic)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $Comic -> update($request -> all());
        return response()->json($Comic,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy($id)
    {
        $Comic = Comic::find($id);
        $notification = new Notification;
        $notification->user_id = $Comic->user_id;
        $notification->state = false;
        $notification->notification_text = 'Il tuo fumetto non era in accordo con le policy di DGDComics';

        $data = array(
            'user_id' => $notification->user_id,
            'state' =>  $notification->state,
            'notification_text' => $notification->notification_text,
            'notification' => 'contact',
            'idLink' => 0
        );
        if(is_null($Comic)){
            return redirect()->back()->with('message','Alredy Deleted');
        }
        $this->removeForAdmin($id);
        $Comic -> delete();
        DB::table('notifications')->insert($data);

        return redirect()->back()->with('message','Success');
    }

    public function destroyForVendor($id){
        if(Auth::user()) {
            $Comic = Comic::find($id);

            if (is_null($Comic)) {
                return redirect()->back()->with('message', 'Alredy Deleted');
            }
            $this->removeForAdmin($id);
            $Comic->delete();

            return redirect()->back()->with('message', 'Success');
        }
        else
            return redirect('/login');
    }



    public static function getByID($id){
        return Comic::where('id','=',$id)->first();
    }


    public function getUser($id){
        $comic = Comic::find($id)->User()->get();

        return response()->json($comic, 200);
    }

    public function getAuthor($id)
    {
        $comic = Comic::find($id)->Author()->get();

        return response()->json($comic, 200);
    }


    public function getGenre($id)
    {
        $comic = Comic::find($id)->genre()->get();

        return response()->json($comic, 200);

    }

    public static function priceCalculator($id){
        $comic = Comic::where('id','=',$id)->first();
        if($comic->discount > 0){
            $valoreSconto = (($comic->price * $comic->discount) / 100);
            $price = ($comic->price - $valoreSconto);
            return $newPrice = number_format($price, 2);
        }
        else{
            return $comic->price;
        }
    }

    public function shoplistBase(Request $request){
        $genres = Genre::all();
        $comics = Comic::orderBy('comic_name', 'asc')->paginate(8);
        if ($request->has('sorter')){
            switch($request->get('sorter')){
                case 'comic_name_asc':
                    $comics = Comic::orderBy('comic_name', 'asc')->paginate(8);
                    break;
                case 'comic_name_desc':
                    $comics = Comic::orderBy('comic_name', 'desc')->paginate(8);
                    break;
                case 'price_asc':
                    $comics = Comic::orderBy('price', 'asc')->paginate(8);
                    break;
                case 'price_desc':
                    $comics = Comic::orderBy('price', 'desc')->paginate(8);
                    break;
                case 'created_at':
                    $comics = Comic::latest()->paginate(8);
                    break;
            }
        }
        return view('shoplist')
            ->with(compact('genres'))
            ->with(compact('comics'));
    }

    public function shoplistType($type,Request $request){
        $genres = Genre::all();
        $comics = Comic::where('type', '=', $type)->orderBy('comic_name', 'asc')->paginate(8);
        if ($request->has('sorter')) {
            switch ($request->get('sorter')) {
                case 'comic_name_asc':
                    $comics = Comic::where('type', '=', $type)->orderBy('comic_name', 'asc')->paginate(8);
                    break;
                case 'comic_name_desc':
                    $comics = Comic::where('type', '=', $type)->orderBy('comic_name', 'desc')->paginate(8);
                    break;
                case 'price_asc':
                    $comics = Comic::where('type', '=', $type)->orderBy('price', 'asc')->paginate(8);
                    break;
                case 'price_desc':
                    $comics = Comic::where('type', '=', $type)->orderBy('price', 'desc')->paginate(8);
                    break;
                case 'created_at':
                    $comics = Comic::where('type', '=', $type)->latest()->paginate(8);
                    break;
            }
        }
        return view('shoplist')
            ->with(compact('genres'))
            ->with(compact('comics'));
    }

    public function shoplistGenre($name_genre,Request $request){
        $comics = Genre::where('name_genre','=',$name_genre)->first()->comic()->orderBy('comic_name', 'asc')->paginate(8);
        $genres = Genre::all();

            if ($request->has('sorter')) {
                switch ($request->get('sorter')) {
                    case 'comic_name_asc':
                        $comics =Genre::where('name_genre','=',$name_genre)->first()->comic()->orderBy('comic_name', 'asc')->paginate(8);
                        break;
                    case 'comic_name_desc':
                        $comics = Genre::where('name_genre','=',$name_genre)->first()->comic()->orderBy('comic_name', 'desc')->paginate(8);
                        break;
                    case 'price_asc':
                        $comics = Genre::where('name_genre','=',$name_genre)->first()->comic()->orderBy('price', 'asc')->paginate(8);
                        break;
                    case 'price_desc':
                        $comics = Genre::where('name_genre','=',$name_genre)->first()->comic()->orderBy('price', 'desc')->paginate(8);
                        break;
                    case 'created_at':
                        $comics = Genre::where('name_genre','=',$name_genre)->first()->comic()->latest()->paginate(8);
                        break;
                }
            }
        return view('shoplist')->with(compact('genres'))->with(compact('comics'));
    }

    public function shoplistSearch(Request $request){
        $genres = Genre::all();
        $search = $request->input('search');
        $comics = Comic::where('comic_name','LIKE','%'.$search.'%')->orWhere('type','LIKE','%'.$search.'%')->orWhere('publisher','LIKE','%'.$search.'%')->paginate(8);
        if ($request->has('sorter')) {
            switch ($request->get('sorter')) {
                case 'comic_name_asc':
                    $comics =Comic::where('comic_name','LIKE','%'.$search.'%')->orWhere('type','LIKE','%'.$search.'%')->orWhere('publisher','LIKE','%'.$search.'%')->orderBy('comic_name', 'asc')->paginate(8);
                    break;
                case 'comic_name_desc':
                    $comics =Comic::where('comic_name','LIKE','%'.$search.'%')->orWhere('type','LIKE','%'.$search.'%')->orWhere('publisher','LIKE','%'.$search.'%')->orderBy('comic_name', 'desc')->paginate(8);
                    break;
                case 'price_asc':
                    $comics = Comic::where('comic_name','LIKE','%'.$search.'%')->orWhere('type','LIKE','%'.$search.'%')->orWhere('publisher','LIKE','%'.$search.'%')->orderBy('price', 'asc')->paginate(8);
                    break;
                case 'price_desc':
                    $comics = Comic::where('comic_name','LIKE','%'.$search.'%')->orWhere('type','LIKE','%'.$search.'%')->orWhere('publisher','LIKE','%'.$search.'%')->orderBy('price', 'desc')->paginate(8);
                    break;
                case 'created_at':
                    $comics = Comic::where('comic_name','LIKE','%'.$search.'%')->orWhere('type','LIKE','%'.$search.'%')->orWhere('publisher','LIKE','%'.$search.'%')->latest()->paginate(8);
                    break;
            }
        }
      if(count($comics) > 0)
      return view('shoplist')->with(compact('genres'))->with(compact('comics'));
      else return view ('shoplist')->with(compact('genres'))->with(compact('comics'))->withMessage('No Details found. Try to search again !');
    }

    public function shoplistManga(){
        $genres = Genre::all();
        $comics = Comic::where('comic_name','LIKE','%manga%')->orWhere('type','LIKE','%manga%')->orWhere('publisher','LIKE','%manga%')->paginate(8);
        if(count($comics) > 0)
            return view('shoplist')->with(compact('genres'))->with(compact('comics'));
        else return view ('shoplist')->with(compact('genres'))->with(compact('comics'))->withMessage('No Details found. Try to search again !');
    }

    public function shoplistSupereroi(){
        $genres = Genre::all();
        $comics = Comic::where('type','LIKE','%marvel%')->orWhere('type','LIKE','%dc%')->paginate(8);
        if(count($comics) > 0)
            return view('shoplist')->with(compact('genres'))->with(compact('comics'));
        else return view ('shoplist')->with(compact('genres'))->with(compact('comics'))->withMessage('No Details found. Try to search again !');
    }

    public function shoplistItaliani(){
        $genres = Genre::all();
        $comics = Comic::where('type','LIKE','%italiano%')->paginate(8);
        if(count($comics) > 0)
            return view('shoplist')->with(compact('genres'))->with(compact('comics'));
        else return view ('shoplist')->with(compact('genres'))->with(compact('comics'))->withMessage('No Details found. Try to search again !');
    }

    public function comicDetail($id){
        $isNotPassed = false;
        $comic = Comic::find($id);
        $related = \App\Http\Controllers\ComicController::getrelated($id);
        $reviews = Review::where('comic_id','=',$id)->get();
        $reviews4 = Review::where('comic_id','=',$id)->orderBy('review_date', 'desc')->get();
        $avgstar = Review::where('comic_id','=',$id)->avg('stars');
        return view('comic_detail')
            ->with(compact('comic'))
            ->with(compact('related'))
            ->with(compact('reviews'))
            ->with(compact('reviews4'))
            ->with(compact('isNotPassed'));
    }

    public static function comicDetailError($id){
        $isNotPassed = true;
        $comic = Comic::find($id);
        $related = \App\Http\Controllers\ComicController::getrelated($id);
        $reviews = Review::where('comic_id','=',$id)->get();
        $reviews4 = Review::where('comic_id','=',$id)->orderBy('review_date', 'desc')->get();
        $avgstar = Review::where('comic_id','=',$id)->avg('stars');
        return view('comic_detail')
            ->with(compact('comic'))
            ->with(compact('related'))
            ->with(compact('reviews'))
            ->with(compact('reviews4'))
            ->with(compact('isNotPassed'));
    }

    public function comicsSearchAdmin(Request $request){
        $search = $request->input('search');
        $comics = DB::table('comics')->join('users', 'comics.user_id', '=', 'users.id')->where('comics.comic_name','LIKE','%'.$search.'%')->orWhere('comics.description','LIKE','%'.$search.'%')->orWhere('comics.type','LIKE','%'.$search.'%')->orWhere('comics.language','LIKE','%'.$search.'%')->orWhere('comics.publisher','LIKE','%'.$search.'%')->orWhere('users.username','LIKE','%'.$search.'%')->orWhere('comics.comic_name','LIKE','%'.$search.'%')->select('comics.*')->paginate(12);
        return AdminController::dashboardComics($comics);
    }

    public function comicVendorSearchUser(Request $request){
        $search = $request->input('search');
        $id = Auth::user()->id;
        $comics = DB::table('comics')->where('comics.comic_name','LIKE','%'.$search.'%')->orWhere('comics.description','LIKE','%'.$search.'%')->orWhere('comics.type','LIKE','%'.$search.'%')->orWhere('comics.language','LIKE','%'.$search.'%')->orWhere('comics.publisher','LIKE','%'.$search.'%')->where('comics.user_id', '=', $id)->select('comics.*')->paginate(6);
        return UserController::dashboardComicVendor($comics);
    }

    public function shoplistPrice0(Request $request){
        $number1 = 0;
        $number2 = 3.99;
        $genres = Genre::all();
        $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->paginate(8);
        if ($request->has('sorter')) {
            switch ($request->get('sorter')) {
                case 'comic_name_asc':
                    $comics =Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('comic_name', 'asc')->paginate(8);
                    break;
                case 'comic_name_desc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('comic_name', 'desc')->paginate(8);
                    break;
                case 'price_asc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('price', 'asc')->paginate(8);
                    break;
                case 'price_desc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('price', 'desc')->paginate(8);
                    break;
                case 'created_at':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->latest()->paginate(8);
                    break;
            }
        }
        return view('shoplist')->with(compact('genres'))->with(compact('comics'));
    }
    public function shoplistPrice1(Request $request){
        $number1 = 3.99;
        $number2 = 8;
        $genres = Genre::all();
        $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->paginate(8);
        if ($request->has('sorter')) {
            switch ($request->get('sorter')) {
                case 'comic_name_asc':
                    $comics =Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('comic_name', 'asc')->paginate(8);
                    break;
                case 'comic_name_desc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('comic_name', 'desc')->paginate(8);
                    break;
                case 'price_asc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('price', 'asc')->paginate(8);
                    break;
                case 'price_desc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('price', 'desc')->paginate(8);
                    break;
                case 'created_at':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->latest()->paginate(8);
                    break;
            }
        }
        return view('shoplist')->with(compact('genres'))->with(compact('comics'));
    }
    public function shoplistPrice2(Request $request){
        $number1 = 7.99;
        $number2 = 15.00;
        $genres = Genre::all();
        $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->paginate(8);
        if ($request->has('sorter')) {
            switch ($request->get('sorter')) {
                case 'comic_name_asc':
                    $comics =Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('comic_name', 'asc')->paginate(8);
                    break;
                case 'comic_name_desc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('comic_name', 'desc')->paginate(8);
                    break;
                case 'price_asc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('price', 'asc')->paginate(8);
                    break;
                case 'price_desc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('price', 'desc')->paginate(8);
                    break;
                case 'created_at':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->latest()->paginate(8);
                    break;
            }
        }
        return view('shoplist')->with(compact('genres'))->with(compact('comics'));
    }
    public function shoplistPrice3(Request $request){
        $number1 = 14.99;
        $number2 = 25.00;
        $genres = Genre::all();
        $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->paginate(8);
        if ($request->has('sorter')) {
            switch ($request->get('sorter')) {
                case 'comic_name_asc':
                    $comics =Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('comic_name', 'asc')->paginate(8);
                    break;
                case 'comic_name_desc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('comic_name', 'desc')->paginate(8);
                    break;
                case 'price_asc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('price', 'asc')->paginate(8);
                    break;
                case 'price_desc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('price', 'desc')->paginate(8);
                    break;
                case 'created_at':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->latest()->paginate(8);
                    break;
            }
        }
        return view('shoplist')->with(compact('genres'))->with(compact('comics'));
    }
    public function shoplistPrice4(Request $request){
        $number1 = 24.99;
        $number2 = 2500;
        $genres = Genre::all();
        $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->paginate(8);
        if ($request->has('sorter')) {
            switch ($request->get('sorter')) {
                case 'comic_name_asc':
                    $comics =Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('comic_name', 'asc')->paginate(8);
                    break;
                case 'comic_name_desc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('comic_name', 'desc')->paginate(8);
                    break;
                case 'price_asc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('price', 'asc')->paginate(8);
                    break;
                case 'price_desc':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->orderBy('price', 'desc')->paginate(8);
                    break;
                case 'created_at':
                    $comics = Comic::where('price','>',$number1)->where('price','<',$number2)->latest()->paginate(8);
                    break;
            }
        }
        return view('shoplist')->with(compact('genres'))->with(compact('comics'));    }

    public function shoplistSale(Request $request){
        $genres = Genre::all();
        $comics = Comic::where('discount','>','0')->orderBy('discount','asc')->paginate(8);
        if ($request->has('sorter')) {
            switch ($request->get('sorter')) {
                case 'comic_name_asc':
                    $comics =Comic::where('discount','>','0')->orderBy('comic_name', 'asc')->paginate(8);
                    break;
                case 'comic_name_desc':
                    $comics = Comic::where('discount','>','0')->orderBy('comic_name', 'desc')->paginate(8);
                    break;
                case 'price_asc':
                    $comics = Comic::where('discount','>','0')->orderBy('price', 'asc')->paginate(8);
                    break;
                case 'price_desc':
                    $comics = Comic::where('discount','>','0')->orderBy('price', 'desc')->paginate(8);
                    break;
                case 'created_at':
                    $comics = Comic::where('discount','>','0')->latest()->paginate(8);
                    break;
            }
        }
        return view('shoplist')->with(compact('genres'))->with(compact('comics'));
    }

    public function shoplistDate(Request $request){
        $genres = Genre::all();
        $comics = Comic::orderBy('created_at','desc')->paginate(8);

        return view('shoplist')->with(compact('genres'))->with(compact('comics'));
    }

    public function shoplistOnePiece(Request $request){
        $genres = Genre::all();
        $comics = Comic::where('comic_name','LIKE','%'.'One Piece'.'%')->orWhere('comic_name','LIKE','%'.'OnePiece'.'%')->paginate(8);

        return view('shoplist')->with(compact('genres'))->with(compact('comics'));
    }

    public function shoplistTopolino(Request $request){
        $genres = Genre::all();
        $comics = Comic::where('comic_name','LIKE','%'.'Topolino'.'%')->paginate(8);

        return view('shoplist')->with(compact('genres'))->with(compact('comics'));
    }

    public function shoplistTWD(Request $request){
        $genres = Genre::all();
        $comics = Comic::where('comic_name','LIKE','%'.'The Walking Dead'.'%')->orWhere('comic_name','LIKE','%'.'TheWalking Dead'.'%')->orWhere('comic_name','LIKE','%'.'The WalkingDead'.'%')->orWhere('comic_name','LIKE','%'.'TheWalkingDead'.'%')->paginate(8);

        return view('shoplist')->with(compact('genres'))->with(compact('comics'));
    }

    public function shoplistSuggest(Request $request){
        $genres = Genre::all();
        $comics = Comic::where('suggest','=','1')->paginate(8);

        return view('shoplist')->with(compact('genres'))->with(compact('comics'));
    }

    public function suggestComic(Request $request){
        $comic = comic::where('id', '=', $request->id)->first();
        if ($comic->suggest == true){
            $data = array('suggest' => 0,);
            DB::table('comics')->where('id', '=', $comic->id)->update($data);
            return redirect()->back();
        }
        else{
            $data = array('suggest' => 1,);
            DB::table('comics')->where('id', '=', $comic->id)->update($data);
            return redirect()->back();
        }
    }







    public static function countByDiscount(){
        return Comic::where('discount','>','0')->count();
    }

    public static function countByPrice($number1,$number2){
        return Comic::where('price','>',$number1)->where('price','<',$number2)->count();
    }

    public static function getByPrice($number1,$number2){
        return Comic::where('price','>',$number1)->where('price','<',$number2)->paginate(8);
    }

    public static function countByType($text){
        return Comic::where('type','=',$text)->count();
    }

    public static function getNewComic(){
        return Comic::latest()->where('quantity', '>', 0)->take(6)->get();
    }

    public static function  getComicByDiscount(){
        return Comic::orderByDesc('discount')->take(10)->get();
    }

    public static function getComicByDiscountAndNumber($number){
        return Comic::orderByDesc('discount')->skip($number)->first();
    }

    public static function getManga(){
        return Comic::whereIn('type',['shonen','seinen','shojo','josei'])->where('quantity', '>', 0)->inRandomOrder()->take(7)->get();
    }

    public static function getAmerican(){
        return Comic::whereIn('type',['marvel','dc'])->where('quantity', '>', 0)->inRandomOrder()->take(7)->get();
    }

    public static function getItalian(){
       return Comic::whereIn('type',['italiano'])->where('quantity', '>', 0)->inRandomOrder()->take(7)->get();
    }

    public static function getrelated($id){
        $target = Comic::find($id);
        return Comic::whereIn('author_id',[$target ->author_id])->where('id', '!=', $id)->take(4)->get();
     }

     public static function getSeller($id){
        $sold = Comic::find($id);
        return User::find($sold->user_id);
     }

    public function addToCart($id, Request $request)
    {
        $comic = Comic::find($id);
        $user = Auth::user();

        if($comic->quantity>0) {

            if (!$comic) {

                abort(404);

            }

            $cart = session()->get('cart');
            $image = ImageController::getCover($id);

            if($user->id == self::getSeller($id)->id){
                return redirect('comic_detail/'.$comic->id)->with('error', 'seems something went wrong!');
            }

            // if cart is empty then this the first comic
            if (!$cart) {

                $cart = [
                    1 => [
                        "user" => $user->id,
                        "comic_id" => $id,
                        "name" => $comic->comic_name,
                        "quantity" => $request->qty,
                        "price" => $comic->price,
                        "image" => $image->image_name,
                    ]
                ];

                session()->put('cart', $cart);

                $newQuantity = $comic->quantity - $request->qty;
                DB::table('comics')->where('id', $comic->id)->update(['quantity' => $newQuantity]);
                $data=array(
                    'sessionId'=> 1,
                );
                DB::table('sessions')->insert($data);
                return redirect('comic_detail/'.$comic->id)->with('success', 'comic added to cart successfully!');
            } else {
                $idSession = DB::table('sessions')->latest()->first()->sessionId; //2
                // if cart not empty then check if this comic exist then increment quantity
                foreach (session('cart') as $id2 => $detail) {
                    if(isset($cart[$id2])) {
                        if ($detail["user"] == $user->id && $detail["comic_id"] == $comic->id) {
                            $cart[$id2]['quantity'] = $cart[$id2]['quantity'] + $request->qty;

                            session()->put('cart', $cart);

                            $newQuantity = $comic->quantity - $request->qty;
                            DB::table('comics')->where('id', $comic->id)->update(['quantity' => $newQuantity]);
                            return redirect('comic_detail/'.$comic->id)->with('success', 'comic added to cart successfully!');
                        }
                    }
                }

                // if item not exist in cart then add to cart with passed quantity
                $cart[$idSession+1] = [
                    "user" => $user->id,
                    "comic_id" => $id,
                    "name" => $comic->comic_name,
                    "quantity" => $request->qty,
                    "price" => $comic->price,
                    "image" => $image->image_name,
                ];

                session()->put('cart', $cart);
                $newQuantity = $comic->quantity - $request->qty;
                DB::table('comics')->where('id', $comic->id)->update(['quantity' => $newQuantity]);
                $data=array(
                    'sessionId'=> $idSession+1,
                );
                DB::table('sessions')->insert($data);
                return redirect('comic_detail/'.$comic->id)->with('success', 'comic added to cart successfully!');
            }
        }
        return redirect('comic_detail/'.$comic->id)->with('error', 'seems something went wrong!');
    }

    public function addToCart1($id)
    {
        $comic = Comic::find($id);
        $user = Auth::user();
        if($comic->quantity>0) {

            if (!$comic) {

                abort(404);

            }

            if($user->id == self::getSeller($id)->id){
                return redirect('comic_detail/'.$comic->id)->with('error', 'seems something went wrong!');
            }

            $cart = session()->get('cart');
            $image = ImageController::getCover($id);

            // if cart is empty then this the first comic
            if (!$cart) {

                $cart = [
                    1 => [
                        "user" => $user->id,
                        "comic_id" => $id,
                        "name" => $comic->comic_name,
                        "quantity" => 1,
                        "price" => $comic->price,
                        "image" => $image->image_name,
                    ]
                ];

                session()->put('cart', $cart);

                $newQuantity = $comic->quantity - 1;
                DB::table('comics')->where('id', $comic->id)->update(['quantity' => $newQuantity]);
                $data=array(
                    'sessionId'=> 1,
                );
                DB::table('sessions')->insert($data);
                return redirect()->back()->with('success', 'comic added to cart successfully!');
            } else {
                $idSession = DB::table('sessions')->latest()->first()->sessionId; //2
                // if cart not empty then check if this comic exist then increment quantity
                foreach (session('cart') as $id2 => $detail) {
                    if(isset($cart[$id2])){
                        if ($detail["user"] == $user->id && $detail["comic_id"] == $comic->id) {
                            $cart[$id2]['quantity'] = $cart[$id2]['quantity'] + 1;

                            session()->put('cart', $cart);

                            $newQuantity = $comic->quantity - 1;
                            DB::table('comics')->where('id', $comic->id)->update(['quantity' => $newQuantity]);
                            return redirect()->back()->with('success', 'comic added to cart successfully!');
                        }
                    }
                }

                // if item not exist in cart then add to cart with passed quantity
                $cart[$idSession+1] = [
                    "user" => $user->id,
                    "comic_id" => $id,
                    "name" => $comic->comic_name,
                    "quantity" => 1,
                    "price" => $comic->price,
                    "image" => $image->image_name,
                ];

                session()->put('cart', $cart);
                $newQuantity = $comic->quantity - 1;
                DB::table('comics')->where('id', $comic->id)->update(['quantity' => $newQuantity]);
                $data=array(
                    'sessionId'=> $idSession+1,
                );
                DB::table('sessions')->insert($data);
                return redirect()->back()->with('success', 'comic added to cart successfully!');
            }
        }
        return redirect()->back()->with('error', 'seems something went wrong!');
    }

    public function updateCart($id, Request $request)
    {
        $user = Auth::user();
        if($id and $request->qty)
        {
            $cart = session()->get('cart');
            foreach (session('cart') as $id2 => $details) {
                if($cart[$id2]["comic_id"] == $id && $cart[$id2]["user"] == $user->id) {
                    $idSession = DB::table('sessions')->where("sessionId", "=", $id2)->first()->sessionId;
                }
            }

            if($request->qty > $cart[$idSession]["quantity"]){ //caso in cui sto aumentando la quantità
                $comic = Comic::find($id);
                $added = $request->qty - $cart[$idSession]["quantity"];
                $newQuantity = $comic->quantity - $added;
                DB::table('comics')->where('id', $comic->id)->update(['quantity' => $newQuantity]);
            }

            if($request->qty < $cart[$idSession]["quantity"]){ //caso in cui sto rimuovendo la quantità
                $comic = Comic::find($id);
                $removed = $cart[$idSession]["quantity"] - $request->qty;
                $newQuantity = $comic->quantity + $removed;
                DB::table('comics')->where('id', $comic->id)->update(['quantity' => $newQuantity]);
            }

            $cart[$idSession]["quantity"] = $request->qty;

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'comic updated!');
        }

        return redirect()->back()->with('error', 'comic not updated!');

    }

    public function removeFromCart($id)
    {
        $user = Auth::user();
        if($id) {

            $cart = session()->get('cart');
            foreach (session('cart') as $id2 => $details) {
                if($cart[$id2]["comic_id"] == $id && $cart[$id2]["user"] == $user->id) {
                    $idSession = DB::table('sessions')->where("sessionId", "=", $id2)->first()->sessionId;
                }
            }
            $quantityInCart = $cart[$idSession]["quantity"];

            if(isset($cart[$idSession])) {

                DB::table('sessions')->where("sessionId", "=", $idSession)->delete();

                unset($cart[$idSession]);

                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product removed successfully');

            $comic = Comic::find($id);
            $newQuantity = $comic->quantity + $quantityInCart;
            DB::table('comics')->where('id', $comic->id)->update(['quantity' => $newQuantity]);

            return redirect()->back();
        }
    }

    public function removeForAdmin($id)
    {
        if($id) {

            if(session('cart')) {
                $cart = session()->get('cart');
                foreach (session('cart') as $id2 => $details) {
                    if ($cart[$id2]["comic_id"] == $id) {
                        $idSession = DB::table('sessions')->where("sessionId", "=", $id2)->first()->sessionId;
                        $quantityInCart = $cart[$idSession]["quantity"];

                        if (isset($cart[$idSession])) {

                            DB::table('sessions')->where("sessionId", "=", $idSession)->delete();

                            unset($cart[$idSession]);

                            session()->put('cart', $cart);
                        }

                        session()->flash('success', 'Product removed successfully');

                        $comic = Comic::find($id);
                        $newQuantity = $comic->quantity + $quantityInCart;
                        DB::table('comics')->where('id', $comic->id)->update(['quantity' => $newQuantity]);
                    }
                }
                return redirect()->back();
            }
        }
    }

    public static function removeAll(){
        $cart = session()->get('cart');
        $user = Auth::user();

        // if cart is empty then this the first comic
        if($cart == []) {
            return redirect('/cart');
        }
        else{
            foreach (session('cart') as $id => $details){
                if($id) {
                    if($cart[$id]['user'] == $user->id){
                        $quantityInCart = $cart[$id]["quantity"];

                        if (isset($cart[$id])) {

                            DB::table('sessions')->where("sessionId", "=", $id)->delete();

                            unset($cart[$id]);

                            session()->put('cart', $cart);
                        }

                        session()->flash('success', 'Product removed successfully');

                        $comic = Comic::find($id);
                        $newQuantity = $comic->quantity + $quantityInCart;
                        DB::table('comics')->where('id', $comic->id)->update(['quantity' => $newQuantity]);
                    }
                }
            }
        }
        return redirect()->back();
    }

    public static function removeAllForOrder(){
        $cart = session()->get('cart');
        $user = Auth::user();

        // if cart is empty then this the first comic
        if($cart == []) {
            return redirect('/cart');
        }
        else{
            foreach (session('cart') as $id => $details){
                if($id) {
                    if($cart[$id]['user'] == $user->id){

                        if (isset($cart[$id])) {

                            DB::table('sessions')->where("sessionId", "=", $id)->delete();

                            unset($cart[$id]);

                            session()->put('cart', $cart);
                        }

                        session()->flash('success', 'Product removed successfully');
                    }
                }
            }
        }
    }


    public static function topSold() {

      return  $comics = DB::table('comics')->where('comics.quantity', '>', 0)->join('comic_boughts','comics.id','=','comic_id')->groupBy('comic_boughts.quantity','comics.id','comics.comic_name','comics.price','comics.discount')->orderBy('comic_boughts.quantity','desc')->select('comic_boughts.quantity','comics.id','comics.comic_name','comics.price','comics.discount')->take(6)->get();

    }

    public static function checkIfExists($id){
        $n = DB::table("comics")->where('id', '=', $id)->count();
        if ($n > 0){
            return true;}
        else{
            return false;}
    }

    public static function  getComicOfVendor($id){
        return DB::table('comics')->where('user_id', '=', $id)->get();
    }

    public static function getComicById($id){
        return DB::table('comics')->where('id', '=', $id)->get();
    }

    public static function modifyComicPage($id){
        $comic = DB::table('comics')->where('id', '=', $id)->first();
        $author = DB::table('authors')->where('id', '=', $comic->author_id)->first();
        return view('productModify')
            ->with(compact('comic'))
            ->with(compact('author'));
    }

    public static function isgenreOfComic($comic_id, $genre_id){
        if(DB::table('comic_genre')->where('comic_id', '=', $comic_id)->where('genre_id', '=', $genre_id)->count() != 0){
            return true;
        }
        else return false;
    }

    public static function addComic(Request $request){
        if(Auth::user()){
            $request->validate([
                'comic_name' => ['required'],
                'description' => ['required'],
                'ISBN' => ['required', 'digits: 10'],
                'publisher' => 'required',
                'author_name' => 'required',
                'language' => 'required',
                'type' => 'required',
                'price' => ['required', 'regex:/^[0-9]{1,2}([.][0-9]{1,2})?$/'],
                'quantity' => 'required',
                'cover' => 'required|image|mimes:jpeg|max:16384',
                'image2' => 'image|mimes:jpeg|max:16384',
                'image3' => 'image|mimes:jpeg|max:16384',
                'image4' => 'image|mimes:jpeg|max:16384',
                'image5' => 'image|mimes:jpeg|max:16384',
            ]);

            if($request->height != null || $request->width != null || $request->length != null){
                if($request->height == null) {
                    return back()->with('error', 'error with dimension');
                }
                if($request->width == null) {
                    return back()->with('error', 'error with dimension');
                }
                if($request->length == null) {
                    return back()->with('error', 'error with dimension');
                }
            }

            if(DB::table('authors')->where('name_author', '=', $request->author_name)->count() == 1){
                $author = DB::table('authors')->where('name_author', '=', $request->author_name)->first();
            }
            else{
                $authorData = array('name_author' => $request->author_name);
                DB::table('authors')->insert($authorData);
                $author = DB::table('authors')->where('name_author', '=', $request->author_name)->first();
            }

            $price = floatval($request->price);

            $comic = new Comic;
            $comic->user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $comic->author_id = $author->id;
            $comic->comic_name = $request->comic_name;
            $comic->description = $request->description;
            $comic->type = $request->type;
            $comic->ISBN = $request->ISBN;
            $comic->quantity = $request->quantity;
            $comic->price = $price;
            $comic->language = $request->language;
            if($request->height != null){
                $comic->width = $request->width;
                $comic->length = $request->length;
                $comic->height = $request->height;
            }
            $comic->publisher = $request->publisher;

            if($request->height != null){
                $data1 = array(
                    'user_id' => $comic->user_id,
                    'author_id' => $comic->author_id,
                    'comic_name' => $comic->comic_name,
                    'description' => $comic->description,
                    'type' => $comic->type,
                    'quantity' => $comic->quantity,
                    'price' => $comic->price,
                    'publisher' => $comic->publisher,
                    'language' => $comic->language,
                    'ISBN' => $comic->ISBN,
                    'width' => $comic->width,
                    'length' => $comic->length,
                    'height' => $comic->height,
                );
            }
            else{
                $data1 = array(
                    'user_id' => $comic->user_id,
                    'author_id' => $comic->author_id,
                    'comic_name' => $comic->comic_name,
                    'description' => $comic->description,
                    'type' => $comic->type,
                    'quantity' => $comic->quantity,
                    'price' => $comic->price,
                    'publisher' => $comic->publisher,
                    'language' => $comic->language,
                    'ISBN' => $comic->ISBN,
                );
            }
            $comic_id = Comic::create($data1);

            if($request->has('Avventura')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Avventura')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }

            if($request->has('Alternativo')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Alternativo')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }
            if($request->has('Azione')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Azione')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }
            if($request->has('Disney')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Disney')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }
            if($request->has('Fantascienza')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Fantascienza')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }
            if($request->has('Fantasy')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Fantasy')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }
            if($request->has('Giallo')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Giallo')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }
            if($request->has('Horror')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Horror')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }
            if($request->has('PostApocalittico')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Post Apocalittico')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }
            if($request->has('Supereroi')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Supereroi')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }
            if($request->has('Thriller')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Thriller')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }
            if($request->has('Umoristico')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Umoristico')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }
            if($request->has('Western')){
                $genre_id = DB::table('genres')->where('name_genre', '=', 'Western')->first();
                $genreA = new Genre();
                $genreA->comic_id = $comic_id->id;
                $genreA->genre_id = $genre_id->id;
                $genreData = array(
                    'genre_id' => $genreA->genre_id,
                    'comic_id' => $genreA->comic_id,
                );
                DB::table('comic_genre')->insert($genreData);

            }

            ImageController::moveFileCover($request, $comic_id->id);

            ImageController::addImagesToComic($request, $comic_id->id);

            return redirect()->back();
        }
        else{
            return redirect('/login');
        }
    }

    public static function modifyComic ($id, Request $request){

        if(Auth::user()) {
            $request->validate([
                'comic_name' => ['required'],
                'description' => ['required'],
                'ISBN' => ['required', 'digits: 10'],
                'publisher' => 'required',
                'author_name' => 'required',
                'language' => 'required',
                'type' => 'required',
                'price' => ['required', 'regex:/^[0-9]{1,2}([.][0-9]{1,2})?$/'],
                'quantity' => 'required',
                'cover' => 'image|mimes:jpeg|max:16384',
                'immagine1' => 'image|mimes:jpeg|max:16384',
                'immagine2' => 'image|mimes:jpeg|max:16384',
                'immagine3' => 'image|mimes:jpeg|max:16384',
                'immagine4' => 'image|mimes:jpeg|max:16384',
            ]);

            if ($request->height != null || $request->width != null || $request->length != null) {
                if ($request->height == null) {
                    return back()->with('error', 'error with dimension');
                }
                if ($request->width == null) {
                    return back()->with('error', 'error with dimension');
                }
                if ($request->length == null) {
                    return back()->with('error', 'error with dimension');
                }
            }
            if(DB::table('authors')->where('name_author', '=', $request->author_name)->count() == 1){
                $author = DB::table('authors')->where('name_author', '=', $request->author_name)->first();
            }
            else{
                $authorData = array('name_author' => $request->author_name);
                DB::table('authors')->insert($authorData);
                $author = DB::table('authors')->where('name_author', '=', $request->author_name)->first();
            }
            $price = floatval($request->price);

            $comic = new Comic;
            $comic->user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $comic->author_id = $author->id;
            $comic->comic_name = $request->comic_name;
            $comic->description = $request->description;
            $comic->type = $request->type;
            $comic->ISBN = $request->ISBN;
            $comic->quantity = $request->quantity;
            $comic->price = $price;
            $comic->language = $request->language;
            if($request->height != null){
                $comic->width = $request->width;
                $comic->length = $request->length;
                $comic->height = $request->height;
            }
            $comic->publisher = $request->publisher;

            if($request->height != null){
                $data1 = array(
                    'user_id' => $comic->user_id,
                    'author_id' => $comic->author_id,
                    'comic_name' => $comic->comic_name,
                    'description' => $comic->description,
                    'type' => $comic->type,
                    'quantity' => $comic->quantity,
                    'price' => $comic->price,
                    'publisher' => $comic->publisher,
                    'language' => $comic->language,
                    'ISBN' => $comic->ISBN,
                    'width' => $comic->width,
                    'length' => $comic->length,
                    'height' => $comic->height,
                );
            }
            else{
                $data1 = array(
                    'user_id' => $comic->user_id,
                    'author_id' => $comic->author_id,
                    'comic_name' => $comic->comic_name,
                    'description' => $comic->description,
                    'type' => $comic->type,
                    'quantity' => $comic->quantity,
                    'price' => $comic->price,
                    'publisher' => $comic->publisher,
                    'language' => $comic->language,
                    'ISBN' => $comic->ISBN,
                );
            }
            DB::table('comics')->where('id', '=', $id)->update($data1);

            if($request->has('Alternativo')) {
                if (!self::isgenreOfComic($id, 7)) {
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 7;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 7)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 7)->delete();
                }

            }

            if($request->has('Avventura')) {
                if (!self::isgenreOfComic($id, 1)) {
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 1;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 1)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 1)->delete();
                }
            }

            if($request->has('Fantascienza')) {
                if (!self::isgenreOfComic($id, 2)) {
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 2;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 2)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 2)->delete();
                }

            }

            if($request->has('Fantasy')) {
                if (!self::isgenreOfComic($id, 3)) {
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 3;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 3)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 3)->delete();
                }

            }

            if($request->has('Azione')) {
                if (!self::isgenreOfComic($id, 4)) {
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 4;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 4)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 4)->delete();
                }

            }

            if($request->has('Umoristico')){
                if(!self::isgenreOfComic($id, 5)){
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 5;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 5)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 5)->delete();
                }

            }

            if($request->has('Western')){
                if(!self::isgenreOfComic($id, 6)){
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 6;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 6)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 6)->delete();
                }

            }

            if($request->has('Supereroi')){
                if(!self::isgenreOfComic($id, 8)){
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 8;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 8)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 8)->delete();
                }

            }

            if($request->has('Horror')){
                if(!self::isgenreOfComic($id, 9)){
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 9;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 9)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 9)->delete();
                }

            }

            if($request->has('Thriller')){
                if(!self::isgenreOfComic($id, 10)){
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 10;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 10)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 10)->delete();
                }

            }

            if($request->has('Giallo')){
                if(!self::isgenreOfComic($id, 11)){
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 11;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 11)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 11)->delete();
                }

            }

            if($request->has('Disney')){
                if(!self::isgenreOfComic($id, 12)){
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 12;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 12)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 12)->delete();
                }

            }

            if($request->has('PostApocalittico')){
                if(!self::isgenreOfComic($id, 13)){
                    $genreC = new Genre();
                    $genreC->comic_id = $id;
                    $genreC->genre_id = 13;
                    $genreDataC = array(
                        'genre_id' => $genreC->genre_id,
                        'comic_id' => $genreC->comic_id,
                    );
                    DB::table('comic_genre')->insert($genreDataC);
                }
            }
            else{
                if(self::isgenreOfComic($id, 13)){
                    DB::table('comic_genre')->where('comic_id', '=', $id)->where('genre_id', '=', 13)->delete();
                }

            }

            if($request->has('cover')){
                DB::table('images')->where('comic_id', '=', $id)->where('cover', '=', 1)->delete();
                ImageController::moveFileCover($request, $id);
            }

            if($request->has('image1')){
                $delete1 = DB::table('images')->where('comic_id', '=', $id)->where('imageNumber', '=', 1)->count();
                if($delete1 != null){
                    DB::table('images')->where('comic_id', '=', $id)->where('imageNumber', '=', 1)->delete();
                }
            }
            if($request->has('image2')){
                $delete2 = DB::table('images')->where('comic_id', '=', $id)->where('imageNumber', '=', 2)->count();
                if($delete2 != null){
                    DB::table('images')->where('comic_id', '=', $id)->where('imageNumber', '=', 2)->delete();
                }
            }
            if($request->has('image3')){
                $delete3 = DB::table('images')->where('comic_id', '=', $id)->where('imageNumber', '=', 3)->count();
                if($delete3 != null){
                    DB::table('images')->where('comic_id', '=', $id)->where('imageNumber', '=', 3)->delete();
                }
            }
            if($request->has('image4')){
                $delete4 = DB::table('images')->where('comic_id', '=', $id)->where('imageNumber', '=', 4)->count();
                if($delete4 != null){
                    DB::table('images')->where('comic_id', '=', $id)->where('imageNumber', '=', 4)->delete();
                }
            }

            ImageController::addImagesToComic($request, $id);
            

            return redirect('/accountArea/menagementproducts');
        }
        else{
            return redirect('/login');
        }
    }
}
