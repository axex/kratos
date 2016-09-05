<?php
namespace App\Services\Tag;

use App\Models\Tag;

class TagService
{
    protected $tag;

    /**
     * TagService constructor.
     * @param $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * 同步标签
     *
     * @param TaggableInterface $taggable
     * @param $tags
     */
    public function sync(TaggableInterface $taggable, $tags)
    {
        $tagIds = $this->getIds($tags);
        $taggable->tags()->sync($tagIds);
    }


    /**
     * 获取标签 id
     *
     * @param $tags
     * @return array
     */
    protected function getIds($tags)
    {
        $existingTags = $this->tag->whereIn('name', $tags)->get();
        $newTags = array_diff($tags, $existingTags->lists('name')->all());
        $newIds = $this->multiInsert($newTags);
        return array_merge($existingTags->lists('id')->all(), $newIds);
    }


    /**
     * 批量插入标签
     *
     * @param array $tags
     * @return array
     */
    protected function multiInsert(array $tags)
    {
        $tagItems = [];
        foreach ($tags as $name) {
            $tagItems[] = ['name' => $name];
        }
        $this->tag->insert($tagItems);

        $tagIds = $this->tag->whereIn('name', $tags)->get()->lists('id')->all();

        return $tagIds;
    }
}