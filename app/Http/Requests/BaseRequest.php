<?php

namespace App\Http\Requests;

class BaseRequest extends Request
{
    public function formatRequest()
    {
        $request = array_map('trim', parent::all());
        $this->replace($request);

        return parent::all();
    }
}
