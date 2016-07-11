<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $table = 'system_logs';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
