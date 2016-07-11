<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

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
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    // 判断文章是否审核通过
    public function scopeIsCheck($query, $type)
    {
        return $query->where('is_check', $type);
    }

}
