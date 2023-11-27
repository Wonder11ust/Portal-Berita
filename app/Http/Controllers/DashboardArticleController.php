<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ArticleDetailResource;

class DashboardArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->id;
        $articles = Article::where('user_id',$user)->get();
        $art = ArticleResource::collection($articles);
        return response()->json([
            'status'=>200,
            'articles'=>$art
        ],200);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:articles',
            'slug' => 'required|unique:articles',
            'content' => 'required',
            'category' => 'required|array',
            'image_url'=>'required',
          
        ]);
        // $image = '';

        // if ($request->file) {
        //     $fileName = $this->generateRandomString();
        //     $extension = $request->file->extension();
        //     $image =$fileName.'.'.$extension;
        //     Storage::putFileAs('image', $request->file,$image);
        // }
        // $request['image_url']= $image;
        // $validatedData['image_url'] = $request['image_url'];

        $validatedData['user_id'] = Auth::user()->id;
     //   $validatedData['user_id'] = 4;
    
    
       
        // Buat artikel
        $article = Article::create($validatedData);
    
        // Sync kategori dengan artikel
        $article->categories()->sync($request->category);
    
        return response()->json([
            'status' => 200,
            'message' => 'Artikel Baru Berhasil Ditambahkan',
            'data' => $article
        ], 200);
    }




    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $art =  new ArticleDetailResource($article);
        //$comments = $article->comments;
         return response()->json([
             'status' => 200,
             'article' => $art,      
         ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $art =  new ArticleDetailResource($article);
        //$comments = $article->comments;
         return response()->json([
             'status' => 200,
             'article' => $art,      
         ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {

        $rules = [
            'title' => 'required|max:255',
            'category' => 'required|array',
            'image_url' => 'required',
            'content' => 'required'
        ];

        if ($request->slug != $article->slug) {
            $rules['slug'] = 'required|unique:articles';
        }

        $validatedData = $request->validate($rules);
        $validatedData['user_id'] =Auth::user()->id;
       

       // Article::where('id',$article->id)->update($validatedData);
     $article->update($validatedData);
     $article->categories()->sync($request->category);

        return response()->json([
            'status'=>200,
            'message'=>'Artikel Berhasil Di Update',
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Article::destroy($article->id);
        return response()->json([
            'status'=>200,
            'message'=>'Data Artikel Berhasil dihapus'
        ]);
    }

    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

   
}
