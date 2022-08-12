<?php

namespace App\Http\Controllers;

use App\User;
use App\Comic;
use App\Review;
use App\Order;
use App\Notification;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Wishlist;
use App\PaymentMethod;
use App\ShippingAddress;
use Ramsey\Uuid\Type\Time;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::get(), 200);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [

            'name' => 'required',
            'surname' => 'required',
            'username' => 'required',
            'age' => 'required',
            'partitaIva' => 'nullable',
            'phone_number' => 'required',
            'email' => 'required',
            'email_verified_at' => 'required',
            'password' => 'required',
            'attivita' => 'nullable',


        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $User = User::create($request->all());
        return response()->json($User, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $User = User::find($id);
        if (is_null($User)) {
            return response()->json(["message" => 'Record not found'], 404);
        }
        return response()->json(Author::find($id), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $User = User::find($id);
        if (is_null($User)) {
            return response()->json(["message" => 'Record not found'], 404);
        }
        $User->update($request->all());
        return response()->json($User, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $User = User::find($id);
        if (is_null($User)) {
            return redirect()->route("AdminAccount")->with('message', 'Alredy Deleted');
        }
        if($User->hasGroup('il gruppo degli admin')){
            return redirect()->route("AdminAccount")->with('message', 'Can not delete an admin');
        }
        $User->delete();
        return back();
    }

    public function usersSearchAdmin(Request $request){ //metodo fatto per gli admin nel metodo di ricerca di utenti
        $search = $request->input('search');
        $users = DB::table('users')->join('group_user', 'users.id', '=', 'group_user.user_id')->join('groups', 'group_user.group_id', '=', 'groups.id')->where('username','LIKE','%'.$search.'%')->orWhere('partitaIva','LIKE','%'.$search.'%')->orWhere('groups.group_description','LIKE','%'.$search.'%')->select('users.*')->paginate(12);
        return AdminController::dashboardUser($users);
    }

    public static function updateDate()
    {
        if(Auth::user()) {
            $user = Auth::user();
            $newDate = array(
                'date' => DB::raw('now()')
            );
            DB::table('users')->where('id', '=', $user->id)->update($newDate);
            $isAdmin = \App\Http\Controllers\GroupController::isAdmin($user->id);
            if($isAdmin){
                return redirect('/adminArea/dashboard');
            }
            else{
                return redirect('/accountArea');
            }

        }
        else{
            redirect('/login');
        }
    }

    public static function isNotRemembered()
    {
        if(Auth::user()) {
            $user = DB::table('users')->where('id', '=', Auth::user()->id)->whereRaw('date >= now() - interval 1 minute')->first();
            if($user == null){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public static function tokenNotSetted(){
        if(Auth::user()) {
            $user = DB::table('users')->where('id', '=', Auth::user()->id)->first();
            if ($user->remember_token == null) {
                return true;
            } else {
                return false;
            }
        }
        else{
            return false;
        }
    }

    public static function getUserId($id)
    {
        return User::where('id', '=', $id)->first();
    }

    public static function addPartitaIva(Request $request)
    {

        $request->validate([
            'partitaIva' => ['required', 'digits:11'],
            'attivita' => 'required',
        ]);

        User::find(auth()->user()->id)->update(['partitaIva' => ($request->partitaIva)]);
        User::find(auth()->user()->id)->update(['attivita' => ($request->attivita)]);


    }

    public static function dashboard()
    {
        if(Auth::user()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $notifications = Notification::where('user_id', '=', $user->id)->orderBy('date', 'desc')->paginate(6);
            $orders = Order::where('user_id', '=', $user->id)->orderBy('date', 'desc')->paginate(6);
            $list = Wishlist::where('user_id', '=', $user->id)->paginate(6);
            $paymentMethods = PaymentMethod::where('user_id', '=', $user->id)->paginate(6);
            $shippingAddresses = ShippingAddress::where('user_id', '=', $user->id)->paginate(6);
            $orders_of_vendor = OrderController::getAllOrdersOfVendor2($user->id);
            $comics_of_vendor = Comic::where('user_id', '=', $user->id)->paginate(6);

            return view('accountArea')
                ->with(compact('user'))
                ->with(compact('notifications'))
                ->with(compact('orders'))
                ->with(compact('list'))
                ->with(compact('paymentMethods'))
                ->with(compact('shippingAddresses'))
                ->with(compact('orders_of_vendor'))
                ->with(compact('comics_of_vendor'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public static function dashboardOrder($orders)
    {
        if(Auth::user()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $notifications = Notification::where('user_id', '=', $user->id)->orderBy('date', 'desc')->paginate(6);
            $list = Wishlist::where('user_id', '=', $user->id)->paginate(6);
            $paymentMethods = PaymentMethod::where('user_id', '=', $user->id)->paginate(6);
            $shippingAddresses = ShippingAddress::where('user_id', '=', $user->id)->paginate(6);
            $orders_of_vendor = DB::table('orders')->join('comic_bought_order', 'orders.id', '=', 'comic_bought_order.order_id')->join('comic_boughts', 'comic_bought_order.comic_bought_id', '=', 'comic_boughts.id')->join('comics', 'comic_boughts.comic_id', '=', 'comics.id')->where('comics.user_id', '=', $user->id)->paginate(6);
            $comics_of_vendor = Comic::where('user_id', '=', $user->id)->paginate(6);

            return view('accountAreaOrders')
                ->with(compact('user'))
                ->with(compact('notifications'))
                ->with(compact('orders'))
                ->with(compact('list'))
                ->with(compact('paymentMethods'))
                ->with(compact('shippingAddresses'))
                ->with(compact('orders_of_vendor'))
                ->with(compact('comics_of_vendor'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public static function dashboardList($list)
    {
        if(Auth::user()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $notifications = Notification::where('user_id', '=', $user->id)->orderBy('date', 'desc')->paginate(6);
            $orders = Order::where('user_id', '=', $user->id)->paginate(6);
            $paymentMethods = PaymentMethod::where('user_id', '=', $user->id)->paginate(6);
            $shippingAddresses = ShippingAddress::where('user_id', '=', $user->id)->paginate(6);
            $orders_of_vendor = DB::table('orders')->join('comic_bought_order', 'orders.id', '=', 'comic_bought_order.order_id')->join('comic_boughts', 'comic_bought_order.comic_bought_id', '=', 'comic_boughts.id')->join('comics', 'comic_boughts.comic_id', '=', 'comics.id')->where('comics.user_id', '=', $user->id)->paginate(6);
            $comics_of_vendor = Comic::where('user_id', '=', $user->id)->paginate(6);

            return view('accountAreaList')
                ->with(compact('user'))
                ->with(compact('notifications'))
                ->with(compact('orders'))
                ->with(compact('list'))
                ->with(compact('paymentMethods'))
                ->with(compact('shippingAddresses'))
                ->with(compact('orders_of_vendor'))
                ->with(compact('comics_of_vendor'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public static function dashboardOrderVendor($orders_of_vendor)
    {
        if(Auth::user()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $notifications = Notification::where('user_id', '=', $user->id)->orderBy('date', 'desc')->paginate(6);
            $orders = Order::where('user_id', '=', $user->id)->paginate(6);
            $list = Wishlist::where('user_id', '=', $user->id)->paginate(6);
            $paymentMethods = PaymentMethod::where('user_id', '=', $user->id)->paginate(6);
            $shippingAddresses = ShippingAddress::where('user_id', '=', $user->id)->paginate(6);
            $comics_of_vendor = Comic::where('user_id', '=', $user->id)->paginate(6);

            return view('accountAreaOrderVendor')
                ->with(compact('user'))
                ->with(compact('notifications'))
                ->with(compact('orders'))
                ->with(compact('list'))
                ->with(compact('paymentMethods'))
                ->with(compact('shippingAddresses'))
                ->with(compact('orders_of_vendor'))
                ->with(compact('comics_of_vendor'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public static function dashboardComicVendor($comics_of_vendor)
    {
        if(Auth::user()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            $notifications = Notification::where('user_id', '=', $user->id)->orderBy('date', 'desc')->paginate(6);
            $orders = Order::where('user_id', '=', $user->id)->paginate(6);
            $list = Wishlist::where('user_id', '=', $user->id)->paginate(6);
            $paymentMethods = PaymentMethod::where('user_id', '=', $user->id)->paginate(6);
            $shippingAddresses = ShippingAddress::where('user_id', '=', $user->id)->paginate(6);
            $orders_of_vendor = DB::table('orders')->join('comic_bought_order', 'orders.id', '=', 'comic_bought_order.order_id')->join('comic_boughts', 'comic_bought_order.comic_bought_id', '=', 'comic_boughts.id')->join('comics', 'comic_boughts.comic_id', '=', 'comics.id')->where('comics.user_id', '=', $user->id)->paginate(6);


            return view('accountAreaComicVendor')
                ->with(compact('user'))
                ->with(compact('notifications'))
                ->with(compact('orders'))
                ->with(compact('list'))
                ->with(compact('paymentMethods'))
                ->with(compact('shippingAddresses'))
                ->with(compact('orders_of_vendor'))
                ->with(compact('comics_of_vendor'));
        }
        else
        {
            return redirect('/login');
        }
    }

    public static function getLogout(){
        $user=Auth::user();
        $data = array(
            'remember_token' => null
        );
        Auth::logout();
        DB::table('users')->where('id', '=', $user->id)->update($data);
        return redirect('/');
    }

    public static function userInfo($id) {
        $user = User::where('id','=',$id)->first();
        $reviews =  DB::table('reviews')->where('user_id', '=', $id)->paginate(3);
        return view('/userInfo')
            ->with(compact('user'))
            ->with(compact('reviews'));
    }


}