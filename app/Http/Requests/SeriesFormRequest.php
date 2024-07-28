<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class SeriesFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'nome' => ['required', 'min:2'],
            'cover' => [
                File::image(),
            ],
            'seasonsQty' => ['required'],
            'episodesPerSeason' => ['required'],
        ];
    }
}
