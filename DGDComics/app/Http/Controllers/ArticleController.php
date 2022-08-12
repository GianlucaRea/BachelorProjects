<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Article::get(),200);
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
        $validator = Validator::make($request->all());
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $article = Article::create($request->all());
        return response()->json($article,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        if(is_null($article)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(Article::find($id),200);
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
        $article = Article::find($id);
        if(is_null($article)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $article -> update($request -> all());
        return response()->json($article,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        if(is_null($article)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $article-> delete();
        return response()->json(null,204);
    }

    public static function getArticles(){
        $articles = DB::table("articles")->latest()->paginate(4) ;
        $tags = Tag::all();
        return view('blogHome')->with(compact('articles'))->with(compact('tags'));
    }

    public function getArticleByTag($tag_name,Request $request){
        $articles = TAG::where('tag_name','=',$tag_name)->first()->article()->paginate(4);
        $tags = Tag::all();
        return view('blogHome')->with(compact('articles'))->with(compact('tags'));
    }

    public function articleSearch(Request $request){
        $tags = Tag::all();
        $search = $request->input('search');
        $articles = Article::where('title','LIKE','%'.$search.'%')->orWhere('article_text','LIKE','%'.$search.'%')->paginate(4);
        return view('blogHome')->with(compact('articles'))->with(compact('tags'));
    }

    public function articleSearchAdmin(Request $request){
        $search = $request->input('search');
        $articles = Article::where('title','LIKE','%'.$search.'%')->orWhere('article_text','LIKE','%'.$search.'%')->paginate(12);
        return AdminController::dashboardArticle($articles);
    }



    public static function getArticleById($id){
        $article = Article::where("id", "=", $id)->first();
        return view('blogArticleDetail')->with(compact('article'));
    }

    public static function addArticle($id, Request $request){
        $request->validate([
            'title' => ['required', 'string', 'max:127'],
            'article_text' => ['required', 'string'],
            'articleImage' => 'required|image|mimes:jpeg|max:16384',
        ]);

        if(GroupController::isAdmin($id)){
            $article = new Article();
            $article->user_id = $id;
            $article->title = $request->title;
            $article->article_text = $request->article_text;


            $data=array(
                'user_id'=> $id,
                'title' => $article->title,
                'article_text' => $article->article_text,
            );

            $article_id = Article::create($data);

            if($request->has('Animation')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Animation')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Comiccon')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Comiccon')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Cosplay')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Cosplay')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('DC')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'DC')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Design')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Design')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Digital_Art')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Digital Art')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Fan_Art')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Fan Art')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Humor')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Humor')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Illustrazioni')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Illustrazioni')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Italiano')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Italiano')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Manga')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Manga')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Marvel')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Marvel')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Novità')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Novità')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            if($request->has('Original_Character')){
                $tag_id = DB::table('tags')->where('tag_name', '=', 'Original Character')->first();
                $tagA = new Tag();
                $tagA->article_id = $article_id->id;
                $tagA->tag_id = $tag_id->id;
                $tagData = array(
                    'tag_id' => $tagA->tag_id,
                    'article_id' => $tagA->article_id,
                );
                DB::table('article_tag')->insert($tagData);

            }

            ArticleImageController::moveFileCover($request, $article_id->id);

            return redirect('/blog');
        }
        else{
            return view("errorCase");
        }
    }

    public static function destroyArticleLocal($id){
        DB::table('articles')->where('id', '=', $id)->delete();

        return redirect('/blog');
    }

    public static function modifyArticlePage($id){
        $article = DB::table('articles')->where('id', '=', $id)->first();
        return view('modifyArticle')->with(compact('article'));
    }

    public static function destroyArticle($id){
        DB::table('articles')->where('id','=',$id)->delete();
        return back();
    }

    public static function isTagOfArticle($article_id, $tag_id){
        if(DB::table('article_tag')->where('article_id', '=', $article_id)->where('tag_id', '=', $tag_id)->count() != 0){
            return true;
        }
        else return false;
    }

    public static function modifyArticle($id, Request $request){
        $request->validate([
            'title' => ['string', 'max:127'],
            'article_text' => ['string'],
            'articleImage' => 'image|mimes:jpeg|max:16384',
        ]);

        $user = Auth::user();

        if(GroupController::isAdmin($user->id)) {
            $article = new Article();
            $article->title = $request->title;
            $article->article_text = $request->article_text;

            $data=array(
                'title' => $article->title,
                'article_text' => $article->article_text,
            );

            DB::table('articles')->where('id', '=', $id)->update($data);


            if($request->has('Animation')){
                if(!self::isTagOfArticle($id, 13)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 13;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 13)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 13)->delete();
                }
            }

            if($request->has('Comiccon')){
                if(!self::isTagOfArticle($id, 11)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 11;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 11)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 11)->delete();
                }
            }

            if($request->has('Cosplay')){
                if(!self::isTagOfArticle($id, 9)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 9;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 9)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 9)->delete();
                }
            }

            if($request->has('DC')){
                if(!self::isTagOfArticle($id, 7)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 7;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 7)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 7)->delete();
                }
            }

            if($request->has('Design')){
                if(!self::isTagOfArticle($id, 12)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 12;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 12)->delete();
            }

            if($request->has('Digital_Art')){
                if(!self::isTagOfArticle($id, 3)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 3;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 3)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 3)->delete();
                }
            }

            if($request->has('Fan_Art')){
                if(!self::isTagOfArticle($id, 4)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 4;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 4)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 4)->delete();
                }
            }

            if($request->has('Humor')){
                if(!self::isTagOfArticle($id, 10)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 10;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 10)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 10)->delete();
                }
            }

            if($request->has('Illustrazioni')){
                if(!self::isTagOfArticle($id, 2)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 2;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 2)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 2)->delete();
                }
            }

            if($request->has('Italiano')){
                if(!self::isTagOfArticle($id, 8)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 8;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 8)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 8)->delete();
                }
            }

            if($request->has('Manga')){
                if(!self::isTagOfArticle($id, 5)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 5;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 5)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 5)->delete();
                }
            }

            if($request->has('Marvel')){
                if(!self::isTagOfArticle($id, 6)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 6;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 6)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 6)->delete();
                }
            }

            if($request->has('Novità')){
                if(!self::isTagOfArticle($id, 1)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 1;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 1)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 1)->delete();
                }
            }

            if($request->has('Original_Character')){
                if(!self::isTagOfArticle($id, 14)){
                    $tagA = new Tag();
                    $tagA->article_id = $id;
                    $tagA->tag_id = 14;
                    $tagDataA = array(
                        'tag_id' => $tagA->tag_id,
                        'article_id' => $tagA->article_id,
                    );
                    DB::table('article_tag')->insert($tagDataA);
                }
            }
            else{
                if(self::isTagOfArticle($id, 14)){
                    DB::table('article_tag')->where('article_id', '=', $id)->where('tag_id', '=', 14)->delete();
                }
            }

            if($request->has('articleImage')){
                DB::table('article_images')->where('article_id', '=', $id)->delete();
                ArticleImageController::moveFileCover($request, $id);
            }

            return redirect('/blogDetail/'.$id);
        }
        else {
            return redirect('/login');
        }
    }
}
