<?php

namespace App\Http\Controllers\API\V1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\Backend\ApiController;
use App\Http\Resources\Brand\BrandResource;
use App\Models\Brand;

class BrandController extends ApiController
{
    public function index(Request $request){
        return BrandResource::collection(Brand::orderByDesc('id')->paginate(10));
    }
}
