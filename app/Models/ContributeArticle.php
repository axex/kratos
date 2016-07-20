<?php

namespace App\Models;

class ContributeArticle extends BaseModel
{
    protected $table = 'contribute_articles';
    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(ContributeTag::class, 'contribute_article_tag', 'article_id', 'tag_id')->withTimestamps();
    }
}
