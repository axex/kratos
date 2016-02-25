<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class MeRequest extends Request
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