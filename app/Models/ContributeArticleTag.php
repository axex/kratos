<?php

namespace App\Models;

class ContributeArticleTag extends BaseModel
{
    protected $table = 'contribute_article_tag';
    protected $guarded = [];

    public function articles()
    {
        return $this->belongsToMany(ContributeArticle::class, 'contribute_article_tag', 'tag_id', 'article_id')->withTimestamps();
    }
}
