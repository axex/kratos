<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function publishingArticles()
    {
        return $this->morphedByMany(PublishingArticle::class, 'taggable', 'taggables', 'tag_id', 'taggable_id');
    }

    public function contributeArticles()
    {
        return $this->morphedByMany(ContributeArticle::class, 'taggable');
    }
}
