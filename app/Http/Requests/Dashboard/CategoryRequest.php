<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\BaseRequest;

class CategoryRequest extends BaseRequest
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
            'name' => 'required|max:20|unique:categories,name',
            'slug' => 'regex:/^[A-Za-z0-9]+$/',
            'desc' => 'max:255'
        ];
        /*
         * update 操作
         * 更新时验证分类名要把自己的排除在外, 不然会出现只更新分类描述, 但是因为分类名重复导致验证失败
         * segment() 获取路由参数
         */
        if ($this->segment(3)) {
            $id = $this->segment(3);
            $rules['name'] .= ",{$id},id";
        }
        return $rules;
    }
}
