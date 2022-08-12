<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Comment::get(),200);
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


        $comment = Comment::create($request->all());
        return response()->json($comment,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::find($id);
        if(is_null($comment)){
            return response()->json(["message"=>'Record not found'],404);
        }
        return response()->json(Comment::find($id),200);
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
        $comment = Comment::find($id);
        if(is_null($comment)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $comment -> update($request -> all());
        return response()->json($comment,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if(is_null($comment)){
            return response()->json(["message"=>'Record not found'],404);
        }
        $comment-> delete();
        return response()->json(null,204);
    }

    public static function getcommentsByArticleId($id){
        return DB::table("comments")->where("article_id", "=", $id)->get();
    }

    public static function getArticleIdBycommentId($id){
        return DB::table('comments')->where("id", "=", $id)->first();
    }

    public function addToArticle(Article $article, Request $request){
        $request->validate([
            'comment_text' => ['required'],
        ]);
        $user = \Illuminate\Support\Facades\Auth::user();

        $comment = new Comment(); //per evitare problemi con campi che non appartengono effettivamente a paymentMethod.
        $comment->user_id = \Illuminate\Support\Facades\Auth::user()->id;
        $comment->article_id = $article->id;
        $comment->answer = $request->comment_text;

        $data=array(
            'user_id'=> $comment->user_id,
            'article_id' => $comment->article_id,
            'answer' => $comment->answer
        );

        DB::table('comments')->insert($data);


        return redirect()->back();
    }

    public function addToComment(int $id, Request $request){
        $request->validate([
            'answer' => ['required'],
        ]);

        $article = CommentController::getArticleIdBycommentId($id);


        $comment = new Comment(); //per evitare problemi con campi che non appartengono effettivamente a paymentMethod.
        $comment->user_id = \Illuminate\Support\Facades\Auth::user()->id;
        $comment->article_id = $article->article_id;
        $comment->answer = $request->answer;
        $comment->parent_comment = $id;

        $data=array(
            'user_id'=> $comment->user_id,
            'article_id' => $comment->article_id,
            'answer' => $comment->answer,
            'parent_comment' => $comment->parent_comment,
        );

        $comment_id = Comment::create($data);

        $parent = CommentController::getParent($comment_id->parent_comment);
        $answers = CommentController::answers($parent->id);

        foreach ($answers as $answer){
            if($answer->user_id != $comment->user_id && $answer->user_id != $parent->user_id) {

                $data2 = array(
                    'user_id' => $answer->user_id,
                    'notification_text' => 'Un tuo commento ha ricevuto una risposta',
                    'state' => '0',
                    'notification' => 'blogDetail',
                    'idLink' => $comment->article_id,
                );

                DB::table('notifications')->insert($data2);
            }
        }
        if($parent->user_id != $comment->user_id) {

            $data2 = array(
                'user_id' => $parent->user_id,
                'notification_text' => 'Un tuo commento ha ricevuto una risposta',
                'state' => '0',
                'notification' => 'blogDetail',
                'idLink' => $comment->article_id,
            );

            DB::table('notifications')->insert($data2);
        }



        return redirect()->back();
    }

    public static function answers($id){
        return DB::table('comments')->where("parent_comment", "=", $id)->get();
    }

    public static function destroyComment($id){
        $answers = CommentController::answers($id);
        foreach($answers as $answer){
            DB::table("comments")->where("id", "=", $answer->id)->delete();
        }
        DB::table("comments")->where("id", "=", $id)->delete();

        return redirect()->back();
    }

    public static function destroyAnswer($id){
        DB::table("comments")->where("id", "=", $id)->delete();
        return redirect()->back();
    }

    public static function getParent($id){
        if($id != 0) {
            return DB::table('comments')->where('id', '=', $id)->first();
        }
    }
}
