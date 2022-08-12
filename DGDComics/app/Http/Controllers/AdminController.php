<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use App\Comic;
use App\User;
use App\Review;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
public static function dashboard() {
    if(Auth::user()) {
        $user = Auth::user();
        $users = User::orderBy('username', 'asc')->paginate(12);
        $comics = Comic::orderBy('comic_name', 'asc')->paginate(12);
        $reviews = Review::orderBy('review_title', 'asc')->paginate(12);
        $articles = Article::orderBy('created_at', 'asc')->paginate(12);
        return view('adminPanel')
            ->with(compact('user'))
            ->with(compact('users'))
            ->with(compact('comics'))
            ->with(compact('reviews'))
            ->with(compact('articles'));
    }
    else return redirect('/login');
}

    public static function dashboardArticle( $articles ) {
        if(Auth::user()) {
            $user = Auth::user();
            $users = User::orderBy('username', 'asc')->paginate(12);
            $comics = Comic::orderBy('comic_name', 'asc')->paginate(12);
            $reviews = Review::orderBy('review_title', 'asc')->paginate(12);
            return view('adminPanelArticleSearch')
                ->with(compact('user'))
                ->with(compact('users'))
                ->with(compact('comics'))
                ->with(compact('reviews'))
                ->with(compact('articles'));
        }
        else return redirect('/login');
    }

    public static function dashboardReviews( $reviews ) {
        if(Auth::user()) {
            $user = Auth::user();
            $users = User::orderBy('username', 'asc')->paginate(12);
            $comics = Comic::orderBy('comic_name', 'asc')->paginate(12);
            $articles = Article::orderBy('created_at', 'asc')->paginate(12);
            return view('adminPanelReviewsSearch')
                ->with(compact('user'))
                ->with(compact('users'))
                ->with(compact('comics'))
                ->with(compact('reviews'))
                ->with(compact('articles'));
        }
        else return redirect('/login');
    }

    public static function dashboardComics( $comics ) {
        if(Auth::user()) {
            $user = Auth::user();
            $users = User::orderBy('username', 'asc')->paginate(12);
            $reviews = Review::orderBy('review_title', 'asc')->paginate(12);
            $articles = Article::orderBy('created_at', 'asc')->paginate(12);
            return view('adminPanelComicsSearch')
                ->with(compact('user'))
                ->with(compact('users'))
                ->with(compact('comics'))
                ->with(compact('reviews'))
                ->with(compact('articles'));
        }
        else return redirect('/login');
    }

    public static function dashboardUser( $users ) {
        if(Auth::user()) {
            $user = Auth::user();
            $reviews = Review::orderBy('review_title', 'asc')->paginate(12);
            $comics = Comic::orderBy('comic_name', 'asc')->paginate(12);
            $articles = Article::orderBy('created_at', 'asc')->paginate(12);
            return view('adminPanelUsersSearch')
                ->with(compact('user'))
                ->with(compact('users'))
                ->with(compact('comics'))
                ->with(compact('reviews'))
                ->with(compact('articles'));
        }
        else return redirect('/login');
    }



public static function checkForWriteArticle(){
    if (Auth::user()) {
        $user = Auth::user();
        if (GroupController::isAdmin($user->id)) {
            return view("articleForm");
        } else {
            return view("errorCase");
        }
    }
    else return redirect('/login');
}

}
