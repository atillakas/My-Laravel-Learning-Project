<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProductRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        //if slug is empty assign name value to slug
        if (!$this->slug) {
            $this->merge([
                'slug' => Str::slug($this->name)
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $categoryId = $this->route('product');
        return [
            'name' => [
                'required',
                'max:255',
                'min:5',
                // Rule::unique('categories')->ignore($categoryId),
            ],
            'slug' => [
                'max:255',
                'min:5',
                // Rule::unique('categories')->ignore($categoryId),
            ],
            'description' => 'nullable',
            'image_alt_text' => 'nullable',
            'parent_id' => 'numeric|nullable',
            'image' => 'mimes:jpeg,jpg,png',
            'productCategoryId.*'=>'numeric|nullable'
        ];
    }
}
