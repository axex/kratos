<?php

namespace App\Http\Requests;

class SubmissionRequest extends BaseRequest
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
            'title' => 'required|max:100',
            'url' => 'required|url|max:256',
            'desc' => 'max:512',
            'tags' => 'max:64'
        ];
    }

    /**
     * 重写 all 方法
     *
     * @return array
     */
    public function all()
    {
        $request = parent::all();

        // 中文逗号改为英文 && 去除字符首尾的逗号
        $request['tags'] = trim(str_replace('，', ',', $request['tags']), ',');

        // 替换掉原 request 里面的数据, 不然会出现 $request->all() 是处理过的数据, $request->get('xx') 是未处理的数据
        $this->replace($request);

        return $request;
    }
}
