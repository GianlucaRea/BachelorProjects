<?php

namespace App\Http\Controllers;

use App\Comic;
use App\Notification;
use App\PaymentMethod;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function add(Request $request,$id)
    {
        if(Auth::user()) {
            $isNotPassed = false;
            $data = array(
              'review_title' => $request->review_title,
              'review_text' => $request->review_text,
              'stars' => $request->stars,
            );
            $now = Carbon::now();
            $validator = Validator::make($data, [
                'review_title' => ['required', 'string', 'max:50',],
                'review_text' => ['required', 'min:10'],
                'stars' => ['required'],
            ]);

            if($validator->fails()){
                return redirect('comic_detail_review_error/'.$id);
            }
            $user = \Illuminate\Support\Facades\Auth::user();
            $review = new Review;
            $review->user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $review->comic_id = $id;
            $review->review_title = $request->review_title;
            $review->review_text = $request->review_text;
            $review->stars = $request->stars;

            $data = array(
                'user_id' => $review->user_id,
                'comic_id' => $id,
                'review_title' => $review->review_title,
                'review_text' => $review->review_text,
                'stars' => $review->stars,
            );

            DB::table('reviews')->insert($data);

            return redirect('comic_detail/'.$id)->with(compact('isNotPassed'));
        }
        else{
            return redirect('/login');
        }
    }


    public function destroy($id)
    {
        $Review = Review::find($id);
        $notification = new Notification;
        $notification->user_id = $Review->user_id;
        $notification->state = false;
        $notification->notification_text = 'La sua Recensione non era in accordo con le policy di DGDComics';

        $data = array(
            'user_id' => $notification->user_id,
            'state' =>  $notification->state,
            'notification_text' => $notification->notification_text,
            'notification' => 'comicdetail',
            'idLink' => $comic_id
        );

        if(is_null($Review)){
            return redirect()->route("AdminAccount")->with('message','Alredy Deleted');
        }
        $Review -> delete();
        DB::table('notifications')->insert($data);
        return redirect()->route("AdminAccount")->with('message','Success');
    }
    public function destroylocal($id)
    {

        $Review = Review::find($id);
        $comic_id = Review::find($id)->comic_id;
        $comic = Comic::where('id','=', $comic_id)->get();
        $notification = new Notification;
        $notification->user_id = $Review->user_id;
        $notification->state = false;
        $notification->notification_text = 'La sua Recensione non era in accordo con le policy di DGDComics';

        $data = array(
            'user_id' => $notification->user_id,
            'state' =>  $notification->state,
            'notification_text' => $notification->notification_text,
            'notification' => 'comicdetail',
            'idLink' => $comic_id
        );

        if(is_null($Review)){
            return redirect()->back()->with('message','Alredy Deleted');
        }
        $Review -> delete();
        DB::table('notifications')->insert($data);

        return redirect()->back()->with('message','Success');
    }

    public static function getReviewQuantity($id){
        $quantity = 0;
        $reviews = DB::table('reviews')->get();
        foreach ($reviews as $review){
            if($review->comic_id == $id){
                $quantity++;
            }
        }
        return $quantity;
    }

    public static function getReview($review_id){
        $review = Review::find($review_id);
        return view('editreview')->with(compact('review')) ;
    }

    public static function updateReview(Request $request, $review_id)
    {
        $review = Review::find($review_id);
        $request->validate([
            'review_title' => ['string', 'max:50', 'min:3'],
            'review_text' => ['string', 'min:10'],
            'stars'=> 'integer|min:1|max:5'
        ]);


            $review->review_title = $request->get('review_title');
            $review->review_text = $request->get('review_text');
            if($request->has('stars')) {
                $review->stars = $request->get('stars');
            }
            else{
                $review->stars = DB::table('reviews')->where('id', '=', $review_id)->first()->stars;
            }

        $data=array(
            'review_title' => $review->review_title,
            'review_text' => $review->review_text,
            'stars' => $review->stars
        );

        DB::table('reviews')->where('id', '=', $review_id)->update($data);
        $idOfComic = DB::table('reviews')->where('id', '=', $review_id)->first()->comic_id;
        return redirect('comic_detail/'.$idOfComic);
    }

    public static function CheckAuthor($review_id,$user_id){
        $review = Review::find($review_id);
        $user = User::find($user_id);

        if($user->id == $review->user_id)
            return true;
        else
            return false;
    }

    public function reviewsSearchAdmin(Request $request){
        $search = $request->input('search');
        $reviews = DB::table('reviews')->join('users', 'reviews.user_id', '=', 'users.id')->join('comics', 'reviews.comic_id', '=', 'comics.id')->where('reviews.review_title','LIKE','%'.$search.'%')->orWhere('reviews.review_text','LIKE','%'.$search.'%')->orWhere('users.username','LIKE','%'.$search.'%')->orWhere('comics.comic_name','LIKE','%'.$search.'%')->select('reviews.*')->paginate(12);
        return AdminController::dashboardReviews($reviews);
    }

    public static function isComicBought($comic_id, $seller_id){
        if(Auth::user()) {
            $user_id = Auth::user()->id;
            if (DB::table('orders')->join('comic_bought_order', 'orders.id', '=', 'comic_bought_order.order_id')->join('comic_boughts', 'comic_bought_order.comic_bought_id', '=', 'comic_boughts.id')->join('comics', 'comic_boughts.comic_id', '=', 'comics.id')->where('comics.id', '=', $comic_id)->where('orders.user_id', '=', $user_id)->where('comics.user_id', '=', $seller_id)->where('comic_boughts.state', '=', 'spedito')->count() > 0) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public static function isAlreadyWrited($comic_id){
        if(Auth::user()) {
            $user_id = Auth::user()->id;
            if(DB::table('reviews')->where('comic_id', '=', $comic_id)->where('user_id', '=', $user_id)->count() > 0){
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public static function getAllRecievedReview($user_id){
        return DB::table('reviews')->join('comics', 'comics.id', '=', 'reviews.comic_id')->where('comics.user_id', '=', $user_id)->select('reviews.*')->paginate(5);
    }

    public static function getAllWritedReview($user_id){
        return DB::table('reviews')->where('user_id', '=', $user_id)->paginate(5);
    }

}
