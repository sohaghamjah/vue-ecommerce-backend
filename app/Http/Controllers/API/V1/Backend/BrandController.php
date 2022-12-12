<?php

namespace App\Http\Controllers\API\V1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\Backend\ApiController;
use App\Http\Requests\Admin\BrandFromRequest;
use App\Http\Resources\Brand\BrandResource;
use App\Models\Brand;

class BrandController extends ApiController
{
    public function index(Request $request){
        return BrandResource::collection(Brand::orderByDesc('id')->paginate(10));
    }

    public function store(BrandFromRequest $request){
        try {
            $collection = collect($request->validated());
            $collection = $collection->merge(['created_by' => auth('api')->user()->id]);
            $brand = Brand::create($collection->all());
            if($brand)
            {
                return $this->sendSuccessResponse($brand,'Data Has Been Saved');
            }else{
                return $this->sendErrorResponse([],'Faild To Save Data');
            }
        } catch (\Throwable $th) {
            return $this->sendErrorResponse([], $th->getMessage());
        }
    }


}
