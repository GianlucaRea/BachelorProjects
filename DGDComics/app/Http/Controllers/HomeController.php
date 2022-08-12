<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comic;
use App\Http\Controllers\ComicController;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $comics = DB::table('comics')->where('quantity', '>', 0)->get();
        $newComics = \App\Http\Controllers\ComicController::getNewComic();
        $manga = \App\Http\Controllers\ComicController::getManga();
        $america = \App\Http\Controllers\ComicController::getAmerican();
        $italian= \App\Http\Controllers\ComicController::getItalian();
        $onePiece= DB::table('comics')->where('comic_name', 'LIKE', '%One Piece%')->orWhere('author_id', '=', 2)->get();
        $twd= DB::table('comics')->where('comic_name', 'LIKE', '%TWD%')->orWhere('author_id', '=', 7)->get();
        $topolino= DB::table('comics')->where('comic_name', 'LIKE', '%Topolino%')->orWhere('author_id', '=', 4)->get();
        $articles =  DB::table("articles")->take(6)->get();
        return view('welcome')
            ->with(compact('comics'))
            ->with(compact('newComics'))
            ->with(compact('manga'))
            ->with(compact('america'))
            ->with(compact('italian'))
            ->with(compact('onePiece'))
            ->with(compact('twd'))
            ->with(compact('topolino'))
            ->with(compact('articles'));
    }

    public static function onwork(){
            return view('onwork');
}
}
