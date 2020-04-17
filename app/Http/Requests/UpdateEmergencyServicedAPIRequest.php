<?php

namespace App\Http\Requests;

use App\Models\EmergencyServiced;
use InfyOm\Generator\Request\APIRequest;

class UpdateEmergencyServicedAPIRequest extends APIRequest
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
        $rules = EmergencyServiced::$rules;
        
        return $rules;
    }
}
