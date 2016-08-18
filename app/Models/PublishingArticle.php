<?php

namespace App\Models;

use App\Models\Traits\Taggable;
use App\Services\Tag\TaggableInterface;

class PublishingArticle extends BaseModel implements TaggableInterface
{
    use Taggable;

    protected $table = 'publishing_articles';

    protected $guarded = ['tags'];

    public function category()
    {
        // $article->category 拿到文章所属的栏目
        return $this->belongsTo(Category::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue', 'issue');
    }
}
