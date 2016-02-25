<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $guarded = [];


    public function articles()
    {
        // $category->articles 即可拿到该栏目下的所有文章
        return $this->hasMany(Article::class);
    }

    // 推荐分类
    public function scopeRecommend($query)
    {
        return $query->where('slug', 'recommend');
    }

    // 其他分类
    public function scopeOther($query)
    {
        return $query->where('slug', 'other');
    }
}
