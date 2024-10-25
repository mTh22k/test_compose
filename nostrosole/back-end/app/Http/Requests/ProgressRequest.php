<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgressRequest extends FormRequest
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
        return [
            'info'      =>      'required|string|max:256',
            'data'      =>      'required|date',
            'color'     =>      'required|string|in:verde,cinza,amarelo,vermelho',
        ];
    }
}
