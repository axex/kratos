<?php

namespace App\Http\Requests;

class BaseRequest extends Request
{
    public function all()
    {
        return $this->formatRequest();
    }

    protected function formatRequest()
    {
        $func = function ($value) {
            return strip_tags($value);
        };

        $request = array_map('trim', parent::all());
        $request = array_map($func, $request);

        // 替换掉原 request 里面的数据, 不然会出现 $request->all() 是处理过的数据, $request->get('xx') 是未处理的数据
        $this->replace($request);

        return parent::all();
    }
}
