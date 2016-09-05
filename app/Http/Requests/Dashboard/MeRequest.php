<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\BaseRequest;

class MeRequest extends BaseRequest
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
            'realname' => 'regex:/^([\w\x4e00-\x9fa5]{2,5})$/u',
            'email' =>  'required|email',
            'password' => 'confirmed|between:6,16',
        ];
    }
}