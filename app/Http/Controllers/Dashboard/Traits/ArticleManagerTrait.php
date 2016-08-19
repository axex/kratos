<?php
namespace App\Http\Controllers\Dashboard\Traits;

use App\Http\Requests\Dashboard\ArticleRequest;
use App\Services\Tag\TagService;
use Illuminate\Http\Request;

trait ArticleManagerTrait
{
    protected $indexView;

    protected $editView;

    protected $articleRepository;

    protected $issueRepository;

    protected $categoryRepository;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        if ($q) {
            $articles = $this->articleRepository->search($q);
        } else {
            $articles = $this->articleRepository->all();
        }
        return view($this->indexView, compact('articles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->categoryRepository->all();
        $issues = $this->issueRepository->all();
        return view('dashboard.article.create', compact('categories', 'issues'));
    }

    /**
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleRequest $request)
    {
        $article = $this->articleRepository->create($request->all());
        if (! $article) {
            return back()->with('fail', trans('validation.notice.database_error'));
        }

        $this->syncTags($article, $request->get('tags'));

        return redirect(route($this->indexView))->with('message', trans('validation.notice.publish_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑文章页面
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $article = $this->articleRepository->findOrFail($id);

        $tags = $article->tags->implode('name', ',');

        // 排除掉当前目录和期数
        $categories = $this->categoryRepository->filter($article->category_id);

        $issues = $this->issueRepository->filter($article->issue);

        return view($this->editView, compact('article', 'tags', 'categories', 'issues'));
    }

    /**
     * 更新文章
     *
     * @param ArticleRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleRequest $request, $id)
    {
        $article = $this->articleRepository->findOrFail($id);

        $status = $article->update($request->all());

        if (! $status) {
            return back()->with('fail', trans('validation.notice.database_error'));
        }

        $this->syncTags($article, $request->get('tags'));

        return redirect(route($this->indexView))->with('message', trans('validation.notice.update_article_success'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $status = $this->articleRepository->delete($id);

        if ($status) {
            return redirect()->route($this->indexView)->with('message', trans('validation.notice.delete_article_success'));
        }
        return redirect()->route($this->indexView)->with('fail', trans('validation.notice.database_error'));
    }

    /**
     * 批量删除
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function batchDelete(Request $request)
    {
        $checkedList = explode(',', $request->get('checkedList'));
        $this->articleRepository->batchDelete($checkedList);
        return redirect()->route($this->indexView)->with('message', trans('validation.notice.delete_article_success'));
    }

    /**
     * 同步标签
     *
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection $article
     * @param array | string $tags
     */
    protected function syncTags($article, $tags)
    {
        $explodeTags = explode(',', $tags);
        app(TagService::class)->sync($article, $explodeTags);
    }
}