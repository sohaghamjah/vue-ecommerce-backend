<?php

namespace App\Http\Controllers\API\V1\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{ 
    public function index(Request $request){
        $name = isset($request->name) ? $request->name : '';
        $data = Category::when($name, function($q) use ($name){
            $q->where('name', 'like', '%'.$name.'%');
        })->orderBy('id','desc')->paginate(10);
        return CategoryResource::collection($data);
    }

    public function categoryList(){
        $categories = Category::select('id','name')->get();
        if(!$categories->isEmpty()){
            return $this->sendSuccessResponse($categories);
        }else{
            return $this->sendErrorResponse([], 'No Data Found!');
        }
    }

    public function store(CategoryFormRequest $request){
        try {
            $collection = collect($request->validated());
            $collection = $collection->merge(['created_by' => auth('api')->user()->id,'updated_by' => auth('api')->user()->id]);
            $category = Category::create($collection->all());
            if($category)
            {
                return $this->sendSuccessResponse($category,'Data Has Been Saved');
            }else{
                return $this->sendErrorResponse([],'Faild To Save Data');
            }
        } catch (\Throwable $th) {
            return $this->sendErrorResponse([],$th->getMessage());
        }
    }

    public function update(CategoryFormRequest $request, Category $category){
        try {
            $category_data = $category->update([
                'name'       => $request->name,
                'slug'       => $request->slug,
                'parent_id'  => $request->parent_id,
                'updated_by' => auth('api')->user()->id,
            ]);
            if($category_data){
                return $this->sendSuccessResponse($category_data, "Category updated successfull!");
            }else{
                return $this->sendErrorResponse([], 'Faield to save data!');
            }
        } catch (\Exception $th) {
            return $this->sendErrorResponse([],$th->getMessage());
        }
    }

    public function destroy(Category $category){
        try {
            $category = $category->delete();
            if($category){
                return $this->sendSuccessResponse($category, 'Data deleted succesffull!');
            }else{
                return $this->sendErrorResponse([], 'Failed to delete data!');
            }
        } catch (\Throwable $th) {
            return $this->sendErrorResponse([], $th->getMessage());
        }
    }
}
