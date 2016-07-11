<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\Request;
use Carbon\Carbon;

class IssueRequest extends Request
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
            'issue' => 'required|numeric|unique:issues',
            'published_at' => 'date',
        ];
        if ($this->segment(3)) {
            $id = $this->segment(3);
            $rules['issue'] .= ",{$id},id";
        }
        return $rules;
    }
}
