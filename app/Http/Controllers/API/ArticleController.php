<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ArticleCategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleDetailResource;

class ArticleController extends Controller
{
 
    // public function index()
    // {
    //     $articles = Article::latest()->filter(request(['search','category']))->paginate(7)->withQueryString();
    //     $articlesRes = ArticleResource::collection($articles);
    //   //  $artCollection = new ArticleCollection(Article::paginate(3));
    //     return response()->json([
    //         'status'=>200,
    //         'message'=>'Data Artikel',
    //         'articles'=>$articles
    //     ]);
    // }


    public function index()
    {
        $perPage = 7; // Sesuaikan dengan jumlah artikel per halaman yang Anda inginkan
    

        // Gunakan filter untuk mencari artikel berdasarkan 'search' dan 'category'
        $articles = Article::latest()
            ->filter(request(['search']))
            ->paginate($perPage)
            ->withQueryString();
    
        // Konversi hasil kueri ke dalam koleksi ArticleResource
        $articlesRes = ArticleResource::collection($articles);
    
        return response()->json([
            'status' => 200,
            'message' => 'Data Artikel',
            'articles' => $articlesRes,
        ]);
    }

    public function store(Request $request)
{
    // Validasi data
    $validatedData = $request->validate([
        'title' => 'required|unique:articles',
        'slug' => 'required|unique:articles',
        'content' => 'required',
        'category' => 'required|array',
       // 'category.*.id' => 'required|exists:categories,id',
        'image_url' => 'required',
        'user_id' => 'required',
    ]);


    //return $request->all();
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

  
    public function show(Article $article)
{
    $article->increment('views');
   $art =  new ArticleDetailResource($article->loadMissing('comments'));
   //$comments = $article->comments;
    return response()->json([
        'status' => 200,
        'article' => $art,      
    ]);
}


    public function update(Article $article,Request $request)
    {
       


        $validatedData = $request->validate([
            'title'=>'required|unique:articles',
            'slug'=>'required|unique:articles',
            'content'=>'required',
            'user_id'=>'required',
        ]);

       // $validatedData['user_id'] = $user->id;
       $article->update($validatedData);

        return response()->json([
            'status'=>200,
            'message'=>'Artikel Berhasil Di Update',
        ],200);
    }

    public function destroy(Article $article)
    {
        Article::destroy($article->slug);
        return response()->json([
            'status'=>200,
            'message'=>'Data Artikel Berhasil dihapus'
        ]);
    }
}
