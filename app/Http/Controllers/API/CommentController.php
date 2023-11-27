<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'article_id'=>'required',
            'comment'=>'required'
        ]);
        $validatedData['user_id'] = Auth::user()->id;
        $comment =Comment::create($validatedData);

        //return response()->json();
        return new CommentResource($comment->loadMissing(['user:id,name']));
        // return response()->json([
        //     'status'=>200,
        //     'message'=> 'Komentar Baru Berhasil Ditambahkan'
        // ]);
    }
}
