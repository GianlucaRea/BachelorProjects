<?php

namespace App\Http\Controllers;

use App\PaymentMethod;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PaymentMethodController extends Controller
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
        $rules = [

            'user_id' => 'required',
            'payment_type' => 'required',
            'favourite' => 'required',
            'data_scadenza' => 'required',
            'cardNumber' => ['requred', 'min:16', 'max:16', 'Unique'],
            'intestatario' => ['required', 'unique'],
            'CVV' => ['requred', 'min:3', 'max:3', 'Unique'],

        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $paymentMethod = PaymentMethod::create($request->all());
        return response()->json($paymentMethod,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paymentMethod = PaymentMethod::find($id);
        if(is_null($paymentMethod)){
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
        $paymentMethod = PaymentMethod::find($id);
        if(is_null($paymentMethod)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $paymentMethod -> update($request -> all());
        return response()->json($paymentMethod,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::find($id);
        if(is_null($paymentMethod)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $paymentMethod -> delete();
        return response()->json(null,204);
    }


    public static function getPaymentMethodByUserId($id)
    {
        return PaymentMethod::where('user_id', '=', $id)->get();


    }

    public static function getTime(){
        return strtotime("now");
    }

    public function getPaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::find($id)->get();

        return response()->json($paymentMethod, 200);
    }

    public function remove($id){
        $paymentMethod = PaymentMethod::find($id);
        if(is_null($paymentMethod)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $user = \Illuminate\Support\Facades\Auth::user();
        if(DB::table('payment_methods')->where('user_id', '=', $user->id)->get()->count()>1){
            $paymentMethod -> delete();
            $newFavourite = array(
                'favourite' => 1
            );
            $payment_Methods = DB::table('payment_methods')->where('user_id', '=', $user->id)->get();
            foreach ($payment_Methods as $payment_Method) {
                $oggi = self::getTime();
                $scadenza = $payment_Method->data_scadenza;
                if(strtotime($scadenza) - $oggi > 0) {
                    DB::table('payment_methods')->where('user_id', '=', $user->id)->where('id', '=', $payment_Method->id)->update($newFavourite);
                    return redirect('/accountArea/paymentmethods')
                        ->with(compact('user'));
                }
            }
            return redirect('/accountArea/paymentmethods')
                ->with(compact('user'));
        }
        else{
            $paymentMethod -> delete();
            return redirect('/accountArea/paymentmethods')
                ->with(compact('user'));
        }
    }

    public function add(Request $request){
        if(Auth::user()) {
            $request->validate([
                'payment_type' => 'required',
                'month' => ['required', 'int', 'min:1', 'max:12'],
                'year' => ['required', 'int', 'min:2000', 'max:2100'],
                'cardNumber' => ['required', 'unique:payment_methods', 'regex:/^[0-9]{16}$/'],
                'intestatario' => ['required', 'regex:/^[a-z ,.-]+$/i'],
                'CVV' => ['required', 'unique:payment_methods', 'regex:/^[0-9]{3}$/'],
            ]);
            $user = \Illuminate\Support\Facades\Auth::user();
            $data_scadenza = Carbon::create($request->year, $request->month, '28', '0', '0', '0');
            if(DB::table('payment_methods')->where('user_id', '=', $user->id)->where('favourite', '=', 1)->get()->count() == 0) {
                $oggi = self::getTime();
                $paymentMethod = new PaymentMethod; //per evitare problemi con campi che non appartengono effettivamente a paymentMethod.
                $paymentMethod->user_id = \Illuminate\Support\Facades\Auth::user()->id;
                $paymentMethod->payment_type = $request->payment_type;
                $paymentMethod->data_scadenza = $data_scadenza;
                if(strtotime($paymentMethod->data_scadenza) - $oggi > 0){
                    $paymentMethod->favourite = 1;
                }
                else{
                    $paymentMethod->favourite = 0;
                }
                $paymentMethod->cardNumber = $request->cardNumber;
                $paymentMethod->intestatario = $request->intestatario;
                $paymentMethod->CVV = $request->CVV;

                $data = array(
                    'user_id' => $paymentMethod->user_id,
                    'payment_type' => $paymentMethod->payment_type,
                    'favourite' => $paymentMethod->favourite,
                    'data_scadenza' => $paymentMethod->data_scadenza,
                    'cardNumber' => $paymentMethod->cardNumber,
                    'intestatario' => $paymentMethod->intestatario,
                    'CVV' => Hash::make($paymentMethod->CVV),
                );

                DB::table('payment_methods')->insert($data);


                return redirect('/accountArea/paymentmethods')
                    ->with(compact('user'));
            }
            else{
                $paymentMethod = new PaymentMethod; //per evitare problemi con campi che non appartengono effettivamente a paymentMethod.
                $paymentMethod->user_id = \Illuminate\Support\Facades\Auth::user()->id;
                $paymentMethod->payment_type = $request->payment_type;
                $paymentMethod->favourite = 0;
                $paymentMethod->data_scadenza = $data_scadenza;
                $paymentMethod->cardNumber = $request->cardNumber;
                $paymentMethod->intestatario = $request->intestatario;
                $paymentMethod->CVV = $request->CVV;

                $data = array(
                    'user_id' => $paymentMethod->user_id,
                    'payment_type' => $paymentMethod->payment_type,
                    'favourite' => $paymentMethod->favourite,
                    'data_scadenza' => $paymentMethod->data_scadenza,
                    'cardNumber' => $paymentMethod->cardNumber,
                    'intestatario' => $paymentMethod->intestatario,
                    'CVV' => Hash::make($paymentMethod->CVV),
                );

                DB::table('payment_methods')->insert($data);


                return redirect('/accountArea/paymentmethods')
                    ->with(compact('user'));
            }
        }
        else{
            return redirect('/login');
        }
    }

    public static function getPaymentMethodByOrderId($id){
        return DB::table("payment_methods")->where("id", "=", $id)->first();
    }

    public static function checkIfNotScaduta($id){
        if(Auth::user()){
            $user = Auth::user();
            $oggi = self::getTime();
            $scadenza = DB::table('payment_methods')->where('id', '=', $id)->where('user_id', '=', $user->id)->first()->data_scadenza;
            if(strtotime($scadenza) - $oggi < 0){
                if(DB::table('payment_methods')->where('id', '=', $id)->where('user_id', '=', $user->id)->where('favourite', '=', 1)->first() != null) {
                    $oldFavourite = array(
                        'favourite' => 0
                    );
                    DB::table('payment_methods')->where('id', '=', $id)->where('user_id', '=', $user->id)->where('favourite', '=', 1)->update($oldFavourite);
                }
            }
        }
        else{
            return redirect('/login');
        }
    }

    public static function predefinite($id){
        if (Auth::user()){
            $user = Auth::user();
            $oggi = self::getTime();
            $scadenza = DB::table('payment_methods')->where('id', '=', $id)->where('user_id', '=', $user->id)->first()->data_scadenza;
            if( strtotime($scadenza) - $oggi < 0){
                return redirect()->back()->with('ERRORE', 'si sta provando a settare come predefinita una carta scaduta');
            }
            if(DB::table('payment_methods')->where('user_id', '=', $user->id)->where('favourite', '=', 1)->first() == null){
                $data = array(
                    'favourite' => 1
                );
                DB::table('payment_methods')->where('id', '=', $id)->where('user_id', '=', $user->id)->update($data);
            }
            else {
                $oldFavourite = array(
                    'favourite' => 0
                );
                DB::table('payment_methods')->where('user_id', '=', $user->id)->where('favourite', '=', 1)->update($oldFavourite);
                $newFavourite = array(
                    'favourite' => 1
                );
                DB::table('payment_methods')->where('id', '=', $id)->where('user_id', '=', $user->id)->update($newFavourite);
            }
            return redirect()->back();
        }
        else{
            redirect('/login');
        }
    }

}