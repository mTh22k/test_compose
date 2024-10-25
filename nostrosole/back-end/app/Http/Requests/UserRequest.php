<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        switch ($this->method()){
            case 'PUT':
                return [
                    'email'             =>      'unique:users,email,$this->id,id',
                    'company'           =>      'required|string|max:255',
                    'cnpj'              =>      'required|string|max:255|regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/',
                    'cep'               =>      'required|string|max:255|regex:/^\d{5}-\d{3}$/',      
                    'city_state'        =>      'required|string|max:255',
                    'neighborhood'      =>      'required|string|max:255',
                    'street'            =>      'required|string|max:255',
                    'addressNumber'      =>     'required|string|max:6',
                    'additionalAddress'  =>     'required|string|max:255',
                    'phone'             =>      'required|string|max:255|regex:/^\(\d{2}\) \d{4,5}-\d{4}$/',
                    'name'              =>      'required|string|max:128',
                    'cpf'               =>      'required|string|max:255|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                    'admin'             =>      'required|boolean',
                ];
                break;
            default:
                return [
                    'email'             =>      'required|email|unique:users,email',
                    'company'           =>      'required|string|max:255',
                    'cnpj'              =>      'required|string|max:255|regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/',
                    'cep'               =>      'required|string|max:255|regex:/^\d{5}-\d{3}$/',      
                    'city_state'        =>      'required|string|max:255',
                    'neighborhood'      =>      'required|string|max:255',
                    'street'            =>      'required|string|max:255',
                    'addressNumber'      =>     'required|string|max:6',
                    'additionalAddress'  =>     'required|string|max:255',
                    'phone'             =>      'required|string|max:255|regex:/^\(\d{2}\) \d{4,5}-\d{4}$/',
                    'name'              =>      'required|string|max:128',
                    'cpf'               =>      'required|string|max:255|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                    'admin'             =>      'required|boolean',

                ];
        }
    }
}
