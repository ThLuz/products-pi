<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules()
    {
        return [

            'title'=>'sometimes|min:3',

            'price'=>'sometimes|numeric|gt:0',

            'category'=>'sometimes|string'
        ];
    }
}