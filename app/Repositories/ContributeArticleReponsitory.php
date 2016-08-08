<?php
namespace App\Repositories;

use App\Models\ContributeArticle;
use App\Models\ContributeTag;

class ContributeArticleReponsitory
{
    protected $article;
    protected $tag;


    /**
     * ContributeArticleReponsitory constructor.
     * @param ContributeArticle $article
     * @param ContributeTag $tag
     */
    public function __construct(ContributeArticle $article, ContributeTag $tag)
    {
        $this->article = $article;
        $this->tag = $tag;
    }

    public function checkUrl($url)
    {
        return $this->article->whereUrl($url)->first();
    }

    public function create(array $attributes = [])
    {
        return $this->article->create($attributes);
    }

    public function updateOrCreateTags(array $attributes = [])
    {
        return $this->tag->updateOrCreate($attributes);
    }

    protected function getTagIds($tags)
    {
        $existingTags = $this->tag->whereIn('name', $tags)->get();
        $newTags = array_diff($tags, $existingTags->lists('name')->all());
        $newIds = $this->multiInsert($newTags);
        return array_merge($existingTags->lists('id')->all(), $newIds);
    }

    protected function multiInsert(array $tags)
    {
        $tagsId = [];
        foreach ($tags as $name) {
            $tag = $this->tag->firstOrCreate(['name' => $name]);
            $tagsId[] = $tag->id;
        }
        return $tagsId;
    }
}