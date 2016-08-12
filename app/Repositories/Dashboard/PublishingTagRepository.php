<?php
namespace App\Repositories\Dashboard;

use App\Models\PublishingTag;

class PublishingTagRepository
{
    protected $tag;

    /**
     * TagRepository constructor.
     * @param $tag
     */
    public function __construct(PublishingTag $tag)
    {
        $this->tag = $tag;
    }

    public function firstOrCreate(array $attributes)
    {
        return $this->tag->firstOrCreate($attributes);
    }

}