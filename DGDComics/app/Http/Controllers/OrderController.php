<?php

namespace App\Http\Controllers;

use App\ComicBought;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Order::get(),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($values)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, array $comic_bought_id)
    {
        $rules = [
            'user_id' => 'required',
            'payment_method_id' => 'required',
            'shipping_address_id' => 'required',
            'total' => 'required',
            'state' => 'required',
            'date' => 'required'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $order = Order::create($request->all());
        $comic_bought = ComicBought::find($comic_bought_id);
        $order->comic_bought()->attach($comic_bought);
        return response()->json($order,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        if(is_null($order)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(Order::find($id),200);
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
        $order = Order::find($id);
        if(is_null($order)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $order -> update($request -> all());
        return response()->json($order,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if(is_null($order)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $order-> delete();
        return response()->json(null,204);
    }

    public function submitOrder(Request $request){
        if($request != null && $request->total > 0 && $request->paymentMethod != null && $request->shippingAddress != null) {
            $order = new Order();
            $user = \Illuminate\Support\Facades\Auth::user();
            $order->user_id = $user->id;
            $order->payment_method_id = $request->paymentMethod;
            $order->shipping_adress_id = $request->shippingAddress;
            $order->total = $request->total;

            $data1 = array(
                'user_id' => $order->user_id,
                'payment_method_id' => $order->payment_method_id,
                'shipping_address_id' => $order->shipping_adress_id,
                'total' => $order->total,
            );

            $sellers = collect();

            $order_id = Order::create($data1);

            foreach (session('cart') as $id => $details) {
                if ($details["user"] == $user->id) {
                    $comic = ComicController::getByID($details["comic_id"]);
                    $vendor = ComicController::getSeller($details["comic_id"]);

                    $comicBought = new ComicBought();
                    $comicBought->name = $comic->comic_name;
                    $comicBought->vendor = $vendor->username;
                    $comicBought->comic_id = $details["comic_id"];
                    $comicBought->quantity = $details['quantity'];
                    $comicBought->price = $details['price'];
                    $comicBought->state = "ordinato";


                    $data2 = array(
                        'comic_id' => $comicBought->comic_id,
                        'name' => $comicBought->name,
                        'vendor' => $comicBought->vendor,
                        'quantity' => $comicBought->quantity,
                        'price' => $comicBought->price,
                        'state' => $comicBought->state
                    );

                    $comic_Bought_id = ComicBought::create($data2);

                    if ($sellers->isEmpty()) {
                        $sellers->push(ComicController::getSeller($comic_Bought_id->comic_id)->id);
                    } else if (!($sellers->contains(ComicController::getSeller($comic_Bought_id->comic_id)->id))) {
                        $sellers->push(ComicController::getSeller($comic_Bought_id->comic_id)->id);
                    }

                    $data3 = array(
                        'comic_bought_id' => $comic_Bought_id->id,
                        'order_id' => $order_id->id,
                    );
                    DB::table('comic_bought_order')->insert($data3);


                    if (WishlistController::alreadyToList($details["comic_id"], $user->id)) {
                        WishlistController::removeToList($details["comic_id"]);
                    }
                }
            }

            foreach ($sellers->all() as $idOfSeller) {

                $data4 = array(
                    'user_id' => $idOfSeller,
                    'notification_text' => 'un utente ha effettuato un ordine!',
                    'state' => '0',
                    'notification' => 'orderDetailVendor',
                    'idLink' => $order_id->id,
                );

                DB::table('notifications')->insert($data4);
            }



        ComicController::removeAllForOrder(); //svuotamento carrello

            return redirect('/orderSuccess');
        }
        return redirect('/orderFailure');
    }

    public static function getAllOrderByUser($id){
        return DB::table('orders')->where('user_id', '=', $id)->get();
    }

    public static function orderDetail($id){
        $order = DB::table('orders')->where('id', '=', $id)->get();
        return view('orderDetail')
            ->with(compact('order'));
    }

    public static function orderDetailVendor($id){
        $order = DB::table('orders')->where('id', '=', $id)->get();
        return view('orderDetailVendor')
            ->with(compact('order'));
    }

    public static function getAllOrdersOfVendor($id){
        return DB::table('orders')->join('comic_bought_order', 'orders.id', '=', 'comic_bought_order.order_id')->join('comic_boughts', 'comic_bought_order.comic_bought_id', '=', 'comic_boughts.id')->join('comics', 'comic_boughts.comic_id', '=', 'comics.id')->where('comics.user_id', '=', $id)->paginate(6);
    }

    public static function getAllOrdersOfVendor2($id){
        return DB::table('orders')->join('comic_bought_order', 'orders.id', '=', 'comic_bought_order.order_id')->join('comic_boughts', 'comic_bought_order.comic_bought_id', '=', 'comic_boughts.id')->join('comics', 'comic_boughts.comic_id', '=', 'comics.id')->where('comics.user_id', '=', $id)->select(['comic_bought_order.order_id', 'orders.date'])->groupBy('comic_bought_order.order_id', 'orders.date')->orderBy('date', 'desc')->paginate(6);
    }

    public function orderSearchUser(Request $request){
        $search = $request->input('search');
        $id = Auth::user()->id;
        $orders = DB::table('orders')
            ->join('comic_bought_order', 'orders.id', '=', 'comic_bought_order.order_id')
            ->join('comic_boughts', 'comic_bought_order.comic_bought_id', '=', 'comic_boughts.id')
            ->join('comics', 'comic_boughts.comic_id', '=', 'comics.id')
            ->join('shipping_addresses', 'orders.shipping_address_id', '=', 'shipping_addresses.id')
            ->join('users', 'comics.user_id', '=', 'users.id')
            ->where(function($likes) use ($search){
            $likes->where('comics.comic_name', '=', '%'.$search.'%')
                ->orWhere('users.username','LIKE','%'.$search.'%')->orWhere('shipping_addresses.via','LIKE','%'.$search.'%')
                ->orWhere('shipping_addresses.città','LIKE','%'.$search.'%')
                ->orWhere('shipping_addresses.post_code','LIKE','%'.$search.'%');
            })
            ->where('orders.user_id', '=', $id)
            ->select(['comic_bought_order.order_id', 'orders.date', 'orders.total'])
            ->groupBy('comic_bought_order.order_id', 'orders.date', 'orders.total')
            ->orderBy('date', 'desc')
            ->paginate(6);
        return UserController::dashboardOrder($orders);
    }

    public function orderVendorSearchUser(Request $request){
        $search = $request->input('search');
        $id = Auth::user()->id;
        $orders_of_vendor = DB::table('orders')
            ->join('comic_bought_order', 'orders.id', '=', 'comic_bought_order.order_id')
            ->join('comic_boughts', 'comic_bought_order.comic_bought_id', '=', 'comic_boughts.id')
            ->join('comics', 'comic_boughts.comic_id', '=', 'comics.id')
            ->join('shipping_addresses', 'orders.shipping_address_id', '=', 'shipping_addresses.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where(function($likes) use ($search){
                $likes->where('comics.comic_name','LIKE','%'.$search.'%')
                    ->orWhere('users.username','LIKE','%'.$search.'%')
                    ->orWhere('shipping_addresses.via','LIKE','%'.$search.'%')
                    ->orWhere('shipping_addresses.città','LIKE','%'.$search.'%')
                    ->orWhere('shipping_addresses.post_code','LIKE','%'.$search.'%');
                    })
            ->where('comics.user_id', '=', $id)
            ->select(['comic_bought_order.order_id', 'orders.date'])
            ->groupBy('comic_bought_order.order_id', 'orders.date')
            ->orderBy('date', 'desc')
            ->paginate(6);
        return UserController::dashboardOrderVendor($orders_of_vendor);
    }

}
