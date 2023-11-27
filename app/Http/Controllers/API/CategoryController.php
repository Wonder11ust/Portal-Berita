<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        //$categories = Category::with('articles.user')->get();
       $categories = Category::all();
        return response()->json([
            'status'=>200,
            'message'=>"Data Kategori",
            'categories'=>$categories
        ]);
    }

    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'category_name'=>'required|unique:categories'
        ]);

        try {
            Category::create($validatedData);
             return response()->json([
                'status'=>200,
                'message'=>'Category Baru Berhasil ditambahkan',
        ],200);
        } catch (QueryException $e) {
            return response()->json([
                'message'=>'Failed'.$e->errorInfo,

            ]);
        }
    }

    public function show(Category $category)
    {
        //$articles = $category->articles;
        $categoryWithArticles = $category->load('articles');

        return response()->json([
            'status'=>200,
            'category'=>$categoryWithArticles,
            // 'articles'=>$articles
        ]);
    }

    public function show2(Category $category)
    {
    return  new CategoryResource($category);
    }
}
