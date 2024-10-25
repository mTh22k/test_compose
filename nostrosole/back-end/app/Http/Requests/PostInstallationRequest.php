<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostInstallationRequest extends FormRequest
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
            'change_warning' => 'required|array',
            'change_warning.*.change_happened' => 'required|boolean',
            'change_warning.*.change' => 'nullable|string|max:2048',
            'change_warning.*.message' => 'required|string|max:2048',
            'project_id' => 'required|exists:projects,id',
            'pre_installation_id' => 'required|exists:pre_installations,id',
            'attachment_id' => 'nullable|exists:attachments,id',
        ];
    }
}
