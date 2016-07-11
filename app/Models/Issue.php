<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issues';

    protected $guarded = [];

    // 把 published_at 当作 Carbon 类型，这样后面对时间处理方便很多
    protected $dates = ['published_at'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function scopePublished($query)
    {
        $query->where('published_at', '<=', Carbon::now());
    }
}
