<?php

namespace App\Http\Controllers\API\V1\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{ 
    public function index(Request $request){
        $data = Category::orderBy('id','desc')->paginate(10);
        return CategoryResource::collection($data);
    }
}
