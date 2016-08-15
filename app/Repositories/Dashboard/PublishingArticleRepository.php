<?php
namespace App\Repositories\Dashboard;

use App\Models\PublishingArticle;
use App\Models\PublishingTag;

class PublishingArticleRepository
{
    protected $article;
    protected $tag;
    protected $isCheck = 1;

    /**
     * PublishingArticleRepository constructor.
     * @param PublishingArticle $article
     * @param PublishingTag $tag
     */
    public function __construct(PublishingArticle $article, PublishingTag $tag)
    {
        $this->article = $article;
        $this->tag = $tag;
    }

    public function all()
    {
        $articles = $this->article->isCheck($this->isCheck)->latest()->paginate(\Cache::get('page_size', 10));
        return $articles;
    }

    /**
     * 指定时间内的文章数
     *
     * @param array $values
     * @return mixed
     */
    public function count(array $values)
    {
        $articles = $this->article->isCheck($this->isCheck)->whereBetween('created_at', $values)->count();
        return $articles;
    }

    /**
     * 搜索文章
     *
     * @param $q
     * @return mixed
     */
    public function search($q)
    {
        $articles = $this->article->where('title', 'like', $q . '%')->isCheck($this->isCheck)->paginate(\Cache::get('page_size', 10));
        return $articles;
    }

    /**
     * 新建文章
     *
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes = [])
    {
        $article = $this->article->create($attributes);
        return $article;
    }

    public function findOrFail($id)
    {
        $article = $this->article->findOrFail($id);
        return $article;
    }

    /**
     * 更新或新建标签
     *
     * @param array $tags
     * @param PublishingArticle $article
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