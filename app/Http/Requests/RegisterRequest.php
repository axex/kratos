<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\User;

class RegisterRequest extends Request
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
            'username' => 'required_with:username|alpha_dash|between:3,16|unique:users',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|between:6,16',
        ];
        if ($this->exists('reset_code')) {
            $user = User::where('reset_code', $this->input('reset_code'))->first();
            $rules['email'] .= ",{$user->id},id";
        }
        return $rules;

    }
}
