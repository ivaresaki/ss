<?php

namespace Org\Jvhsa\Surgiscript\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteRegistrationRequest extends FormRequest
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
            'name' => 'required',
            'address' => 'required',
            'poc_name' => 'required',
            'poc_email' => 'required',
            'poc_phone' => 'required' 
        ];
    }
}
