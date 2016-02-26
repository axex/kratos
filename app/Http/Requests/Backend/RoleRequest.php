<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class RoleRequest extends Request
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
            'name' => 'required|regex:/^[A-Za-z]+$/|unique:roles,name',
            'display_name' => 'required',
            'description'  => 'max:200',
        ];
        if ($this->segment(3)) {
            $id = $this->segment(3);
            $rules['name'] .= ",{$id},id";
        }
        return $rules;
    }
}