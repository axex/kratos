<?php
namespace App\Repositories\Traits;


trait ArticleManagerTrait
{
    protected $article;

    public function all()
    {
        $articles = $this->article->with('category')->latest()->paginate(\Cache::get('page_size', 10));
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
        $articles = $this->article->whereBetween('created_at', $values)->count();
        return $articles;
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
     * 搜索文章
     *
     * @param $q
     * @return mixed
     */
    public function search($q)
    {
        $articles = $this->article->where('title', 'like', $q . '%')->paginate(\Cache::get('page_size', 10));
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

    /**
     * 查找指定文章
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function findOrFail($id)
    {
        $article = $this->article->findOrFail($id);

        return $article;
    }

    /**
     * 删除单篇文章
     *
     * @param $id
     * @return bool|null
     */
    public function delete($id)
    {
        $article = $this->findOrFail($id);
        return $article->delete();
    }

    /**
     * 批量删除文章
     *
     * @param mixed $values
     */
    public function batchDelete($values)
    {
        $this->article->whereIn('id', $values)->delete();
    }
}