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
        $trim = function ($value) use (&$trim) {
            if (!is_array($value)) {
                return trim($value);
            }

            return array_map($trim, $value);
        };

        // 递归处理空格
        $request = $trim(parent::all());

        // 递归删除 html php 标签
        $request = $this->stripTags($request);

        // 替换掉原 request 里面的数据, 不然会出现 $request->all() 是处理过的数据, $request->get('xx') 是未处理的数据
        $this->replace($request);

        return parent::all();
    }

    private function stripTags($value){

        if (!is_array($value)) {
            return strip_tags($value);
        }

        return array_map([$this, 'stripTags'], $value);
    }
}
