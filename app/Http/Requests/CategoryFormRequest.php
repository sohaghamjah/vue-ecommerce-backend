<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => ['required','unique:categories,name'],
            'slug' => ['required','unique:categories,slug'],
            'parent_id' => ['nullable'],
        ];
        if(request()->id)
        {
            $rules['name'][1] = 'unique:categories,name,'.request()->id;
            $rules['slug'][1] = 'unique:categories,slug,'.request()->id;
        }
        return $rules;
    }
}
