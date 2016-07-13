<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\Request;

class ArticleRequest extends Request
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
            'title'         =>  'required|max:80',
            'issue_id'      =>  'required|exists:issues,id',
            'category_id'   =>  'required|exists:categories,id',
            'desc'          =>  'required|min:20',
            'url'           =>  'required|url',
            'is_recomm'     =>  'boolean',
            'is_check'      =>  'boolean'
        ];
    }
}
