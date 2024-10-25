<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'holder' => 'required|string|max:128',
            'group' => 'required|boolean', // in:A,B
            'status' => 'required|in:em andamento,finalizado,cancelado',
            'statusDescription' => 'required|string|max:1000', // nullable? // min?
            'projectistObservation' => 'required|string|max:1000',
            'isInspectionRequested' => 'required|boolean',
        ];
    }
}
