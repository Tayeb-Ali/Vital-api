<?php

namespace App\Http\Requests;

use App\Models\Pharmacy;
use InfyOm\Generator\Request\APIRequest;

class UpdatePharmacyAPIRequest extends APIRequest
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
        $rules = Pharmacy::$rules;
        
        return $rules;
    }
}
