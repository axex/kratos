<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContributeArticle extends Model
{
    protected $table = 'contribute_articles';
    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag')->withTimestamps();
    }
}
