<?php

namespace App\Http\Requests;

class ProductCreateRequest extends ApiFormRequest
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
        return [
            'title' => 'required|string|min:3|max:50',
            'slug' => 'nullable|string|unique:products|max:60',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
        ];
    }
}
