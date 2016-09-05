<?php

namespace App\Models;

class SystemLog extends BaseModel
{
    protected $table = 'system_logs';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
