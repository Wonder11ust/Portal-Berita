<?php

namespace App\Http\Controllers\API;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiNewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        $response = [
            'message'=> 'Data Berita',
            'news'=> $news
        ];
        return response()->json($response,200);
    }
}
