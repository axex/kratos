<?php

namespace App\Models;

use App\Models\Traits\Taggable;
use App\Services\Tag\TaggableInterface;

class ContributeArticle extends BaseModel implements TaggableInterface
{
    use Taggable;

    protected $table = 'contribute_articles';

    protected $guarded = ['tags'];

}
