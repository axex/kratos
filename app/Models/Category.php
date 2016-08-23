<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $table = 'categories';

    protected $guarded = [];


    public function articles()
    {
        // $category->articles 即可拿到该栏目下的所有文章
        return $this->hasMany(PublishingArticle::class);
    }
}
