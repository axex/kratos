<?php

namespace App\Models;

class PublishingArticle extends BaseModel
{
    protected $table = 'publishing_articles';
    protected $guarded = [];

    public function category()
    {
        // $article->category 拿到文章所属的栏目
        return $this->belongsTo(Category::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
    
    public function tags()
    {
        // withTimestamps() 用来同步时间, 不然在 article_tag 表里面时间的空的
        return $this->belongsToMany(PublishingTag::class, 'publishing_article_tag', 'article_id', 'tag_id')->withTimestamps();
    }

}
