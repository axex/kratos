<?php
namespace App\Repositories;

use App\Models\ContributeArticle;
use App\Models\ContributeTag;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * 检查投稿 url 是否已经提交过
     *
     * @param $url
     * @return mixed
     */
    public function checkUrl($url)
    {
        return $this->article->whereUrl($url)->first();
    }


    /**
     * 新建投稿文章
     *
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return $this->article->create($attributes);
    }


    /**
     * 更新或新建标签
     *
     * @param array $tags
     * @param ContributeArticle $article
     */
    public function updateOrCreateTags(array $tags = [], $article)
    {
        $tagIds = $this->getTagIds($tags);
        $article->tags()->attach($tagIds);
    }


    /**
     * 获取标签 id
     *
     * @param $tags
     * @return array
     */
    protected function getTagIds($tags)
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