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
        $name = isset($request->name) ? $request->name : '';
        return BrandResource::collection(Brand::when($name, function($q) use ($name){
            $q->where('name', 'like', '%'.$name.'%');
        })->orderByDesc('id')->paginate(10));
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

    public function update(BrandFromRequest $request, Brand $brand){
        try {
            $brand = $brand->update([
                'name' => $request->name,
                'updated_by' => auth('api')->user()->id,
            ]);
            if($brand)
            {
                return $this->sendSuccessResponse($brand,'Data Has Been Updated');
            }else{
                return $this->sendErrorResponse([],'Faild To Save Updated');
            }
        } catch (\Throwable $th) {
            return $this->sendErrorResponse([], $th->getMessage());
        }
    }

    public function destroy(Brand $brand){
        try {
            $brand = $brand->delete();
            if($brand)
            {
                return $this->sendSuccessResponse($brand,'Data Has Been Deleted');
            }else{
                return $this->sendErrorResponse([],'Faild To Save Deleted');
            }
        } catch (\Throwable $th) {
            return $this->sendErrorResponse([], $th->getMessage());
        }
    }


}
