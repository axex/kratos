<?php

namespace App\Models;

class ContributeArticle extends BaseModel
{
    protected $table = 'contribute_articles';
    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(ContributeTag::class, 'article_tag')->withTimestamps();
    }
}
