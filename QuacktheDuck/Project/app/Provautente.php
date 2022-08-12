<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtenteModel extends Model
{
    public $timestamps = false;
    protected $table = "users";
    protected $fillable = [
        'name','surname', 'email', 'password', 'university','course'
    ];
    public function upload(Request $request)
    {
        if(!$request->hasFile(‘data’)) {
            return response()->json([‘upload_file_not_found’], 400);
        }  $file = $request->file(‘data’);  if(!$file->isValid()) {
        return response()->json([‘invalid_file_upload’], 400);
    }  $path = public_path() . ‘/uploads/’;
        $file->move($path, $file->getClientOriginalName() );  return response()->json(compact(‘path’));
    }
}
