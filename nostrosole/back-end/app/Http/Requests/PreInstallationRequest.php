<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreInstallationRequest extends FormRequest
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

            // Dados UC
            'uc_data.nearest_post_number'   =>      'required|integer',
            'uc_data.cep'                   =>      'required|string|max:255|regex:/^\d{5}-\d{3}$/',
            'uc_data.city_state'            =>      'required|string|max:255',
            'uc_data.neighborhood'          =>      'required|string|max:255',
            'uc_data.street'                =>      'required|string|max:255',
            'uc_data.adressNumber'          =>      'required|string|max:6',
            'uc_data.additionalAddress'     =>      'required|string|max:255',
            'uc_data.latitude'              =>      'required|string|max:255',  
            'uc_data.longitude'             =>      'required|string|max:255',  
            'uc_data.google_maps_link'      =>      'required|string',

            // Padrão de Entrada
            'input_pattern.uc_number'                   =>  'required|integer',
            'input_pattern.connection_type'             =>  'required|string|in:monofasico rural,monofasico,bifasico,trifasico',
            'input_pattern.stardart_circuit_breaker'    =>  'required|string',  
            'input_pattern.tension'                     =>  'required|string|in:127V,220V',
            'input_pattern.maximum_uc_load'             =>  'required|string',
            'input_pattern.extension_type'              =>  'required|string|in:aereo,subterraneo',
            'input_pattern.cable_type'                  =>  'required|string|in:cobre,aluminio',
            'input_pattern.standard_cable_gauge'        =>  'required|integer',
            'input_pattern.cable_insulation'            =>  'required|string|in:PVC,HEPR/XLPE',
            'input_pattern.grouped_pattern'             =>  'required|string|in:sim,nao',

            // Quadro de Distribuição Geral (QDG)
            'qdg.circuit_breaker'               =>      'required|string', 
            'qdg.connection_type'               =>      'required|string|in:monofasico rural,monofasico,bifasico,trifasico',
            'qdg.tension'                       =>      'required|string|in:127V,220V',
            'qdg.maximum_uc_load'               =>      'required|string',
            'qdg.cable_type'                    =>      'required|string|in:cobre,aluminio',
            'qdg.standard_cable_gauge'          =>      'required|integer',
            'qdg.cable_insulation'              =>      'required|string|in:PVC,HEPR/XLPE',

            // Dados do Titular
            'holder_data.cpf'               =>      'required|string|max:255|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            'holder_data.name'              =>      'required|string|max:128',
            'holder_data.email'             =>      'required|email',
            'holder_data.phone'             =>      'required|string|max:255|regex:/^\(\d{2}\) \d{4}-\d{4}$/', //(XX) XXXX-XXXX
            'holder_data.cellphone'         =>      'required|string|max:255|regex:/^\(\d{2}\) \d{5}-\d{4}$/', //(XX) XXXXX-XXXX
            'holder_data.cep'               =>      'required|string|max:255|regex:/^\d{5}-\d{3}$/',
            'holder_data.city_state'        =>      'required|string|max:255',
            'holder_data.neighborhood'      =>      'required|string|max:255',
            'holder_data.street'            =>      'required|string|max:255',
            'holder_data.adressNumber'      =>      'required|string|max:6',
            'holder_data.additionalAddress' =>     'required|string|max:255',

            // Dados do telhado da UC
            'roof_data.*.type'                    =>  'required|string|in:colonial(telha ceramica),Fibrocimento Ondulado,Metálico Ondulado,Metálico Trapezoidal,Laje,CARPORT,Solo Monoposte,Solo Biposte',
            'roof_data.*.arrangement_number'      =>  'required|integer',
            'roof_data.*.modules_per_arrangement' =>  'required|integer'
        ];
    }
}
