<?php

namespace App\Http\Controllers;

use App\Article;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public static function countArticle($id){
        return $number = Tag::find($id)->article()->count();
    }


}
