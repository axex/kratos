<?php

namespace App\Models;

class Issue extends BaseModel
{
    protected $table = 'issues';
    protected $guarded = [];

    // 把 published_at 当作 Carbon 类型，这样后面对时间处理方便很多
    protected $dates = ['published_at'];

    public function articles()
    {
        return $this->hasMany(PublishingArticle::class);
    }
}
