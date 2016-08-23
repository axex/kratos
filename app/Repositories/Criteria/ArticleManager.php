<?php
namespace App\Repositories\Criteria;

use App\Repositories\Contracts\ArticleManagerInterface;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;

abstract class ArticleManager implements ArticleManagerInterface
{
    /**
     * @var
     */
    protected $app;

    /**
     * @var
     */
    protected $model;

    /**
     * ArticleManager constructor.
     * @param $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    abstract protected function model();

    /**
     * Creates instance of model.
     *
     * @throws \LogicException
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \LogicException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * 所有文章
     *
     * @param bool $with 关系预载入
     * @return mixed
     */
    public function all($with = false)
    {
        $articles = tap($this->model->latest(), function ($query) use ($with) {
            !$with ? : $query->with('category');
        })->paginate(\Cache::get('page_size', 10));
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
        $articles = $this->model->whereBetween('created_at', $values)->count();
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
        return $this->model->whereUrl($url)->first();
    }

    /**
     * 搜索文章
     *
     * @param $q
     * @return mixed
     */
    public function search($q)
    {
        $articles = $this->model->where('title', 'like', $q . '%')->paginate(\Cache::get('page_size', 10));
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
        $article = $this->model->create($attributes);
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
        $article = $this->model->findOrFail($id);

        return $article;
    }

    /**
     * 更新文章
     *
     * @param $article
     * @param array $attributes
     * @return mixed
     */
    public function update($article, array $attributes)
    {
        return $article->update($attributes);
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
        $this->model->whereIn('id', $values)->delete();
    }
}