<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Advertisement extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => ['required', 'string', 'min:4', 'max:100'],
            'description' => ['required', 'string', 'min:10', 'max:500'],
            'price' => ['required', 'numeric', 'min:1', 'max:100000'],
            'category_id' => 'required',
        ];
        $photos = count($this->file('photos'));
        foreach(range(0, $photos) as $index) {
            $rules['photos.' . $index] = 'required|image|mimes:jpg,jpeg,bmp,png|max:2000';
        }
        return $rules;
    }
}
