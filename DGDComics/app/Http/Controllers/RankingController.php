<?php

namespace App\Http\Controllers;

use App\ShippingAddress;
use Illuminate\Http\Request;
use App\Ranking;
use App\Comic;
use App\User;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
     public static function vendorRanking($id) {
         $user = User::where('id','=',$id)->first();
         $count = Comic::where('user_id','=',$user->id)->count();
         $ranking = Ranking::where('user_id','=',$id)->first();
         $sede = DB::table('shipping_addresses')->where('user_id', '=', $id)->where('sede', '=', 1)->first();
         $comics = Comic::where('user_id','=',$id)->get();
         $reviews1 = DB::table('reviews')->join('comics', 'comics.id', '=', 'reviews.comic_id')->where('comics.user_id', '=', $user->id)->select('reviews.*')->paginate(3);
         $reviews2 = DB::table('reviews')->where('user_id', '=', $user->id)->paginate(3);
         return view('/vendorinfo')
             ->with(compact('user'))
             ->with(compact('sede'))
             ->with(compact('ranking'))
             ->with(compact('comics'))
             ->with(compact('count'))
             ->with(compact('reviews1'))
             ->with(compact('reviews2'));
     }
}
