<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryRequest extends FormRequest
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
        $productId = $this->route('product');
        return [
            'name' => [
                'required',
                'max:255',
                'min:5',
                Rule::unique('products')->ignore($productId),
            ],
            'slug' => [
                'max:255',
                'min:5',
                Rule::unique('products')->ignore($productId),
            ],
            'description' => 'nullable',
            'image' => 'mimes:jpeg,jpg,png',
            'image_alt_text' => 'nullable',
            'parent_id' => 'numeric|nullable',
        ];
    }
}
