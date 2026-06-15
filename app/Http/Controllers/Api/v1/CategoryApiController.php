<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryApiController extends Controller
{
     public function index()
    {
        $categories = Category::orderBy('id','desc')->get();
        return response()->json(['ok'=>true,'data'=>$categories]);
    }
    // CREATE
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'CategoryName'  => 'required|string|max:120',
            'CategoryImage' => 'nullable|string|max:255',
        ]);

        $category = Category::create($data);

        return response()->json([
            'ok'      => true,
            'message' => '✅ Category created successfully!',
            'data'    => $category
        ], 201);
    }

}
