<?php

namespace Org\Jvhsa\Surgiscript\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteApprovalRequest extends FormRequest
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
            'slug' => 'required|unique:sites'
        ];
    }

    /**
 * Get the error messages for the defined validation rules.
 *
 * @return array
 */
    public function messages()
    {
        return [
            'slug.required' => 'Subdomain name is required',
            'slug.unique' => 'Subdomain unavailable'
        ];
    }
}
