<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\Traits\ArticleManager;
use App\Http\Requests\Dashboard\ArticleRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\IssueRepository;
use App\Repositories\PublishingArticleRepository;
use App\Http\Controllers\Controller;

class AdminArticleController extends Controller
{
    use ArticleManager;

    /**
     * AdminArticleController constructor.
     * @param PublishingArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @param IssueRepository $issueRepository
     */
    public function __construct(
        PublishingArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        IssueRepository $issueRepository
    ) {
        $this->middleware('deny403', ['except' => 'index']);
        $this->indexView = 'dashboard.article.index';
        $this->indexRoute = 'dashboard.dashboard.article.index';
        $this->editView = 'dashboard.article.edit';
        $this->withCategory = ['category'];
        $this->filterIssueAndCategory = true;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->issueRepository = $issueRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->categoryRepository->all();
        $issues = $this->issueRepository->all([], 'issue');

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

        return redirect(route($this->indexRoute))->with('message', trans('validation.notice.publish_success'));
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

        $status = $this->articleRepository->update($request->all(), $article->id);

        if (! $status) {
            return back()->with('fail', trans('validation.notice.database_error'));
        }

        $this->syncTags($article, $request->get('tags'));

        return redirect(route($this->indexRoute))->with('message', trans('validation.notice.update_article_success'));
    }
}
