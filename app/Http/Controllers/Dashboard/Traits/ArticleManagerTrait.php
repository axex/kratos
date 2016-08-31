<?php
namespace App\Http\Controllers\Dashboard\Traits;

use App\Services\Tag\TagService;
use Illuminate\Http\Request;

trait ArticleManagerTrait
{
    protected $indexView;

    protected $indexRoute;

    protected $editView;

    protected $articleRepository;

    protected $issueRepository;

    protected $categoryRepository;

    protected $withCategory = false;

    protected $filterIssueAndCategory = false;

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
            $articles = $this->articleRepository->all($this->withCategory);
        }
        return view($this->indexView, compact('articles'));
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

        $categories = $this->categoryRepository->all();

        $issues = $this->issueRepository->all();
        if ($this->filterIssueAndCategory) {
            // 排除掉当前目录和期数
            $categories = $categories->filter(function ($item) use ($article) {
                return $article->category_id != $item->id;
            });

            $issues = $issues->filter(function ($item) use ($article) {
                return $article->issue != $item->issue;
            });
        }

        return view($this->editView, compact('article', 'tags', 'categories', 'issues'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $status = $this->articleRepository->delete($id);

        if ($status) {
            return redirect()->route($this->indexRoute)->with('message', trans('validation.notice.delete_article_success'));
        }
        return redirect()->route($this->indexRoute)->with('fail', trans('validation.notice.database_error'));
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
        return redirect()->route($this->indexRoute)->with('message', trans('validation.notice.delete_article_success'));
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