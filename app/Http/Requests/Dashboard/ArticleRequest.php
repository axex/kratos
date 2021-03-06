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
            'issue'      =>  'required|exists:issues,issue',
            'category_id'   =>  'required|exists:categories,id',
            'desc'          =>  'required|min:20',
            'url'           =>  'required|url'
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

        $request['tags'] = trim(str_replace('，', ',', $request['tags']), ',');

        $this->replace($request);

        return $request;
    }
}
