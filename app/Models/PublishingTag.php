<?php

namespace App\Models;

class PublishingTag extends BaseModel
{
    protected $table = 'publishing_tags';

    protected $fillable = ['name'];

    public function articles()
    {
        return $this->belongsToMany(PublishingArticle::class, 'publishing_article_tag', 'tag_id', 'article_id')->withTimestamps();
    }
}
