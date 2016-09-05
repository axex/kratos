<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
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
        $rules = [
            'username' => 'required_with:username|alpha_dash|between:3,255|unique:users',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required_without:is_lock|confirmed|between:6,16',
            'role' => 'required|exists:roles,id',
            'realname' => 'regex:/^([\w\x4e00-\x9fa5]{2,5})$/u'
        ];
        if ($this->segment(3)) {
            $id = $this->segment(3);
            $rules['email'] .= ",{$id},id";
        }
        return $rules;
    }
}
