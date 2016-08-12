<?php

namespace App\Http\Requests\Dashboard;

use App\Http\Requests\BaseRequest;

class ArticleRequest extends BaseRequest
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

    /**
     * 重写 all 方法
     *
     * @return array|\Closure
     */
    public function all()
    {
        $request = $this->formatRequest();
        // 中文逗号改为英文 && 去除字符首尾的逗号
        $request['tag'] = trim(str_replace('，', ',', $request['tag']), ',');
        $func = function ($value) {
            return strip_tags($value);
        };
        $request = array_map($func, $request);

        // 替换掉原 request 里面的数据, 不然会出现 $request->all() 是处理过的数据, $request->get('xx') 是未处理的数据
        $this->replace($request);

        return $request;
    }
}
