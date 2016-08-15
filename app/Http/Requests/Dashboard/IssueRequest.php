<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\BaseRequest;

class IssueRequest extends BaseRequest
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
            'issue' => 'required|numeric|unique:issues,issue',
            'published_at' => 'date',
        ];
        if ($this->segment(3)) {
            $id = $this->segment(3);
            $rules['issue'] .= ",{$id},id";
        }
        return $rules;
    }
}
