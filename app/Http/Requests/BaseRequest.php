<?php

namespace App\Http\Requests;

class BaseRequest extends Request
{
    public function formatRequest()
    {
        $func = function ($value) {
            return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
        };
        $request = array_map('e', $this->all());
        $request = array_map('trim', $this->all());
        $this->replace($request);

        return $this->all();
    }
}
